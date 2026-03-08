<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('About') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 bg-primary p-5 text-center text-white">
                                <i class="las la-building fs-1 mb-3 d-block" style="font-size: 5rem !important;"></i>
                                <h3 class="fw-bold mb-0">iDURAR</h3>
                                <p class="opacity-75">CRM / ERP Solutions</p>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-5">
                                    <h4 class="fw-bold mb-4">{{ __('Welcome to iDURAR') }}</h4>
                                    <p class="text-muted mb-4 fs-5">
                                        {{ __('iDURAR is an Open Source ERP/CRM designed for modern businesses. It provides a simple yet powerful way to manage your customers, invoices, payments, and quotes in one centralized location.') }}
                                    </p>
                                    
                                    <div class="row g-4 mt-2">
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-3 me-3">
                                                    <i class="las la-rocket text-primary fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-0">{{ __('Fast & Secure') }}</h6>
                                                    <p class="text-muted x-small mb-0">{{ __('Built with high performance in mind.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-3 me-3">
                                                    <i class="las la-mobile text-primary fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-0">{{ __('Responsive Design') }}</h6>
                                                    <p class="text-muted x-small mb-0">{{ __('Works perfectly on any device.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center">
                                <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 d-inline-block mx-auto mb-3">
                                    <i class="las la-code-branch fs-2"></i>
                                </div>
                                <h6 class="fw-bold mb-2">{{ __('Version') }}</h6>
                                <p class="text-muted small mb-0">v1.2.0-stable</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-block mx-auto mb-3">
                                    <i class="las la-check-circle fs-2"></i>
                                </div>
                                <h6 class="fw-bold mb-2">{{ __('System Status') }}</h6>
                                <p class="text-muted small mb-0">{{ __('All systems operational') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-block mx-auto mb-3">
                                    <i class="las la-heart fs-2"></i>
                                </div>
                                <h6 class="fw-bold mb-2">{{ __('License') }}</h6>
                                <p class="text-muted small mb-0">MIT License</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
