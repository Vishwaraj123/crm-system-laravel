<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-bold">{{ __('About') }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('About') }}</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <!-- Hero Section -->
            <div class="card border-0 shadow-sm rounded-4 overlay-hidden mb-4 overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                <div class="card-body p-5 text-white position-relative">
                    <div class="row align-items-center position-relative" style="z-index: 2;">
                        <div class="col-lg-8">
                            <h1 class="display-5 fw-bold mb-3">{{ __('Modern CRM Solution') }}</h1>
                            <p class="lead mb-4 opacity-75">
                                {{ __('Empowering your business with smart management tools for clients, invoices, and payments. Streamline your workflow and focus on what matters most: growing your business.') }}
                            </p>
                            <div class="d-flex gap-3">
                                <div class="bg-white bg-opacity-10 rounded-pill px-4 py-2 backdrop-blur">
                                    <span class="fw-bold">{{ __('v1.2.0-stable') }}</span>
                                </div>
                                <div class="bg-white bg-opacity-10 rounded-pill px-4 py-2 backdrop-blur d-flex align-items-center">
                                    <span class="rounded-circle bg-success me-2" style="width: 10px; height: 10px; display: inline-block;"></span>
                                    <span class="fw-bold">{{ __('Systems Operational') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block text-center">
                            <i class="las la-rocket" style="font-size: 10rem; opacity: 0.2; transform: rotate(15deg);"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Our Vision -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                <i class="las la-eye fs-2"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ __('Our Vision') }}</h4>
                        </div>
                        <p class="text-muted fs-5 leading-relaxed">
                            {{ __('Our goal is to provide an intuitive and powerful platform that simplifies complex business processes. Every feature is designed with the user in mind, ensuring a seamless experience from lead generation to final payment.') }}
                        </p>
                    </div>
                </div>

                <!-- Core Features -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-indigo-soft text-indigo rounded-circle p-3 me-3" style="background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                                <i class="las la-cubes fs-2"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ __('Core Capabilities') }}</h4>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="las la-check text-success me-2"></i>
                                    <span>{{ __('Client Management') }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="las la-check text-success me-2"></i>
                                    <span>{{ __('Invoice Automation') }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="las la-check text-success me-2"></i>
                                    <span>{{ __('Payment Tracking') }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="las la-check text-success me-2"></i>
                                    <span>{{ __('Quote Generation') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center mb-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h2 class="fw-bold mb-0">100%</h2>
                        <p class="text-muted mb-0">{{ __('Secure & Private') }}</p>
                    </div>
                    <div class="col-md-4 border-start border-end">
                        <h2 class="fw-bold mb-0">24/7</h2>
                        <p class="text-muted mb-0">{{ __('Cloud Access') }}</p>
                    </div>
                    <div class="col-md-4">
                        <h2 class="fw-bold mb-0">Fast</h2>
                        <p class="text-muted mb-0">{{ __('Optimized Performance') }}</p>
                    </div>
                </div>
            </div>

            <!-- License & Technical -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-block mx-auto mb-3">
                            <i class="las la-balance-scale fs-2"></i>
                        </div>
                        <h6 class="fw-bold mb-2">{{ __('License') }}</h6>
                        <p class="text-muted small mb-0">{{ __('MIT Licensed Software') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 d-inline-block mx-auto mb-3">
                            <i class="las la-laptop-code fs-2"></i>
                        </div>
                        <h6 class="fw-bold mb-2">{{ __('Technology') }}</h6>
                        <p class="text-muted small mb-0">{{ __('Laravel 10 + Bootstrap 5') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-3 d-inline-block mx-auto mb-3">
                            <i class="las la-shield-alt fs-2"></i>
                        </div>
                        <h6 class="fw-bold mb-2">{{ __('Security') }}</h6>
                        <p class="text-muted small mb-0">{{ __('Encrypted Data Management') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .backdrop-blur {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .overlay-hidden {
            overflow: hidden;
            position: relative;
        }
    </style>
</x-app-layout>
