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
                    @include('attendances.partials.filter')
                    <div class="table-responsive">
                        <table class="table table-striped" id="atendances-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
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
    var atendanceDataTables = $("#atendances-table").DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        info: false,
        ajax: {
            url: "{{ route('attendances.index') }}",
            data: function (params) {
                params.user_id = $('#user_id').val(),
                params.date_range = $('#date_range').val()
            }
        },
        columns: [
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'status',
                name: 'status'
            },
        ]
    });

    function filterAttendance() {
        console.log('there');
        atendanceDataTables.ajax.reload();
    }
</script>

<script>
    $('.daterange-cus').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        drops: 'down',
        opens: 'right'
    });
</script>
@endsection