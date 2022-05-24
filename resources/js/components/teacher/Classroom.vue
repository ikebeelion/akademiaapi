<template>
 <div>
        <nav-bar/>
            <div class="content-body">
                    <div class="container-fluid">
                        <!-- start page title -->
                           <div class="row page-titles mx-0">
                            <div class="col-sm-6 p-md-0">
                                <div class="welcome-text">
                                    <h4>Class Rooms Managed</h4>
                                </div>
                            </div>
                            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                                    <li class="breadcrumb-item active"><a href="#">Classroom</a></li>
                                </ol>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- end row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Classrom Managed</h4><s></s>
                                        <p class="card-title-desc">Listed Below are all the Classes Managed By Form Teacher
                                        </p>
                                        <div v-if="classroomsmgd != ''">
                                            <div v-for="clsmgd in classroomsmgd" :key="clsmgd.id">
                                                <center>
                                                    <td></td><button class="btn btn-primary col-6 mb-2" @click="goToClass(clsmgd.clsrmgpid )">{{ clsmgd.classgroupname }} - {{clsmgd.classroom}}</button>
                                                </center>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <h1 class="lead">NOT MANAGING ANY CLASSROOM</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Class Groups Taught</h4><s></s>
                                        <p class="card-title-desc">Listed Below are all the Classes Groups Taught</p>
                                        <div v-if="glassGroupManaged != ''">
                                            <div v-for="clsmgd in glassGroupManaged" :key="clsmgd.id">
                                                <center>
                                                    <button class="btn btn-primary col-4 mb-2" @click="goToClassGroup(clsmgd.clgrid, clsmgd.sclid )">{{ clsmgd.classgroupname }} - {{clsmgd.subjecttitle}}</button>
                                                </center>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <h1 class="lead">NOT TEACHING ANY CLASS GROUP</h1>
                                        </div><br>

                                        <table class="table" id="my-table">
                                            <thead>
                                                <tr>
                                                    <td>Firstname</td>
                                                    <td>Lastname</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="student in students" :key="student.id">
                                                    <td>{{student.firstname}}</td>
                                                    <td>{{student.lastname}}</td>
                                                    <td>
                                                        <button class="btn btn-secondary" @click="openModal(student.studentuseraccountid)">
                                                            Score Student
                                                        </button>
                                                        <button class="btn btn-info" @click="openCommentDomain(student.studentuseraccountid)">
                                                            Comment on student Performace
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
                <div id="student-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">Score Student</h5>
                                <button class="btn btn-danger" @click="hideModal" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"> &times </span>
                                </button>
                            </div>
                            <div class="modal-body">
                                                         <div>

                                                            <div class="form-group mb-2">
                                                                <label class="form-label">Result Type</label>
                                                                <select v-model="scoreStudent.resultTypeid" class="form-control" @change="checkInput">
                                                                <option value="">select</option>
                                                                    <option v-for="type in resultTypes" :key="type.id" :value="type.id">
                                                                        {{ type.resulttype }}
                                                                    </option>
                                                                </select>
                                                                <label class="form-label">Academic Period</label>
                                                                <select v-model="scoreStudent.academicPeriodid" class="form-control" @change="checkInput">
                                                                    <option value="">select</option>
                                                                    <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                                        {{ period.session.session }} - {{ period.term.term }}
                                                                    </option>
                                                                </select>
                                                                <label class="form-label">Subject</label>
                                                                <select v-model="scoreStudent.subjectid" class="form-control" @change="checkInput">
                                                                    <option value="">select</option>
                                                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                                                        {{ subject.subjecttitle }} - {{subject.classgroupname}}
                                                                    </option>
                                                                </select>
                                                                <label class="form-label">Score Obtained</label>
                                                                <input type="number" step="any" class="form-control" v-model="scoreStudent.score">
                                                            </div>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" :disabled="checkFilled == true" @click="scoreStudentResult()">
                                                            Submit
                                                        </button>
                                                    </div>
                        </div>
                    </div>
                </div>
                <!-- End Page-content -->
                <div id="comment-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">Add Comment</h5>
                                <button class="btn btn-danger" @click="hideModal" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"> &times </span>
                                </button>
                            </div>
                            <div class="modal-body">
                                                         <div>

                                                            <div class="form-group mb-2">
                                                                <label class="form-label">Academic Period</label>
                                                                <select v-model="performanceComment.academicPeriodid" class="form-control" @change="commentInput">
                                                                    <option value="">select</option>
                                                                    <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                                        {{ period.session.session }} - {{ period.term.term }}
                                                                    </option>
                                                                </select>
                                                                <label class="form-label">Subject</label>
                                                                <select v-model="performanceComment.subjectid" class="form-control" @change="commentInput">
                                                                    <option value="">select</option>
                                                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                                                        {{ subject.subjecttitle }} - {{subject.classgroupname}}
                                                                    </option>
                                                                </select>
                                                                <label class="form-label">Comment</label>
                                                                <textarea class="form-control" @input="commentInput" v-model="performanceComment.comment" id="" cols="30" rows="2"></textarea>
                                                                <label class="form-label">C.A</label>
                                                                <input type="number" step="any" class="form-control" v-model="performanceComment.ca">
                                                                <label class="form-label">Exam</label>
                                                                <input type="number" step="any" class="form-control" v-model="performanceComment.exam">
                                                                <label class="form-label">Score</label>
                                                                <input type="number" step="any" class="form-control" v-model="performanceComment.score">
                                                                <label class="form-label">Average</label>
                                                                <input type="number" step="any" class="form-control" v-model="performanceComment.avg">

                                                            </div>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" :disabled="checkComment"  @click="addComment()">
                                                            Submit
                                                        </button>
                                                    </div>
                        </div>
                    </div>
                </div>


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
                checkComment:true,
                classroomsmgd:null,
                user:null,
                glassGroupManaged:null,
                students:null,
                academicPeriods:null,
                resultTypes:null,
                selectedsubject:null,
                scoreStudent:{
                    resultTypeid:null,
                    academicPeriodid:null,
                    subjectid:null,
                    studentid:null,
                    score:null,
                    classid:null,
                },
                performanceComment:{
                    comment:null,
                    academicPeriodid:null,
                    subjectid:null,
                    studentid:null,
                    ca:null,
                    exam:null,
                    score:null,
                    avg:null,
                },
                subjects:null,

            }
    },

    methods: {
        openCommentDomain(id){
            $('#comment-model').modal('show')
            this.performanceComment.studentid = id
        },
        hideCommentModal(id){
            $('#comment-model').modal('hide')
        },

        checkInput(){
            if(this.scoreStudent.resultTypeid != null && this.scoreStudent.academicPeriodid && this.scoreStudent.subjectid != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        commentInput(){
            if(this.performanceComment.academicPeriodid != null && this.performanceComment.subjectid != null && this.performanceComment.comment != null){
                this.checkComment = false
            }else{
                this.checkComment = true
            }
        },

        goToClass(id){
             var classid = null
                if(localStorage.getItem('classid')){
                    classid = localStorage.getItem('classid')

                }
                    if(this.$route.params.id != ''){
                    classid = id
                    localStorage.setItem('classid', classid);
                }
            EventBus.$emit('classid')
            this.$router.push({name:'MyClass', params:{id:id}})
        },

        getClassRoomTeacher(){
            axios.get('api/classroom_teacher/'+this.user['id']).then((result) => {
                this.classroomsmgd = result.data
            }).catch((err) => {

            });

        },

        getClassGroupsTaught(){
            axios.get('api/get-students/'+this.user['id']).then((result) => {
                this.glassGroupManaged = result.data
            }).catch((err) => {

            });
        },

        getStudentClassRoom(){
            axios.get('api/studentClassroom/'+this.scoreStudent.studentid).then((result) => {
                this.scoreStudent.classid = result.data['classroomgroupid']
            }).catch((err) => {

            });
        },



        goToClassGroup(id, subject){
            axios.get('api/get-students-sub/'+id).then((result) => {
                this.selectedsubject =  subject
                this.getSubjectGroups()
                        $(function() {
                    $('#my-table').DataTable({
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
                this.students = result.data



            }).catch((err) => {

            });
        },

        getSubjectGroups(){
            axios.get('api/subjectGrpc/'+this.selectedsubject).then((result) => {
                this.subjects = result.data
            }).catch((err) => {

            });
        },

        getAcademicPeriod(){
            axios.get('api/period/'+this.user.branchid).then((result) => {
                this.academicPeriods = result.data
            }).catch((err) => {

            });
        },

        getResultTypes(){
            axios.get('api/type/'+this.user.branchid).then((result) => {
                this.resultTypes = result.data
            }).catch((err) => {

            });
        },

        scoreStudentResult(){
            axios.post('api/score/', this.scoreStudent).then((result) => {
                this.scoreStudent.resultTypeid = null
                this.scoreStudent.academicPeriodid = null
                this.scoreStudent.subjectid = null
                // this.scoreStudent.studentid = null
                this.scoreStudent.score = null
                 swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Uploaded Successfully',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                if(err.response.status == 400){
                  swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Score Assigned is higher than the score for selected result type',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                }else{
                    swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Record already exists for this academic period',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                }
            });
        },

        openModal(id){
            $('#student-modal').modal('show')
            this.scoreStudent.studentid = id
            this.getStudentClassRoom()
        },

        hideModal(){
            $('#student-modal').modal('hide')
            this.scoreStudent.resultTypeid = null
            this.scoreStudent.academicPeriodid = null
            this.scoreStudent.subjectid = null
            // this.scoreStudent.studentid = null
            this.scoreStudent.score = null

        },

        addComment(){
            axios.post('api/comment/store/', this.performanceComment).then((result) => {
                this.performanceComment.comment = null
                this.hideCommentModal()
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Uploaded Successfully',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 3000
                    })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            });
        }



    },


    created() {
        EventBus.$on('userData', user => {
            this.user = user
            this.getClassRoomTeacher()
            this.getClassGroupsTaught()
            this.getAcademicPeriod()
            this.getResultTypes()
        }
        )
    },

}
</script>
