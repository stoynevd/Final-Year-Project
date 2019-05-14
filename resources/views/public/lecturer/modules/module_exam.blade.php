@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="moduleExam">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ Auth::user()->name }} 's Modules >> {{ $module->course->shortName.'-'.$module->id.' '.$module->name }} >> Exams >> {{ $exam->name }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button v-if="modules.length > 0" @click="updateExam()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-pencil"></i>
                                    <span> Update Exam </span>
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col">
                        <a href="/modules/{{ $module->id }}/exams" class="btn btn-primary mt-1"> <i class="fa fa-arrow-left"></i> Go Back </a>
                        <button @click="window.location='/exportExam/' + exam.id + '/pdf'" class="btn btn-primary mt-1"> <i class="fa fa-download"></i> Export Exam (PDF) </button>
                        <button @click="window.location='/exportExam/' + exam.id + '/word'" class="btn btn-primary mt-1"> <i class="fa fa-download"></i> Export Exam (WORD) </button>
                        <button @click="window.location='/printExam/' + exam.id + '/questions'" class="btn btn-primary mt-1"> <i class="fa fa-print"></i> Print Exam (Questions Only) </button>
                        <button @click="window.location='/printExam/' + exam.id + '/questionsAnswers'" class="btn btn-primary mt-1"> <i class="fa fa-print"></i> Print Exam (Questions & Answers) </button>
                        <button @click="window.location='/printExam/' + exam.id + '/answers'" class="btn btn-primary mt-1"> <i class="fa fa-print"></i> Print Exam (Answers Only) </button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label> Module: </label>
                            <select v-model="exam.module_id" class="form-control m-input m-input--solid">
                                <option value=""> Please, select a module </option>
                                <option v-for="module in modules" :value="module.id" :key="module.id"> @{{ module.course.shortName + module.id +  ' - ' + module.name }} </option>
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label> Exam Name </label>
                            <input v-model="exam.name" type="text" class="form-control m-input m-input--solid"/><br>
                            <label> Exam length (In minutes) </label>
                            <input v-model="exam.length" type="number" class="form-control m-input m-input--solid"/><br>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h4>
                            <button @click="openSection(currentSection - 1)" :disabled="currentSection == 0" class="btn btn-primary mr-5"><i class="fa fa-arrow-left"></i></button>
                            @{{ exam.sections[currentSection].name }}
                            <button @click="openSection(currentSection + 1)" :disabled="currentSection == exam.sections.length - 1" class="btn btn-primary ml-5"><i class="fa fa-arrow-right"></i></button>
                        </h4>
                        <br>
                        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline text-center" id="m_table_1" role="grid" aria-describedby="m_table_1_info" style="width: 1430px;">
                                <thead>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" style="width: 5%;" aria-sort="descending" aria-label="Order ID: activate to sort column ascending"> ID </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" style="width: 5%;" aria-sort="descending" aria-label="Order ID: activate to sort column ascending"> QID </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" style="width: 10%;" aria-label="Country: activate to sort column ascending"> Question Type </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" aria-label="Country: activate to sort column ascending"> Question Text </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" aria-label="Country: activate to sort column ascending"> Actions </th>
                                </thead>
                                <tbody>
                                    <tr v-for="(question, index) in exam.sections[currentSection].questions" class="pointer" style="width:100%">
                                        <td> @{{ index + 1 }} </td>
                                        <td> @{{ question.moduleQuestion.id }} </td>
                                        <td> @{{ question.moduleQuestion.type }} </td>
                                        <td> @{{ question.moduleQuestion.text }} </td>
                                        <td> <button @click="removeQuestionFromExam(question.id, index)" class="btn btn-danger"> Remove from Exam </button> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <h4> Module Questions </h4>
                        <br>
                        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline text-center" id="m_table_1" role="grid" aria-describedby="m_table_1_info" style="width: 1430px;">
                                <thead>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" style="width: 5%;" aria-sort="descending" aria-label="Order ID: activate to sort column ascending"> ID </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" style="width: 5%;" aria-sort="descending" aria-label="Order ID: activate to sort column ascending"> QID </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" style="width: 10%;" aria-label="Country: activate to sort column ascending"> Question Type </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" aria-label="Country: activate to sort column ascending"> Question Text </th>
                                    <th class="sorting" tabindex="0" aria-controls="m_table_5" aria-label="Country: activate to sort column ascending"> Actions </th>
                                </thead>
                                <tbody>
                                    <tr v-for="(availableQuestion, index) in availableQuestions" class="pointer" style="width:100%">
                                        <td> @{{ index + 1 }} </td>
                                        <td> @{{ availableQuestion.id }} </td>
                                        <td> @{{ availableQuestion.type }} </td>
                                        <td> @{{ availableQuestion.text }} </td>
                                        <td> <button @click="addQuestionToExam(availableQuestion, index)" class="btn btn-success"> Add to Exam </button> </td>
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
        el: '#moduleExam',
        data: () => ({
            modules: {!! $modules !!},
            exam: {!! $exam !!},
            moduleQuestions: {!! $module->questions !!},
            availableQuestions: [],
            currentSection: 0,
            oldModuleId: 0
        }),
        mounted () {
            var self = this
            self.oldModuleId = self.exam.module_id
            for(var i = 0; i < self.moduleQuestions.length; i++) {
                flag = true
                for(var j = 0; j < self.exam.questions.length; j++) {
                    if(self.moduleQuestions[i].id == self.exam.questions[j].module_question_id) {
                        flag = false
                    }
                }
                if(flag) {
                    self.availableQuestions.push(self.moduleQuestions[i])
                }
            }
        },
        methods: {
            openSection (section) {
                var self = this
                self.currentSection = section
            },
            updateExam () {
                var self = this
                axios.post('/user/updateExam', self.exam)
                .then(function (response){
                    if(response.data.success) {
                        swal({ type: 'success', title: 'Success', text: response.data.message }).then(() => {
                            if(self.oldModuleId != self.exam.module_id) {
                                window.location = '/modules/' + self.exam.module_id + '/exams/' + self.exam.id
                            }
                        })
                    }
                    else {
                        swal({ type: 'error', title: 'Error', text: response.data.message })
                    }
                });
            },
            removeQuestionFromExam (questionId, index) {
                var self = this
                axios.post('/user/removeQuestionFromExam', {
                    id: questionId,
                    exam_id: self.exam.id
                })
                .then(function (response){
                    if(response.data.success) {
                        self.exam.sections[self.currentSection].questions.splice(index, 1)
                        swal({ type: 'success', title: 'Success', text: response.data.message })
                    }
                    else {
                        swal({ type: 'error', title: 'Error', text: response.data.message })
                    }
                });
            },
            addQuestionToExam (availableQuestion, index) {
                var self = this
                axios.post('/user/addQuestionToExam', {
                    id: availableQuestion.id,
                    module_id: availableQuestion.module_id,
                    exam_id: self.exam.id,
                    section_id: self.exam.sections[self.currentSection].id
                })
                .then(function (response){
                    if(response.data.success) {
                        self.availableQuestions.splice(index, 1)
                        self.exam.sections[self.currentSection].questions.push(response.data.addedQuestion)
                        swal({ type: 'success', title: 'Success', text: response.data.message })
                    }
                    else {
                        swal({ type: 'error', title: 'Error', text: response.data.message })
                    }
                });
            }
        }
    })
    </script>
@stop
