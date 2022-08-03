@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-script')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

<!-- CSS Custom -->
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
<x-section-main>
    <x-slot name="section_header_title">
        <h1>{{ __('Employees') }}</h1>
        <x-section-header-breadcrumb :breadcrumb="['Master', 'Employees', 'Update']" />
    </x-slot>

    {{-- <h2 class="section-title">DataTables</h2>
    <p class="section-lead">
        We use 'DataTables' made by @SpryMedia. You can check the full documentation <a
            href="https://datatables.net/">here</a>.
    </p> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Form Employee') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>{{ __('Employee Code') }}</label>
                                <input
                                    type="text"
                                    name="employee_code"
                                    value="{{ old('employee_code') ?? $employee->employee_code }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'is-invalid' => $errors->has('employee_code')
                                    ])
                                >
                                @error('employee_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label>{{ __('Name') }}</label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') ?? $employee->user->name }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'is-invalid' => $errors->has('name')
                                    ])
                                >
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label>{{ __('Email') }}</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') ?? $employee->user->email }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'is-invalid' => $errors->has('email')
                                    ])
                                >
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small id="emailHelp" class="form-text text-muted">{{ __('Employee will login using this email.') }}</small>
                            </div>

                            <div class="form-group col-md-3">
                                <label>{{ __('Password') }}</label>
                                <input
                                    type="password"
                                    name="password"
                                    value="{{ old('password') }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'is-invalid' => $errors->has('password')
                                    ])
                                >
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small id="passwordHelp" class="form-text text-muted">{{ __('Employee will login using this password. (Leave blank to keep current password)') }}</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Department') }}</label>
                                <select
                                    name="department_id"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'select2',
                                        'is-invalid' => $errors->has('department_id')
                                    ])
                                >
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"{{ $employee->department_id == $department->id ? ' selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Designation') }}</label>
                                <select
                                    name="designation_id"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'select2',
                                        'is-invalid' => $errors->has('designation_id')
                                    ])
                                >
                                    @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}"{{ $employee->designation_id == $designation->id ? ' selected' : '' }}>{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Gender') }}</label>
                                <select
                                    name="gender"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'is-invalid' => $errors->has('gender')
                                    ])
                                >
                                    <option value="male"{{ $employee->gender == 'male' ? ' selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="female"{{ $employee->gender == 'female' ? ' selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Role') }}</label>
                                <select
                                    name="role"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'select2',
                                        'is-invalid' => $errors->has('role')
                                    ])
                                >
                                    @foreach ($roles as $role)
                                    <option value="{{ $role }}"{{ $user_role == $role ? ' selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <textarea name="address"
                                @class([
                                    'form-control',
                                    'form-rounded',
                                    'is-invalid' => $errors->has('address')
                                ])
                                id="address"
                                rows="3"
                            >{{ old('address') ?? $employee->address }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Join Date') }}</label>
                                <input
                                    type="text"
                                    name="join_date"
                                    value="{{ old('join_date') ?? $employee->join_date }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'datepicker',
                                        'is-invalid' => $errors->has('join_date')
                                    ])
                                >
                                @error('join_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Exit Date') }}</label>
                                <input
                                    type="date"
                                    name="exit_date"
                                    value="{{ old('exit_date') ?? $employee->exit_date }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'is-invalid' => $errors->has('exit_date')
                                    ])
                                >
                                @error('exit_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Salary') }}</label>
                                <input
                                    type="text"
                                    name="salary"
                                    value="{{ old('salary') ?? $employee->salary }}"
                                    @class([
                                        'form-control',
                                        'form-rounded',
                                        'currency',
                                        'is-invalid' => $errors->has('salary')
                                    ])
                                >
                                @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-section-main>
@endsection

@section('footer-script')
<!-- JS Libraies -->
<script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
@endsection