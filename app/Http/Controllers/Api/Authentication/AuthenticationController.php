<?php

namespace App\Http\Controllers\Api\Authentication;

use App\{Enums\StatusEnum,
    Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Api\Authentication\CheckUserNameRequest,
    Http\Requests\Api\Authentication\LoginRequest,
    Http\Requests\Api\Authentication\RefreshTokenRequest,
    Http\Requests\Api\Authentication\RegisterRequest,
    Http\Requests\Api\Authentication\SocialLoginRequest,
    Http\Requests\Api\Authentication\SocialRegisterRequest,
    Http\Resources\UserResource,
    Mail\OTPMail,
    Models\User,
    Services\UserService,
    Services\VerificationService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\{Http\Request,
    Support\Facades\Auth,
    Support\Facades\Config,
    Support\Facades\Crypt,
    Support\Facades\Log,
    Support\Facades\Mail,
    Validation\ValidationException};
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
    public function __construct(private readonly UserService $userService,
                                private readonly VerificationService $verificationService,)
    {
    }

    public function login(LoginRequest $request): Response
    {
        try {
            $credentials = $request->only(['phone', 'password']);

            if (!Auth::attempt($credentials)) {
                return Response::error(
                    message: __('auth.failed'),
                    status: HttpStatus::HTTP_UNAUTHORIZED
                );
            }

            $user = Auth::user();

            if ($user->status === StatusEnum::DELETED->value) {
                return Response::error(
                    message: __('auth.account_deleted'),
                    status: HttpStatus::HTTP_FORBIDDEN
                );
            }

            return Response::response(
                message: __('auth.logged_successfully'),
                data: [
                    'token' => $this->userService->revokeAndCreateToken(user: $user),
                    'user' => new UserResource(resource: $user),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Response::error(
                message: __('auth.login_error'),
                status: HttpStatus::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function register(RegisterRequest $request): Response
    {
        try {
            $user = User::where('phone', $request->phone)->where('verified', false)->first();

            if ($user) {
                $user = $this->userService->update(data: $request->validated(), id: $user->id);
            } else {
                $user = $this->userService->create(data: $request->validated());
            }

            $code = app()->isProduction() ? $this->verificationService->generateCode() : 1234;

            $this->verificationService->storeCode(user: $user, code: $code);

            $this->sendOtp($user, $code);

            return Response::response(
                message: __(key:'share.registered_successfully'),
                data: [
                    'token' => $this->userService->revokeAndCreateToken(user: $user),
                    'user' => new UserResource(resource: $user)
                ]
            );
        } catch (\Exception $e) {
            return Response::response(
                message: __('share.registration_failed'),
                errors: [$e->getMessage()],
                status: HttpStatus::HTTP_BAD_REQUEST
            );
        }
    }

    public function socialRegister(SocialRegisterRequest $request): Response
    {
        try {
            $user = $this->userService->findOrCreateSocialUser(
                provider: $request->provider,
                providerId: $request->provider_id,
                userData: $request->validated()
            );

            return Response::response(
                message: __(key:'share.registered_successfully'),
                data: [
                    'token' => $this->userService->revokeAndCreateToken(user: $user),
                    'user' => new UserResource(resource: $user)
                ]
            );
        } catch (\Exception $e) {
            return Response::response(
                message: __('share.registration_failed'),
                errors: [$e->getMessage()],
                status: HttpStatus::HTTP_BAD_REQUEST
            );
        }
    }

    public function socialLogin(SocialLoginRequest $request): Response
    {
        try {
            $user = User::where('provider', $request->provider)
                        ->where('provider_id', $request->provider_id)
                        ->first();

            if (!$user) {
                return Response::error(
                    message: __('auth.failed'),
                    status: HttpStatus::HTTP_UNAUTHORIZED
                );
            }

            if ($user->status === 'deleted') {
                return Response::error(
                    message: __('auth.account_deleted'),
                    status: HttpStatus::HTTP_FORBIDDEN
                );
            }

            return Response::response(
                message: __('auth.logged_successfully'),
                data: [
                    'token' => $this->userService->revokeAndCreateToken(user: $user),
                    'user' => new UserResource(resource: $user),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Response::error(
                message: __('auth.login_error'),
                status: HttpStatus::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function checkUsername(CheckUserNameRequest $request): Response
    {
        $exists = User::where('username', $request->username)->exists();

        return Response::response(
            message: $exists ? __('auth.username_taken') : __('auth.username_available'),
            data: [
                'available' => !$exists
            ]
        );
    }

    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google','apple'])) {
            return Response::error(
                message: 'Invalid social provider',
                status: HttpStatus::HTTP_BAD_REQUEST
            );
        }

        try {
            return match($provider) {
                'google' => Socialite::driver('google')
                    ->with(['prompt' => 'select_account'])
                    ->redirect(),
                'apple' => Socialite::driver('apple')
                    ->scopes(['name', 'email'])
                    ->redirect(),
            };
        } catch (\Exception $e) {
            Log::error("Failed to redirect to {$provider}", ['error' => $e->getMessage()]);
            return Response::error(
                message: __('auth.redirect_failed', ['provider' => ucfirst($provider)]),
                status: HttpStatus::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function handleProviderCallback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            if (!$socialUser->getEmail()) {
                return Response::error(
                    message: __('auth.email_permission_denied'),
                    status: HttpStatus::HTTP_INTERNAL_SERVER_ERROR
                );
            }
            $existingUser = User::where('email', $socialUser->getEmail())
                ->where('provider', '!=', $provider)
                ->first();

            if ($existingUser) {
                return Response::error(
                    message: __('auth.email_already_exists'),
                    status: HttpStatus::HTTP_CONFLICT
                );
            }

            $userData = [
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'provider_token' => $this->encryptToken($socialUser->token),
                'provider_refresh_token' => $this->encryptToken($socialUser->refreshToken),
            ];

            $user = $this->userService->findOrCreateSocialUser(
                provider: $provider,
                providerId: $socialUser->getId(),
                userData: $userData
            );

            return Response::response(
                message: __('auth.logged_successfully'),
                data: [
                    'token' => $this->userService->revokeAndCreateToken(user: $user),
                    'user' => new UserResource(resource: $user),
                ]
            );

        } catch (\Exception $e) {
            Log::error("{$provider} login error", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Response::error(
                message: __('auth.social_login_failed', ['provider' => ucfirst($provider)]),
                status: HttpStatus::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function encryptToken(?string $token): ?string
    {
        return $token ? Crypt::encryptString($token) : null;
    }

    public function logout(): Response
    {
        $user = $this->userService->update(data: ['fcm_token' => null], id: auth()->id());
        $this->userService->revokeTokens(user: auth()->user());
        return Response::response(
            message: __(key:'share.logout_successfully'),
            data: new UserResource($user)
        );
    }

    public function refreshToken(RefreshTokenRequest $request): Response
    {
        $this->userService->update(data: $request->validated(), id: auth()->id());
        return Response::response(
            message: __(key:'share.request_successfully'),
        );
    }

    public function deleteAccount(): Response
    {
        $this->userService->update(data: ['status' => StatusEnum::DELETED->value], id: auth()->id());
        $this->userService->revokeTokens(user: auth()->user());
        return Response::response(
            message: __(key:'share.account_deleted_successfully'),
        );
    }

    private function sendOtp($user, $code): void
    {

    }

    private function sendOtpEmail($user, $code): void
    {
        try {
            $mailHost = getSetting('mail_host');
            if (empty($mailHost)) {
                throw new Exception(__('share.update_email_settings'));
            }
            Config::set('mail.mailers.smtp.host', $mailHost);
            Config::set('mail.mailers.smtp.port', getSetting('mail_port'));
            Config::set('mail.mailers.smtp.encryption', getSetting('mail_encryption'));
            Config::set('mail.mailers.smtp.username', getSetting('mail_username'));
            Config::set('mail.mailers.smtp.password', getSetting('mail_password'));
            Config::set('mail.from.address', getSetting('mail_from_address'));
            Config::set('mail.from.name', getSetting('mail_from_name'));


            Mail::to($user->email)->send(new OTPMail($user, $code));
        } catch (Exception $e) {
            Log::error("Failed to send OTP email to user: {$user->id}. Error: " . $e->getMessage());
        }
    }
}
