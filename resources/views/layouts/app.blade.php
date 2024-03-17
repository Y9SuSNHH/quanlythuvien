<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <style>
        .ck-editor__editable,
        textarea {
            min-height: 150px;
        }

        .datatable {
            width: 100% !important;
        }

        table.dataTable tbody td.select-checkbox::before,
        table.dataTable tbody td.select-checkbox::after,
        table.dataTable tbody th.select-checkbox::before,
        table.dataTable tbody th.select-checkbox::after {
            top: 50%;
        }

        .dataTables_length,
        .dataTables_filter,
        .dt-buttons {
            margin-bottom: 0.333em;
            margin-top: .2rem;
        }

        .dataTables_filter {
            margin-right: .2rem;
        }

        .dt-buttons .btn {
            margin-left: 0.333em;
            border-radius: 0;
        }

        .table.datatable {
            box-sizing: border-box;
            border-collapse: collapse;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #c8ced3;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody {
            border-bottom: 1px solid #c8ced3;
        }

        .select2 {
            max-width: 100%;
            width: 100% !important;
        }

        .select2-selection__rendered {
            padding-bottom: 5px !important;
        }

        .has-error .invalid-feedback {
            display: block !important;
        }

        .btn-info,
        .badge-info {
            color: white;
        }

        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            background-image: none;
        }

        .sidebar .nav-item {
            cursor: pointer;
        }

        .btn-default {
            color: #23282c;
            background-color: #f0f3f5;
            border-color: #f0f3f5;
        }

        .btn-default.focus,
        .btn-default:focus {
            box-shadow: 0 0 0 .2rem rgba(209, 213, 215, .5);
        }

        .btn-default:hover {
            color: #23282c;
            background-color: #d9e1e6;
            border-color: #d1dbe1;
        }

        .btn-group-xs > .btn,
        .btn-xs {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .searchable-title {
            font-weight: bold;
        }
        .searchable-fields {
            padding-left:5px;
        }
        .searchable-link {
            padding:0 5px 0 5px;
        }
        .searchable-link:hover   {
            cursor: pointer;
            background: #eaeaea;
        }
        .select2-results__option {
            padding-left: 0px;
            padding-right: 0px;
        }

        .form-group .required::after {
            content: " *";
            color: red;
        }

        .form-check.is-invalid ~ .invalid-feedback {
            display: block;
        }

        .c-sidebar-brand .c-sidebar-brand-full:hover {
            color: inherit;
        }

        .custom-select.form-control-sm {
            padding: 0.25rem 1.5rem;
        }
    </style>
    @yield('styles')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
<div class="c-app flex-row align-items-center">
    <div class="container">
        @yield("content")
    </div>
</div>
@yield('scripts')
</body>
</html>
