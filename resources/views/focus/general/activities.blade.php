@extends ('core.layouts.app')
@section ('title', trans('en.application_log'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('en.application_log') }}</h4>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <table id="logs-table"
                                   class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('hrms.employee')}}</th>
                                    <th>{{ trans('en.module')}}</th>
                                    <th>{{ trans('general.reference')}}</th>
                                    <th>{{ trans('general.note') }}</th>
                                    <th>{{ trans('en.created_at') }}</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($activities as $log)

                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td> {{$log->user->name}}</td>
                                    <td>{{ $log->module}}</td>
                                    <td>{{ $log->refer}}</td>
                                    <td>{{ $log->action}}</td>
                                    <td>{{ dateTimeFormat($log->created_at)}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="alert alert-info">To clear the log timely check the CRON job section. <a class="dropdown-item" href="{{route('biller.cron')}}"><i
                                    class="fa fa-terminal"></i> {{trans('meta.cron')}}
                            </a></div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#logs-table').dataTable({
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },

                dom: 'Blfrtip',
                buttons: {
                    buttons: [

                        {extend: 'csv', footer: true, exportOptions: {columns: [0, 1, 2, 3, 4, 5]}},
                        {extend: 'excel', footer: true, exportOptions: {columns: [0, 1, 2, 3, 4, 5]}},
                        {extend: 'print', footer: true, exportOptions: {columns: [0, 1, 2, 3, 4, 5]}}
                    ]
                }
            });
            $('#usergatewayentries-table_wrapper').removeClass('form-inline');

        });
    </script>
@endsection
