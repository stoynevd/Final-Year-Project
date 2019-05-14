@extends('layouts/admin/admin')

@section('content')
    <div class="m-portlet__body">
        <div class="m-pricing-table-2">
            <div class="m-pricing-table-2__head">
                <div class="m-pricing-table-2__title m--font-light">
                    <h1> Welcome, {{ Auth::user()->name }}! </h1>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="m-pricing-table_content1" aria-expanded="true">
                    <div class="m-pricing-table-2__content">
                        <div class="m-pricing-table-2__container">
                            <div class="m-pricing-table-2__items row">
                                <div class="m-pricing-table-2__item col-lg-4">
                                    <div class="m-pricing-table-2__visual">
                                        <div class="m-pricing-table-2__hexagon"></div>
                                        <span class="m-pricing-table-2__icon m--font-info"><i class="fa flaticon-squares-1"></i></span>
                                    </div>
                                    <h2 class="m-pricing-table-2__subtitle"> Total Modules </h2>
                                    <span class="m-pricing-table-2__price"> {{ $data['modulesCount'] }} </span>
                                </div>
                                <div class="m-pricing-table-2__item col-lg-4">
                                    <div class="m-pricing-table-2__visual">
                                        <div class="m-pricing-table-2__hexagon"></div>
                                        <span class="m-pricing-table-2__icon m--font-info"><i class="fa  flaticon-notes"></i></span>
                                    </div>
                                    <h2 class="m-pricing-table-2__subtitle"> Total Lecturers </h2>
                                    <span class="m-pricing-table-2__price"> {{ $data['lecturersCount'] }} </span>
                                </div>
                                <div class="m-pricing-table-2__item col-lg-4">
                                    <div class="m-pricing-table-2__visual">
                                        <div class="m-pricing-table-2__hexagon"></div>
                                        <span class="m-pricing-table-2__icon m--font-info"><i class="fa flaticon-questions-circular-button"></i></span>
                                    </div>
                                    <h2 class="m-pricing-table-2__subtitle"> Total Courses </h2>
                                    <span class="m-pricing-table-2__price"> {{ $data['courses'] }} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
