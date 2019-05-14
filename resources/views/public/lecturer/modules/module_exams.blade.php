@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="module-exams">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ Auth::user()->name }} 's Modules >> {{ $module->course->shortName.'-'.$module->id.' '.$module->name }} >> Exams
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <a href="/modules/{{ $module->id }}" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Go Back </a>
                <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline text-center" id="m_table_1" role="grid" aria-describedby="m_table_1_info" style="width: 1430px;">
                                <thead>
                                    <th width="10%;"> Exam ID </th>
                                    <th> Author </th>
                                    <th width="10%;"> Length </th>
                                    <th> Sections </th>
                                    <th> Questions </th>
                                    <th width="10%;"> Actions </th>
                                </thead>
                                <tbody>
                                    <tr v-for="(exam, index) in module.exams" @click="window.location='/modules/' + module.id + '/exams/' + exam.id" class="pointer">
                                        <td> @{{ exam.id }} </td>
                                        <td> @{{ exam.lecturer.name }} </td>
                                        <td> @{{ exam.length }} minutes </td>
                                        <td> @{{ exam.sectionsCount }} </td>
                                        <td> @{{ exam.questionsCount }} </td>
                                        <td>
                                            <button @click="deleteCourse(exam.id, index); $event.stopPropagation();" class="btn btn-sm btn-danger">
                                                <i class="la la-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    new Vue ({
        el: '#module-exams',
        data: () => ({
            module: {!! $module !!}
        }),
        mounted () {
        },
        methods: {
            deleteExam (examId, index) {
                var self = this
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/user/deleteExam', {
                            id: examId,
                            module_id: self.module.id
                        })
                        .then(function (response){
                            if(response.data.success) {
                                self.module.exams.splice(index, 1)
                                swal({ type: 'success', title: 'Success', text: response.data.message })
                            }
                            else {
                                swal({ type: 'error', title: 'Error', text: response.data.message })
                            }
                        });
                    }
                })
            }
        }
    })
    </script>
@stop
