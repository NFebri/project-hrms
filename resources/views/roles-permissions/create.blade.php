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
        <h1>{{ __('Roles & Permissions') }}</h1>
        <x-section-header-breadcrumb :breadcrumb="['Settings', 'Roles Permissions', 'Create']" />
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
                    <h4>{{ __('Form Roles Permissions') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles-permissions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                @class([
                                    'form-control',
                                    'form-rounded',
                                    'is-invalid' => $errors->has('name')
                                ])
                                required
                            >
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @foreach ($permissions_groups as $permission_group)
                        <div class="form-group">
                            <label for="">{{ $permission_group['name'] }}</label><br>
                            @foreach ($permissions as $permission)
                                @if (in_array($permission->name, $permission_group['permissions']))
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="permissions[]"
                                        id="{{ $permission->name }}"
                                        value="{{ $permission->id }}"
                                    >
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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