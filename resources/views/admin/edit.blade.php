<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Edit User') }}: {{ $user->name }} {{ $user->surname }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.update', $user) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="surname" class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname', $user->surname) }}" required>
                                        @error('surname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="p-3 bg-light rounded mb-3">
                                    <h6 class="mb-2 fw-bold text-muted small">{{ __('Change Password (leave blank to keep current)') }}</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">{{ __('Role') }} <span class="text-danger">*</span></label>
                                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                            <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>{{ __('Employee') }}</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="enabled" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                        <select class="form-select @error('enabled') is-invalid @enderror" id="enabled" name="enabled" required>
                                            <option value="1" {{ old('enabled', $user->enabled) == '1' ? 'selected' : '' }}>{{ __('Enabled') }}</option>
                                            <option value="0" {{ old('enabled', $user->enabled) == '0' ? 'selected' : '' }}>{{ __('Disabled') }}</option>
                                        </select>
                                        @error('enabled')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
