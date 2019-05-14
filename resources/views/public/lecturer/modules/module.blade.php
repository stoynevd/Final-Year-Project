@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ Auth::user()->name }} 's Modules >> {{ $data['moduleName'] }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <a href="/modules" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Go Back </a>
                <a href="/modules/{{ $module->id }}/exams" class="btn btn-primary"> Exams </a>
                <a href="/modules/{{ $module->id }}/questions" class="btn btn-primary"> Questions </a>
                <br><br>
                <div class="m-pricing-table-2">
                    <div class="m-pricing-table-2__head">
                        <div class="m-pricing-table-2__title m--font-light">
                            <h1> {{ $data['moduleName'] }} </h1>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="m-pricing-table_content1" aria-expanded="true">
                            <div class="m-pricing-table-2__content">
                                <div class="m-pricing-table-2__container">
                                    <div class="m-pricing-table-2__items row">
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info"><i class="fa flaticon-notes"></i></span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle"> Total Module<br>Tests </h2>
                                            <span class="m-pricing-table-2__price"> {{ $data['examsCount'] }} </span>
                                        </div>
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info"><i class="fa  flaticon-questions-circular-button"></i></span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle"> Total Module<br>Questions </h2>
                                            <span class="m-pricing-table-2__price"> {{ $data['questionsCount'] }} </span>
                                        </div>
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info"><i class="fa flaticon-questions-circular-button"></i></span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle"> Average Exam<br>Questions </h2>
                                            <span class="m-pricing-table-2__price"> {{ $data['averageExamQuestions'] }} </span>
                                        </div>
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info"><i class="fa flaticon-time"></i></span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle"> Average Exam<br>Length </h2>
                                            <span class="m-pricing-table-2__price"> {{ $data['averageExamLength'] }} min. </span>
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
