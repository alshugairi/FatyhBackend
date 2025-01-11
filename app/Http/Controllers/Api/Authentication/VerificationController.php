<?php

namespace App\Http\Controllers\Api\Authentication;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\Authentication\ResendOTPRequest,
    Http\Requests\Api\Authentication\VerifyRequest,
    Http\Resources\UserResource,
    Mail\OTPMail,
    Services\UserService,
    Services\VerificationService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function __construct(private readonly UserService $userService,
                                private readonly VerificationService $verificationService)
    {
    }

    public function verify(VerifyRequest $request): Response
    {
        $this->userService->checkCodeAvailability(verificationCode: $request->code);
        $this->verificationService->verifyUser(user: $request->user());

        return Response::response(
            message: __(key:'share.success_verify_account'),
        );
    }

    public function resendOTP(): Response
    {
        $user = auth()->user();

        $code = app()->isProduction() ? $this->verificationService->generateCode() : 1234;

        $this->verificationService->storeCode(user: $user, code: $code);

        $this->sendOtp($user, $code);

        return Response::response(
            message: __(key:'share.success_send_otp'),
        );
    }

    public function resendOTPWithoutToken(ResendOTPRequest $request): Response
    {
        $user = $this->userService->getUserByPhone(phone: $request->phone);

        if (!$user) {
            return Response::error(message: __(key:'share.user_not_found'),status: HttpStatus::HTTP_NOT_FOUND);
        }

        $code = app()->isProduction() ? $this->verificationService->generateCode() : 1234;

        $this->verificationService->storeCode(user: $user, code: $code);

        $this->sendOtp($user, $code);

        return Response::response(
            message: __(key:'share.success_send_otp'),
            data: [
                'token' => $this->userService->revokeAndCreateToken(user: $user),
                'user' => new UserResource(resource: $user)
            ]
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
