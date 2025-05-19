<form method="POST" action="{{ route('admin.register.company') }}">
    @csrf
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="company-info-tab" data-bs-toggle="tab" data-bs-target="#company-info" type="button" role="tab" aria-controls="company-info" aria-selected="false">
                <span class="dot"></span> Company Info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="owner-info-tab" data-bs-toggle="tab" data-bs-target="#owner-info" type="button" role="tab" aria-controls="owner-info" aria-selected="false">
                <span class="dot"></span> Owner Info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="directory-info-tab" data-bs-toggle="tab" data-bs-target="#directory-info" type="button" role="tab" aria-controls="directory-info" aria-selected="false">
                <span class="dot"></span> Directory Info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="partners-info-tab" data-bs-toggle="tab" data-bs-target="#partners-info" type="button" role="tab" aria-controls="partners-info" aria-selected="false">
                <span class="dot"></span> Partners Info (optional)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                <span class="dot"></span> Password
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <!-- Company Info Tab -->
        <div class="tab-pane fade active show" id="company-info" role="tabpanel" aria-labelledby="company-info-tab" tabindex="0">
            <div class="row">
                <x-form.input-group label="false" col="col-md-6" name="firstNameCompany" labelName="First Name" icon="fa fa-user" required placeholder="First name" />
                <x-form.input-group label="false" col="col-md-6" name="emailAddressCompany" labelName="Email Address" icon="fa fa-envelope" type="email" required placeholder="Email address" />
                <x-form.input-group label="false" col="col-md-6" name="companyWebsite" labelName="Company Website" icon="fa fa-globe" placeholder="Company website" />
                <x-form.input-group label="false" col="col-md-6" name="employeesCount" labelName="Employees Count" icon="fa fa-users" type="number" placeholder="Employees count" />
                <x-form.select-group label="false" col="col-md-6" name="countryCompany" labelName="Country" icon="fa fa-globe" required>
                    <option value="">Country</option>
                    <option value="us">United States</option>
                    <option value="uk">United Kingdom</option>
                </x-form.select-group>
                <x-form.select-group label="false" col="col-md-6" name="cityCompany" labelName="City" icon="fa fa-building" required>
                    <option value="">City</option>
                    <option value="newyork">New York</option>
                    <option value="london">London</option>
                </x-form.select-group>
                <x-form.input-group label="false" col="col-md-6" name="companyPapers" labelName="Company Papers" icon="fa fa-upload" type="file" required>
                    <small class="form-text text-muted">A copy of all company papers, incorporation certificate, meeting minutes and license *</small>
                </x-form.input-group>
                <x-form.input-group label="false" col="col-md-6" name="bankNames" labelName="Bank Names" icon="fa fa-upload" type="file">
                    <small class="form-text text-muted">Names of the banks that hold an account for the company *</small>
                </x-form.input-group>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-primary w-25 float-end" id="nextCompany">Next</button>
            </div>
        </div>
        <!-- Owner Info Tab -->
        <div class="tab-pane fade" id="owner-info" role="tabpanel" aria-labelledby="owner-info-tab" tabindex="0">
            <div class="row">
                <x-form.input-group label="false" col="col-md-6" name="ownerFirstName" labelName="First Name" icon="fa fa-user" required placeholder="First name" />
                <x-form.input-group label="false" col="col-md-6" name="ownerMiddleName" labelName="Middle Name" icon="fa fa-user" placeholder="Middle name" />
                <x-form.input-group label="false" col="col-md-6" name="ownerLastName" labelName="Last Name" icon="fa fa-user" required placeholder="Last name" />
                <x-form.input-group label="false" col="col-md-6" name="ownerNickName" labelName="Nick Name" icon="fa fa-user" placeholder="Nick name" />
                <x-form.input-group label="false" col="col-md-6" name="ownerPhone" labelName="Phone Number" icon="fa fa-phone" type="tel" required placeholder="Phone number" />
                <x-form.input-group label="false" col="col-md-6" name="ownerEmail" labelName="Email Address" icon="fa fa-envelope" type="email" required placeholder="Email address" />
                <x-form.select-group label="false" col="col-md-6" name="ownerCountry" labelName="Country" icon="fa fa-globe" required>
                    <option value="">Country</option>
                    <option value="us">United States</option>
                    <option value="uk">United Kingdom</option>
                </x-form.select-group>
                <x-form.select-group label="false" col="col-md-6" name="ownerCity" labelName="City" icon="fa fa-building" required>
                    <option value="">City</option>
                    <option value="newyork">New York</option>
                    <option value="london">London</option>
                </x-form.select-group>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-25" id="backOwner">Back</button>
                <button type="button" class="btn btn-primary w-25 float-end" id="nextOwner">Next</button>
            </div>
        </div>
        <!-- Directory Info Tab -->
        <div class="tab-pane fade" id="directory-info" role="tabpanel" aria-labelledby="directory-info-tab" tabindex="0">
            <div class="row">
                <x-form.input-group label="false" col="col-md-6" name="directorName" labelName="Director Name" icon="fa fa-user" required placeholder="Director name" />
                <x-form.input-group label="false" col="col-md-6" name="directorNationality" labelName="Director Nationality" icon="fa fa-flag" required placeholder="Director nationality" />
                <x-form.input-group label="false" col="col-md-6" name="directorEmail" labelName="Email Address" icon="fa fa-envelope" type="email" required placeholder="Email address" />
                <x-form.input-group label="false" col="col-md-6" name="directorPhone" labelName="Phone Number" icon="fa fa-phone" type="tel" required placeholder="Phone number" />
                <x-form.input-group label="false" col="col-md-6" name="directorDocuments" labelName="Director Documents" icon="fa fa-upload" type="file" required>
                    <small class="form-text text-muted">Director's documents and passport. File must be under 30 MB in size</small>
                </x-form.input-group>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-25" id="backDirectory">Back</button>
                <button type="button" class="btn btn-primary w-25 float-end" id="nextDirectory">Next</button>
            </div>
        </div>
        <!-- Partners Info Tab -->
        <div class="tab-pane fade" id="partners-info" role="tabpanel" aria-labelledby="partners-info-tab" tabindex="0">
            <div class="row">
                <x-form.input-group label="false" col="col-md-6" name="partnerName" labelName="Partner Name" icon="fa fa-user" placeholder="Partner name" />
                <x-form.input-group label="false" col="col-md-6" name="partnerDocuments" labelName="Partner Documents" icon="fa fa-upload" type="file">
                    <small class="form-text text-muted">Partner's documents and passport. File must be under 30 MB in size</small>
                </x-form.input-group>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-25" id="backPartners">Back</button>
                <button type="button" class="btn btn-primary w-25 float-end" id="nextPartners">Next</button>
            </div>
        </div>
        <!-- Password Tab -->
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
            <div class="row">
                <x-form.input-group label="false" col="col-md-6" name="passwordCompany" labelName="Password" icon="fa fa-lock" type="password" required placeholder="Password" />
                <x-form.input-group label="false" col="col-md-6" name="confirmPasswordCompany" labelName="Confirm Password" icon="fa fa-lock" type="password" required placeholder="Confirm Password" />
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input required-field" id="termsCompany" name="termsCompany" required>
                <label class="form-check-label" for="termsCompany">I accept the Term of Conditions & Privacy Policy</label>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-25" id="backPassword">Back</button>
                <button type="submit" class="btn btn-primary w-25 float-end">Create account</button>
            </div>
        </div>
    </div>
</form>
