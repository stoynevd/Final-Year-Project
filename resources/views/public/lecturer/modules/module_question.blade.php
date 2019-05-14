@extends('layouts/lecturer/lecturer')

@section('content')
    <div class="m-content" id="updateQuestion">
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
                            <button @click="deleteQuestion()" class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-trash"></i>
                                    <span> Delete Question </span>
                                </span>
                            </button>
                            <button @click="updateQuestion()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air ml-3">
                                <span>
                                    <i class="la la-pencil"></i>
                                    <span> Update Question </span>
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-if="modules.length == 0" class="m-portlet__body">
                You currently have no modules to add questions to.<br>
                Contact System Administrator to assign modules to your account.
            </div>
            <div v-else class="m-portlet__body">
                <a href="/modules/{{ $question->module_id }}/questions" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Go Back </a><br><br>
                <div class="form-group m-form__group">
                    <label for="exampleSelect1"> Module: </label>
                    <select v-model="question.module_id" class="form-control m-input m-input--solid">
                        <option value=""> Please, select a module </option>
                        <option v-for="module in modules" :value="module.id" :key="module.id"> @{{ module.course.shortName + module.id +  ' - ' + module.name }} </option>
                    </select>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleSelect1"> Question type: </label>
                    <select v-model="question.type" class="form-control m-input m-input--solid">
                        <option value=""> Please, select a question type </option>
                        <option value="Multiple"> Multiple choice </option>
                        <option value="Open"> Open answer </option>
                        <option value="Gaps"> Fill the gaps </option>
                    </select>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputEmail1"> Question's text: </label>
                    <textarea id="test1" v-model="question.text" class="form-control m-input m-input--solid" id="exampleTextarea" rows="3"></textarea>
                </div>
                <div class="form-group m-form__group" v-if="question.type == 'Multiple'">
                    <label> Question's answers: <button @click="question.answers.push({value: '', correct: false})" class="btn btn-sm btn-accent"> <i class="la la-plus"></i> </button> </label>
                    <br><br>
                    <template v-for="(answer, index) in question.answers" :key="index">
                        Answer #@{{ index + 1 }}: (@{{ answer.correct ? 'Correct' : 'Incorrect' }})
                        <button @click="question.answers.splice(index, 1)" class="btn btn-sm btn-danger"> Delete </button>
                        <button @click="answer.correct = !answer.correct" class="btn btn-sm btn-accent">
                            <i v-if="answer.correct" class="la la-times"></i>
                            <i v-else class="la la-check"></i>
                        </button><br>
                        <input v-model="answer.value" class="form-control m-input m-input--solid"/><br>
                    </template>
                </div>
                <div class="form-group m-form__group" v-if="question.type == 'Gaps'">
                    <label> Question's answers: <button @click="addSpace()" class="btn btn-sm btn-accent"> <i class="la la-plus"></i> </button> </label>
                </div>
                <div class="form-group m-form__group">
                    <label> Question's image </label><br>
                    <span v-if="question.imageUrl == null" class="bold"> You haven't uploaded an image for this question. </span>
                    <span v-else> <img :src="question.imageUrl" width="256"/> </span>
                    <br><br>
                    <span v-if="fileUploadStatus == false">
                        <button v-if="question.imageUrl == null" @click="fileUploadStatus = true" class="btn btn-primary"> Upload image </button>
                        <span v-else>
                            <button @click="fileUploadStatus = true" class="btn btn-primary"> Change image </button>
                            <button @click="removeImageFromQuestion()" class="btn btn-danger"> Remove image </button>
                        </span>
                    </span>
                    <input v-else @change="handleFileUpload($event)" type="file" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <script>
    new Vue ({
        el: '#updateQuestion',
        data: () => ({
            question: {!! $question !!},
            modules: {!! $modules !!},
            oldModuleId: '',
            fileUploadStatus: false
        }),
        mounted () {
            this.question.image = ''
            this.oldModuleId = this.question.module_id
        },
        methods: {
            handleFileUpload(e) {
                this.question.image = e.target.files[0]
            },
            updateQuestion () {
                var self = this
                let formData = new FormData()
                formData.append('id', self.question.id)
                formData.append('module_id', self.question.module_id)
                formData.append('type', self.question.type)
                formData.append('text', self.question.text)
                formData.append('answers', JSON.stringify(self.question.answers))
                formData.append('image', self.question.image)
                axios.post('/user/updateQuestion', formData)
                .then(function (response){
                    if(response.data.success) {
                        self.fileUploadStatus = false
                        self.question.imageUrl = response.data.imageUrl
                        swal({ type: 'success', title: 'Success', text: response.data.message }).then(() => {
                            if(self.oldModuleId != self.question.module_id) {
                                window.location = '/modules/' + self.question.module_id + '/questions/' + self.question.id
                            }
                        })
                    }
                    else {
                        swal({ type: 'error', title: 'Error', text: response.data.message })
                    }
                });
            },
            addSpace(){
                this.question.text += " [#" + ((this.question.text.match(/\[#/g) || []).length + 1) +"] ____ ";
            },
            deleteQuestion () {
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
                            id: self.question.id,
                            module_id: self.question.module_id
                        })
                        .then(function (response){
                            if(response.data.success) {
                                window.location = '/modules/' + self.question.module_id + '/questions'
                            }
                            else {
                                swal({ type: 'error', title: 'Error', text: response.data.message })
                            }
                        });
                    }
                })
            },
            removeImageFromQuestion () {
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
                        axios.post('/user/removeImageFromQuestion', {
                            id: self.question.id,
                            module_id: self.question.module_id
                        })
                        .then(function (response){
                            if(response.data.success) {
                                self.question.imageUrl = null
                                self.question.imageServerName = null
                                self.fileUploadStatus = false
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
