@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="createExam">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            New Exam
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button v-if="modules.length > 0" @click="createExam()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span> Create Exam </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label> Module: </label>
                            <select @change="loadAvailableQuestions()" v-model="examDetails.module_id" class="form-control m-input m-input--solid">
                                <option value=""> Please, select a module </option>
                                <option v-for="module in modules" :value="module.id" :key="module.id"> @{{ module.course.shortName + module.id +  ' - ' + module.name }} </option>
                            </select>
                        </div>
                        <div v-if="examDetails.module_id != ''" class="form-group m-form__group">
                            <label> Number of Sections: </label>
                            <select @change="initSections()" v-model="examDetails.numberOfSections" class="form-control m-input m-input--solid">
                                <option value="" disabled> Please, select number of sections </option>
                                <option v-for="n in 5" :value="n" :key="n"> @{{ n }} </option>
                            </select> <br>
                            <label> Exam Name </label>
                            <input v-model="examDetails.name" type="text" class="form-control m-input m-input--solid"/><br>
                            <label> Exam length (In minutes) </label>
                            <input v-model="examDetails.length" type="number" class="form-control m-input m-input--solid"/><br>
                            <label v-if="examDetails.numberOfSections != ''" class="m-checkbox m-checkbox--state-brand">
                                <input v-model="examDetails.randomQuestions" type="checkbox" name="example_2" value="2"> <b> Random Questions </b> </input>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="examDetails.randomQuestions">
                    <div class="col-4" v-for="(section, index) in examDetails.sections">
                        <h5> Section @{{ index + 1 }} </h5>
                        <div v-if="examDetails.module_id != ''" class="form-group m-form__group">
                            <label> Section Name: </label>
                            <input v-model="section.name" type="text" class="form-control m-input m-input--solid"/><br>
                            <label> Number of Questions: </label>
                            <input v-model="section.numberOfQuestions" type="number" class="form-control m-input m-input--solid"/><br>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="!examDetails.randomQuestions && examDetails.sections.length > 0">
                    <div class="col-12 text-center">
                        <div class="row">
                            <div class="col-1 offset-4">
                                <button @click="openSection(currentSection - 1)" :disabled="currentSection == 0" class="btn btn-primary mr-5"><i class="fa fa-arrow-left"></i></button>
                            </div>
                            <div class="col-2">
                                <input v-model="examDetails.sections[currentSection].name" type="text" class="form-control m-input m-input--solid"/>
                            </div>
                            <div class="col-1">
                                <button @click="openSection(currentSection + 1)" :disabled="currentSection == examDetails.sections.length - 1" class="btn btn-primary ml-5"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
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
                                    <tr v-for="(question, index) in examDetails.sections[currentSection].questions" class="pointer" style="width:100%">
                                        <td> @{{ index + 1 }} </td>
                                        <td> @{{ question.id }} </td>
                                        <td> @{{ question.type }} </td>
                                        <td> @{{ question.text }} </td>
                                        <td> <button @click="removeQuestionFromExam(index)" class="btn btn-danger"> Remove from Exam </button> </td>
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
        el: '#createExam',
        data: () => ({
            modules: {!! $modules !!},
            examDetails: {
                module_id: '',
                numberOfSections: '',
                randomQuestions: false,
                sections: [],
                name: '',
                length: 60
            },
            currentSection: 0,
            availableQuestions: []
        }),
        mounted () {
            var self = this
        },
        methods: {
            loadAvailableQuestions () {
                var self = this
                for(let i = 0; i < self.modules.length; i++) {
                    if(self.modules[i].id == self.examDetails.module_id) {
                        self.availableQuestions = self.modules[i].questions
                    }
                }
            },
            initSections () {
                var self = this
                self.currentSection = 0
                if(self.examDetails.numberOfSections > self.examDetails.sections.length) {
                    let counter = self.examDetails.numberOfSections - self.examDetails.sections.length
                    if(self.examDetails.sections.length == 0) {
                        counter = self.examDetails.numberOfSections
                    }
                    for(let i = 0; i < counter; i++) {
                        self.examDetails.sections.push({name: '', numberOfQuestions: 0, questions: []})
                    }
                }
                else {
                    for(let i = self.examDetails.sections.length; i > self.examDetails.numberOfSections; i--) {
                        for(let j = 0; j < self.examDetails.sections[i-1].questions.length; j++ ) {
                            self.availableQuestions.push(self.examDetails.sections[i-1].questions[j])
                        }
                        self.examDetails.sections.pop()
                    }
                    self.availableQuestions = _.sortBy(self.availableQuestions, 'id')
                }
            },
            openSection (section) {
                var self = this
                self.currentSection = section
            },
            addQuestionToExam (availableQuestion, index) {
                var self = this
                self.availableQuestions.splice(index, 1)
                self.examDetails.sections[self.currentSection].questions.push(availableQuestion)
            },
            removeQuestionFromExam (index) {
                var self = this
                self.availableQuestions.push(self.examDetails.sections[self.currentSection].questions[index])
                self.examDetails.sections[self.currentSection].questions.splice(index, 1)
            },
            createExam () {
                var self = this
                axios.post('/user/createExam', self.examDetails)
                .then(function (response){
                    if(response.data.success) {
                        window.location = '/modules/' + self.examDetails.module_id + '/exams'
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
