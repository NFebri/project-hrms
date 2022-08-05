@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-script')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">

<!-- CSS Custom -->
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
<x-section-main>
    <x-slot name="section_header_title">
        <h1>{{ __('Attendances') }}</h1>
        <x-section-header-breadcrumb :breadcrumb="['Master', 'Attendances']" />
    </x-slot>

    {{-- <h2 class="section-title">DataTables</h2>
    <p class="section-lead">
        We use 'DataTables' made by @SpryMedia. You can check the full documentation <a
            href="https://datatables.net/">here</a>.
    </p> --}}

    <x-flash-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>{{ __('Attendances') }}</h4>
                    {{-- <a href="{{ route('departments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        {{ __('New Department') }}
                    </a> --}}
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Employee') }}</label>
                                <select name="user_id" class="form-control form-control-sm form-rounded" id="user_id">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->user_id }}"{{ $employee->user_id == auth()->user()->id ? ' selected' : '' }}>{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Date Range') }}</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="date_range" class="form-control form-control-sm daterange-cus" value="{{ Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') . ' - ' . Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" id="date_range">
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-sm btn-primary">{{ __('Apply') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped" id="atendances-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance['date'] }}</td>
                                        <td>
                                            @if ($attendance['holiday'])
                                                <span class="badge badge-info">{{ __('holiday') }}</span>
                                            @elseif ($attendance['attendance'])
                                                <span class="badge badge-primary">{{ __('present') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('absent') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-section-main>
@endsection

@section('footer-script')
<!-- JS Libraies -->
<script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

<script>
    $('.daterange-cus').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        drops: 'down',
        opens: 'right'
    });
</script>
@endsection