@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="createQuestion">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            New Question
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button v-if="modules.length > 0" @click="createQuestion()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span> Create Question </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-if="modules.length == 0" class="m-portlet__body">
                You currently have no modules to add questions to.<br>
                Contact System Administrator to assign modules to your account.
            </div>
            <div v-else class="m-portlet__body">
                <div class="form-group m-form__group">
                    <label for="moduleId"> Module: </label>
                    <select v-model="questionDetails.module_id" class="form-control m-input m-input--solid" id="moduleId">
                        <option value=""> Please, select a module </option>
                        <option v-for="module in modules" :value="module.id" :key="module.id"> @{{ module.course.shortName + module.id +  ' - ' + module.name }} </option>
                    </select>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleSelect1"> Question type: </label>
                    <select @change="questionDetails.answers = [];questionDetails.gapsAnswers = []" v-model="questionDetails.type" class="form-control m-input m-input--solid">
                        <option value=""> Please, select a question type </option>
                        <option value="Multiple"> Multiple choice </option>
                        <option value="Open"> Open answer </option>
                        <option value="Gaps"> Fill the gaps </option>
                    </select>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputEmail1"> Question's text: </label>
                    <textarea id="test1" v-model="questionDetails.text" class="form-control m-input m-input--solid" id="exampleTextarea" rows="3"></textarea>
                </div>
                <div class="form-group m-form__group" v-if="questionDetails.type == 'Multiple'">
                    <label> Question's answers: <button @click="questionDetails.answers.push({value: '', correct: false})" class="btn btn-sm btn-accent"> <i class="la la-plus"></i> </button> </label>
                    <br><br>
                    <template v-for="(answer, index) in questionDetails.answers" :key="index">
                        Answer #@{{ index + 1 }}: (@{{ answer.correct ? 'Correct' : 'Incorrect' }})
                        <button @click="questionDetails.answers.splice(index, 1)" class="btn btn-sm btn-danger"> Delete </button>
                        <button @click="answer.correct = !answer.correct" class="btn btn-sm btn-accent">
                            <i v-if="answer.correct" class="la la-times"></i>
                            <i v-else class="la la-check"></i>
                        </button><br>
                        <input v-model="answer.value" class="form-control m-input m-input--solid"/><br>
                    </template>
                </div>
                <div class="form-group m-form__group" v-if="questionDetails.type == 'Gaps'">
                    <label> Question's answers: <button @click="addSpace()" class="btn btn-sm btn-accent"> <i class="la la-plus"></i> </button> </label>
                </div>
                <div class="form-group m-form__group">
                    <label> Question's image </label><br>
                    <input @change="handleFileUpload($event)" type="file" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <script>
    new Vue ({
        el: '#createQuestion',
        data: () => ({
            modules: {!! $modules !!},
            questionDetails: {
                module_id: '',
                type: '',
                text: '',
                answers: [],
                image: ''
            }
        }),
        mounted () {
        },
        methods: {
            handleFileUpload(e) {
                this.questionDetails.image = e.target.files[0]
            },
            createQuestion () {
                var self = this
                let formData = new FormData()
                formData.append('module_id', self.questionDetails.module_id)
                formData.append('type', self.questionDetails.type)
                formData.append('text', self.questionDetails.text)
                formData.append('answers', JSON.stringify(self.questionDetails.answers))
                formData.append('image', self.questionDetails.image)
                axios.post('/user/createQuestion', formData)
                .then(function (response){
                    if(response.data.success) {
                        window.location = '/modules/' + self.questionDetails.module_id + '/questions'
                    }
                    else {
                        swal({ type: 'error', title: 'Error', text: response.data.message })
                    }
                });
            },
            addSpace(){
                this.questionDetails.text += " [#" + ((this.questionDetails.text.match(/\[#/g) || []).length + 1) +"] ____ ";
            }
        }

    })
    </script>
@stop
