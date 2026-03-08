<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                <i class="las la-cog me-2"></i>{{ __('Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" id="settings-form">
                @csrf

                <div class="row">
                    {{-- ── LEFT COLUMN ── --}}
                    <div class="col-lg-8">

                        {{-- Company Information --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="las la-building me-2 text-primary"></i>{{ __('Company Information') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label for="company_name" class="form-label fw-semibold">{{ __('Company Name') }}</label>
                                        <input type="text"
                                               class="form-control @error('company_name') is-invalid @enderror"
                                               id="company_name" name="company_name"
                                               value="{{ old('company_name', $settings['company_name'] ?? '') }}"
                                               placeholder="e.g. Acme Corporation">
                                        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="company_email" class="form-label fw-semibold">{{ __('Company Email') }}</label>
                                        <input type="email"
                                               class="form-control @error('company_email') is-invalid @enderror"
                                               id="company_email" name="company_email"
                                               value="{{ old('company_email', $settings['company_email'] ?? '') }}"
                                               placeholder="e.g. info@company.com">
                                        @error('company_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="company_address" class="form-label fw-semibold">{{ __('Company Address') }}</label>
                                        <input type="text"
                                               class="form-control @error('company_address') is-invalid @enderror"
                                               id="company_address" name="company_address"
                                               value="{{ old('company_address', $settings['company_address'] ?? '') }}"
                                               placeholder="e.g. 123 Main Street">
                                        @error('company_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="company_state" class="form-label fw-semibold">{{ __('State / Province') }}</label>
                                        <input type="text"
                                               class="form-control @error('company_state') is-invalid @enderror"
                                               id="company_state" name="company_state"
                                               value="{{ old('company_state', $settings['company_state'] ?? '') }}"
                                               placeholder="e.g. California">
                                        @error('company_state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="company_country" class="form-label fw-semibold">{{ __('Country') }}</label>
                                        <input type="text"
                                               class="form-control @error('company_country') is-invalid @enderror"
                                               id="company_country" name="company_country"
                                               value="{{ old('company_country', $settings['company_country'] ?? '') }}"
                                               placeholder="e.g. United States">
                                        @error('company_country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="company_phone" class="form-label fw-semibold">{{ __('Company Phone') }}</label>
                                        <input type="text"
                                               class="form-control @error('company_phone') is-invalid @enderror"
                                               id="company_phone" name="company_phone"
                                               value="{{ old('company_phone', $settings['company_phone'] ?? '') }}"
                                               placeholder="e.g. +1 (555) 000-0000">
                                        @error('company_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="company_website" class="form-label fw-semibold">{{ __('Company Website') }}</label>
                                        <input type="url"
                                               class="form-control @error('company_website') is-invalid @enderror"
                                               id="company_website" name="company_website"
                                               value="{{ old('company_website', $settings['company_website'] ?? '') }}"
                                               placeholder="e.g. https://www.company.com">
                                        @error('company_website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="company_tax_number" class="form-label fw-semibold">{{ __('Tax / VAT Number') }}</label>
                                        <input type="text"
                                               class="form-control @error('company_tax_number') is-invalid @enderror"
                                               id="company_tax_number" name="company_tax_number"
                                               value="{{ old('company_tax_number', $settings['company_tax_number'] ?? '') }}"
                                               placeholder="e.g. GST123456789">
                                        @error('company_tax_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Regional / Format Defaults --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="las la-globe me-2 text-primary"></i>{{ __('Regional Defaults') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label for="default_currency" class="form-label fw-semibold">{{ __('Default Currency') }}</label>
                                        <select class="form-select @error('default_currency') is-invalid @enderror"
                                                id="default_currency" name="default_currency">
                                            @foreach($currencies as $code => $info)
                                                <option value="{{ $code }}"
                                                    {{ old('default_currency', $settings['default_currency'] ?? 'USD') == $code ? 'selected' : '' }}>
                                                    {{ $info[0] }} — {{ $info[1] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('default_currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="date_format" class="form-label fw-semibold">{{ __('Date Format') }}</label>
                                        <select class="form-select @error('date_format') is-invalid @enderror"
                                                id="date_format" name="date_format">
                                            @foreach($dateFormats as $fmt => $label)
                                                <option value="{{ $fmt }}"
                                                    {{ old('date_format', $settings['date_format'] ?? 'd/m/Y') == $fmt ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('date_format')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>

                                {{-- Live preview --}}
                                <div class="alert alert-info mt-3 mb-0 py-2 small">
                                    <i class="las la-info-circle me-1"></i>
                                    <strong>Preview:</strong>
                                    Currency: <span id="currency-preview" class="fw-bold">{{ $settings['currency_symbol'] ?? '$' }} 1,234.56</span>
                                    &nbsp;|&nbsp;
                                    Date: <span id="date-preview" class="fw-bold">{{ now()->format($settings['date_format'] ?? 'd/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ── RIGHT COLUMN ── --}}
                    <div class="col-lg-4">

                        {{-- Company Logo --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="las la-image me-2 text-primary"></i>{{ __('Company Logo') }}
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    @if(!empty($settings['company_logo']))
                                        <img src="{{ Storage::url($settings['company_logo']) }}"
                                             id="logo-preview"
                                             alt="Company Logo"
                                             class="img-fluid border p-2"
                                             style="max-height: 120px; max-width: 100%; object-fit: contain;">
                                    @else
                                        <div id="logo-placeholder"
                                             class="d-flex align-items-center justify-content-center bg-light border"
                                             style="height: 120px;">
                                            <div class="text-center text-muted">
                                                <i class="las la-image fs-1 d-block"></i>
                                                <small>No logo uploaded</small>
                                            </div>
                                        </div>
                                        <img src="" id="logo-preview" alt="Logo Preview"
                                             class="img-fluid border p-2 d-none"
                                             style="max-height: 120px; max-width: 100%; object-fit: contain;">
                                    @endif
                                </div>
                                <label for="company_logo" class="form-label fw-semibold d-block">{{ __('Upload New Logo') }}</label>
                                <input type="file"
                                       class="form-control @error('company_logo') is-invalid @enderror"
                                       id="company_logo" name="company_logo"
                                       accept="image/jpeg,image/png,image/gif,image/svg+xml">
                                <div class="form-text text-muted mt-1">JPEG, PNG, GIF, SVG — max 2MB</div>
                                @error('company_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Save Button Card --}}
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                                    <i class="las la-save me-2"></i>{{ __('Save Settings') }}
                                </button>
                                <p class="text-muted small text-center mt-2 mb-0">
                                    Changes apply app-wide immediately.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    (function() {
        // Logo live preview
        const logoInput = document.getElementById('company_logo');
        const logoPreview = document.getElementById('logo-preview');
        const logoPlaceholder = document.getElementById('logo-placeholder');

        if (logoInput) {
            logoInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        logoPreview.src = e.target.result;
                        logoPreview.classList.remove('d-none');
                        if (logoPlaceholder) logoPlaceholder.classList.add('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Currency symbol preview map
        const symbolMap = {
            USD: '$', EUR: '€', GBP: '£', INR: '₹', AUD: 'A$',
            CAD: 'C$', AED: 'د.إ', SAR: '﷼', JPY: '¥', CNY: '¥',
            SGD: 'S$', CHF: 'Fr'
        };

        const currencySelect = document.getElementById('default_currency');
        const currencyPreview = document.getElementById('currency-preview');
        if (currencySelect && currencyPreview) {
            currencySelect.addEventListener('change', function () {
                const sym = symbolMap[this.value] || this.value;
                currencyPreview.textContent = sym + ' 1,234.56';
            });
        }
    })();
    </script>
    @endpush
</x-app-layout>
