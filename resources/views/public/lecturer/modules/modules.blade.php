@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="lecturer-modules">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ Auth::user()->name }} 's Modules
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline text-center" id="m_table_1" role="grid" aria-describedby="m_table_1_info" style="width: 1430px;">
                                <thead>
                                    <th style="width: 20%;"> Module ID </th>
                                    <th style="width: 100%;"> Module Name </th>
                                    <th style="width: 100%;"> Exams </th>
                                    <th style="width: 100%;"> Questions </th>
                                </thead>
                                <tbody>
                                    @foreach($modules as $key => $module)
                                        <tr class="pointer" style="width:100%" onclick="window.location='/modules/{{ $module->id }}'">
                                            <td> {{ $module->course->shortName . "-" . $module->id }} </td>
                                            <td> {{ $module->name }} </td>
                                            <td> {{ $module->exams()->count() }} </td>
                                            <td> {{ $module->questions()->count() }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
