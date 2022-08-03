@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-script')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('content')
<x-section-main>
    <x-slot name="section_header_title">
        <h1>{{ __('Departments') }}</h1>
        <x-section-header-breadcrumb :breadcrumb="['Master', 'Departments']" />
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
                    <h4>{{ __('All Departments') }}</h4>
                    <a href="{{ route('departments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        {{ __('New Department') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="departments-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Department') }}</th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __('Edit') }}">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form class="d-inline" action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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

<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

<script>
    $("#departments-table").dataTable();
</script>
@endsection