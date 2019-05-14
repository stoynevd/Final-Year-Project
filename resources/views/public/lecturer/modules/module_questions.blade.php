@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="module-questions">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ Auth::user()->name }} 's Modules >> {{ $module->course->shortName.'-'.$module->id.' '.$module->name }} >> Questions
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
                                    <th width="10%;"> Question ID </th>
                                    <th width="10%;"> Question Type </th>
                                    <th> Question Text </th>
                                    <th width="10%;"> Actions </th>
                                </thead>
                                <tbody>
                                    <tr v-for="(question, index) in module.questions" @click="window.location='/modules/' + module.id + '/questions/' + question.id" class="pointer">
                                        <td> @{{ question.id }} </td>
                                        <td> @{{ question.type }} </td>
                                        <td> @{{ question.text }} </td>
                                        <td>
                                            <button @click="deleteQuestion(question.id, index); $event.stopPropagation();" class="btn btn-sm btn-danger">
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
        el: '#module-questions',
        data: () => ({
            module: {!! $module !!}
        }),
        mounted () {
        },
        methods: {
            deleteQuestion (questionId, index) {
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
                        axios.post('/user/deleteQuestion', {
                            id: questionId,
                            module_id: self.module.id
                        })
                        .then(function (response){
                            if(response.data.success) {
                                self.module.questions.splice(index, 1)
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
