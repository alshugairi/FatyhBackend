<form method="POST" action="{{ route('admin.register.individual') }}">
    @csrf
    <div class="row">
        <x-form.input-group label="false" col="col-md-6" name="first_name" labelName="{{ __('admin.first_name') }}" icon="fa fa-user" required placeholder="{{ __('admin.first_name') }}" />
        <x-form.input-group label="false" col="col-md-6" name="middle_name" labelName="{{ __('admin.middle_name') }}" icon="fa fa-user" required placeholder="{{ __('admin.middle_name') }}" />
        <x-form.input-group label="false" col="col-md-6" name="last_name" labelName="{{ __('admin.last_name') }}" icon="fa fa-user" required placeholder="{{ __('admin.last_name') }}" />
        <x-form.input-group label="false" col="col-md-6" name="nickname" labelName="{{ __('admin.nickname') }}" icon="fa fa-user" required placeholder="{{ __('admin.nickname') }}" />
        <x-form.input-group label="false" col="col-md-6" name="phone" labelName="{{ __('admin.phone') }}" icon="fa fa-phone" type="tel" required placeholder="{{ __('admin.phone') }}" />
        <x-form.input-group label="false" col="col-md-6" name="email" labelName="{{ __('admin.email') }}" icon="fa fa-envelope" type="email" required placeholder="{{ __('admin.email') }}" />
        <x-form.select-group label="false" col="col-md-6" name="country_id" labelName="{{ __('admin.country') }}" icon="fa fa-globe" required>
            <option value="">Country</option>
            <option value="1">United States</option>
            <option value="2">United Kingdom</option>
        </x-form.select-group>
        <x-form.select-group label="false" col="col-md-6" name="city_id" labelName="{{ __('admin.city') }}" icon="fa fa-building" required>
            <option value="">City</option>
            <option value="1">New York</option>
            <option value="2">London</option>
        </x-form.select-group>
        <x-form.input-group label="false" col="col-md-6" name="password" labelName="{{ __('admin.password') }}" icon="fa fa-lock" required placeholder="{{ __('admin.password') }}" />
        <x-form.input-group label="false" col="col-md-6" name="password_confirmation" labelName="{{ __('admin.password') }}" icon="fa fa-lock" required placeholder="{{ __('admin.confirm_password') }}" />
        <div class="col-md-12">
            <button type="submit" class="btn btn-lg btn-primary w-100">Create account</button>
        </div>
    </div>
</form>
