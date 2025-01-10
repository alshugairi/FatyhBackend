<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\General\CompanyRequest,
    Http\Requests\Admin\Settings\General\MailRequest,
    Http\Requests\Admin\Settings\General\MapRequest,
    Http\Requests\Admin\Settings\General\NotificationRequest,
    Http\Requests\Admin\Settings\General\OtpRequest,
    Http\Requests\Admin\Settings\General\PaymentGatewayRequest,
    Http\Requests\Admin\Settings\General\SiteRequest,
    Http\Requests\Admin\Settings\General\SmsGatewayRequest,
    Http\Requests\Admin\Settings\General\SocialRequest,
    Http\Requests\Admin\Settings\General\ThemeRequest,
    Pipelines\Settings\SettingsFilterPipeline,
    Services\Settings\SettingsService};
use Illuminate\{Contracts\View\View, Http\RedirectResponse, Support\Number};
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(private readonly SettingsService $service)
    {
    }

    public function company(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'company']))]);
        return view('admin.modules.settings.general.company', get_defined_vars());
    }

    public function storeCompany(CompanyRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'company');
        flash(__('admin.updated_successfully', ['module' => __('admin.settings')]))->success();
        return back();
    }

    public function social(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'social']))]);
        return view('admin.modules.settings.general.social', get_defined_vars());
    }

    public function storeSocial(SocialRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'social');
        flash(__('admin.updated_successfully', ['module' => __('admin.settings')]))->success();
        return back();
    }

    public function mail(): View
    {
        $encryptionTypes = ['ssl' => 'SSL', 'tls' => 'TLS'];
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'mail']))]);
        return view('admin.modules.settings.general.mail', get_defined_vars());
    }

    public function storeMail(MailRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'mail');
        flash(__('admin.updated_successfully', ['module' => __('admin.settings')]))->success();
        return back();
    }

    public function site(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'site']))]);
        return view('admin.modules.settings.general.site', get_defined_vars());
    }

    public function storeSite(SiteRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'site');
        flash(__('admin.updated_successfully', ['module' => __('admin.settings')]))->success();
        return back();
    }

    public function otp(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'otp']))]);
        return view('admin.modules.settings.general.otp', get_defined_vars());
    }

    public function storeOtp(OtpRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'site');
        flash(__('admin.updated_successfully', ['module' => __('admin.settings')]))->success();
        return back();
    }

    public function smsGateways(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'sms']))]);
        return view('admin.modules.settings.general.sms_gateways', get_defined_vars());
    }

    public function storeSmsGateways(SmsGatewayRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'sms');
        flash(__('admin.updated_successfully', ['module' => __('admin.sms_gateways')]))->success();
        return back();
    }

    public function paymentGateways(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'payment']))]);
        return view('admin.modules.settings.general.payment_gateways', get_defined_vars());
    }

    public function storePaymentGateways(PaymentGatewayRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'payment');
        flash(__('admin.updated_successfully', ['module' => __('admin.payment_gateways')]))->success();
        return back();
    }

    public function theme(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'theme']))]);
        return view('admin.modules.settings.general.theme', get_defined_vars());
    }

    public function storeTheme(ThemeRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'theme');
        flash(__('admin.updated_successfully', ['module' => __('admin.theme')]))->success();
        return back();
    }

    public function map(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'map']))]);
        return view('admin.modules.settings.general.map', get_defined_vars());
    }

    public function storeMap(MapRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'map');
        flash(__('admin.updated_successfully', ['module' => __('admin.map')]))->success();
        return back();
    }

    public function notifications(): View
    {
        $settings = $this->service->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'notification']))]);
        return view('admin.modules.settings.general.notifications', get_defined_vars());
    }

    public function storeNotifications(NotificationRequest $request): RedirectResponse
    {
        $this->service->saveSettings(data: $request->validated(),prefix: 'notification');
        flash(__('admin.updated_successfully', ['module' => __('admin.notifications')]))->success();
        return back();
    }
}
