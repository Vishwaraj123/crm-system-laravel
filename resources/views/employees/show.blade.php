<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Employee Details') }}
            </h2>
            <div>
                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary me-2">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 border-bottom pb-2 mb-4">{{ $employee->name }} {{ $employee->surname }}</h3>
                            
                            <dl class="row">
                                <dt class="col-sm-3">{{ __('Email') }}</dt>
                                <dd class="col-sm-9">{{ $employee->email }}</dd>

                                <dt class="col-sm-3">{{ __('Phone') }}</dt>
                                <dd class="col-sm-9">{{ $employee->phone }}</dd>

                                <dt class="col-sm-3">{{ __('Department') }}</dt>
                                <dd class="col-sm-9">{{ $employee->department }}</dd>

                                <dt class="col-sm-3">{{ __('Position') }}</dt>
                                <dd class="col-sm-9">{{ $employee->position }}</dd>

                                <dt class="col-sm-3">{{ __('Gender') }}</dt>
                                <dd class="col-sm-9 text-capitalize">{{ $employee->gender }}</dd>

                                <dt class="col-sm-3">{{ __('Birthday') }}</dt>
                                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($employee->birthday)->format('F j, Y') }}</dd>

                                <dt class="col-sm-3">{{ __('Birthplace') }}</dt>
                                <dd class="col-sm-9">{{ $employee->birthplace }}</dd>

                                <dt class="col-sm-3">{{ __('Address') }}</dt>
                                <dd class="col-sm-9">
                                    {{ $employee->address }}<br>
                                    {{ $employee->state }}
                                </dd>
                                
                                <dt class="col-sm-3 mt-3">{{ __('Created At') }}</dt>
                                <dd class="col-sm-9 mt-3">{{ $employee->created_at->format('M d, Y H:i') }}</dd>

                                <dt class="col-sm-3">{{ __('Last Updated') }}</dt>
                                <dd class="col-sm-9">{{ $employee->updated_at->format('M d, Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
