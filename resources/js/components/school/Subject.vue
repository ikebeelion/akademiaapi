<template>
    <div>
        <nav-bar/>
            <div class="content-body">
                <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Subjects</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Subjects</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Subject</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newSubject.subjecttitle" @input="checkInput">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label">Alias </label><small>(optional)</small>
                                                <input class="form-control" type="text" placeholder="..." v-model="newSubject.subject_alias" @input="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=addSubject v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateSubject() v-if="updateMode">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">All Subjects</h4>
                                        <p class="card-title-desc">Listed Below are all the registered Subjects in this school
                                        </p>

                                        <table id="all-subjects" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Alias</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="subject in subjects" :key="subject.id">
                                                <td>{{subject.subjecttitle}}</td>
                                                <td>{{subject.subject_alias}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteSubject(subject.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleSubject(subject.id)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
         </div>
</template>

<script>
import NavBar from '../NavBar.vue'
import { EventBus } from '../../app'
export default {
    components: {NavBar},
    data() {
        return {
                checkFilled:true,
                newSubject:{
                    subjecttitle:null,
                    subject_alias:null,
                },
                subjectid:null,
                updateMode:false,
                subjects:[],
                user:null,

            }
    },

    methods: {
        checkInput(){
            if(this.newSubject.subjecttitle != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getSubjects(){
            axios.get('api/subjects/'+this.user.branchid).then((result) => {
                this.subjects = result.data
                      $(function() {
                 $('#all-subjects').DataTable({
                dom: '<"ui center aligned"f><"ui segment"t><"right-aligned-panel"p>',
                language: {
                    info: "",
                    paginate: {
                        first: "first",
                        previous: "<i class='fa fa-chevron-left'></i>",
                        next: "<i class='fa fa-chevron-right'></i>",
                        last: "last"
                    }
                }
                });
            });
            }).catch((err) => {

            });
        },
        getSingleSubject(id){
            this.updateMode = true
            axios.get('api/singlesubject/'+id).then((result) => {
                this.newSubject.subjecttitle =  result.data.subjecttitle
                this.newSubject.subject_alias = result.data.subject_alias
                this.subjectid = result.data.id
            }).catch((err) => {

            });
        },

        addSubject(){
            var post = [this.newSubject, this.user.branchid]
            axios.post('api/subject/store', post).then((result) => {
                EventBus.$emit('subjectCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Subject Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.newSubject.subjecttitle = null
                this.newSubject.subject_alias = null
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Subject not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        updateSubject(){
            axios.put('api/updateSubject/'+this.subjectid , this.newSubject).then((result) => {
                EventBus.$emit('subjectCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Subject Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteSubject(id){
             axios.delete('api/deleteSubject/'+id).then((result) => {
                EventBus.$emit('subjectCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Subject Removed',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('subjectCrud', () => {
            this.getSubjects()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getSubjects()
        }
        )

    },

}
</script>
