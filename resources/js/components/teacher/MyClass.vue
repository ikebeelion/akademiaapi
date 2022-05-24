<template>
     <div>
        <nav-bar/>
            <div class="content-body">
                    <div class="container-fluid">
                           <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>My Class</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">My class</a></li>
                        </ol>
                    </div>
                </div>

                        <!-- end row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">All Students in {{ this.classdetail.classgroupname }} {{ this.classdetail.classroom }}</h4><s></s>
                                        <p class="card-title-desc">Listed Below are all the Students in this classroom
                                        </p>

                                         <div class="table-responsive">
                                            <table id="my-table" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Gender</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="student in students" :key="student.studentuseraccountid">
                                                    <td>{{student.firstname}}</td>
                                                    <td>{{student.lastname}}</td>
                                                    <td>{{student.genderid}}</td>
                                                    <td>
                                                        <button class="btn btn-secondary" @click="openModal(student.studentuseraccountid)">
                                                            Score Student
                                                        </button>
                                                        <button class="btn btn-info" @click="openPRModal(student.studentuseraccountid)">
                                                            Psychomotor & Remarks
                                                        </button>
                                                        <button class="btn btn-dark" @click="openAffectiveModal(student.studentuseraccountid)">
                                                            Affective Domain
                                                        </button>

                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="student-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="my-modal-title">Score Student</h5>
                                                        <button class="btn btn-danger" @click="hideModal" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">
                                                            &times
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                         <div>
                                            <h3>Score Student</h3>
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
                                                            score
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- REMARK AND PSYCHOMOTOR MODAL -->
                                        <div id="remark-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="my-modal-title">Psychomotor Domain and Remark</h5>
                                                        <button class="btn btn-danger" @click="hideRemarkModal" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                         <div>
                                                            <div class="form-group mb-2">
                                                                <label class="form-label">Academic Period</label>
                                                                <select v-model="psychomotorRemarks.academicPeriodid" class="form-control" @change="checkInput2">
                                                                    <option value="">select</option>
                                                                    <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                                        {{ period.session.session }} - {{ period.term.term }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-4">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Psychomotor</td>
                                                                            <td>Rating</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="motor in psychtypes" :key="motor.id">
                                                                            <td>{{motor.psychomotor}}</td>
                                                                            <td v-for="rating in psychratings" :key="rating.id">
                                                                                <label for="" class="form-label">{{rating.rating}}</label>
                                                                                 <input type="checkbox" :value="{psychtype:motor.id, rating:rating.id}" v-model="psychomotorRemarks.psychomotor" @input="checkInput2">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="form-label">Principal Remark</label>
                                                                <input type="text" @input="checkInput2" class="form-control" placeholder="..." v-model="psychomotorRemarks.remarks.principal">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="form-label">Class Teacher Remark</label>
                                                                <input type="text" @input="checkInput2" class="form-control" placeholder="..." v-model="psychomotorRemarks.remarks.teacher">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" :disabled="checkFilled == true" @click="submitPsychMOtor()">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- AFFECTIVE DOMAIN -->
                                        <div id="domain-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="my-modal-title">Affective Domain</h5>
                                                        <button class="btn btn-danger" @click="hideAffectiveModal" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                         <div>
                                                            <div class="form-group mb-2">
                                                                <label class="form-label">Academic Period</label>
                                                                <select v-model="domain.academicPeriodid" class="form-control" @change="checkInput3">
                                                                    <option value="">select</option>
                                                                    <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                                        {{ period.session.session }} - {{ period.term.term }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-4">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Domain</td>
                                                                            <td>Rating</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="dom in domains" :key="dom.id">
                                                                            <td>{{dom.affective_domain}}</td>
                                                                            <td v-for="rating in psychratings" :key="rating.id">
                                                                                <label for="" class="form-label">{{rating.rating}}</label>
                                                                                 <input type="checkbox" :value="{domaintype:dom.id, rating:rating.id}" v-model="domain.affective_domain" @input="checkInput3">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" :disabled="checkFilled == true" @click="submitAffectiveDomain()">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                user:null,
                classid:null,
                classdetail:null,
                students:null,
                studentid:null,
                resultTypes:null,
                academicPeriods:null,
                subjects:null,
                psychtypes:null,
                psychratings:[{id:1, rating:1},
                {id:2, rating:2},
                {id:3, rating:3},
                {id:4, rating:4},
                {id:5, rating:5}
                ],
                scoreStudent:{
                    resultTypeid:null,
                    academicPeriodid:null,
                    subjectid:null,
                    studentid:null,
                    score:null,
                    classid:null,
                },
                psychomotorRemarks:{
                    studentid:null,
                    academicPeriodid:null,
                    psychomotor:[],
                    remarks: {
                            teacher:null,
                            principal:null
                        }

                },
                domains:null,
                domain:{
                    studentid:null,
                    academicPeriodid:null,
                    affective_domain:[],
                }

            }
    },

    methods: {
        checkInput(){
            if(this.scoreStudent.resultTypeid != null && this.scoreStudent.academicPeriodid && this.scoreStudent.subjectid != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }

        },

        checkInput2(){
            if(this.psychomotorRemarks.academicPeriodid != null && this.psychomotorRemarks.psychomotor != [] && this.psychomotorRemarks.remarks.teacher != null && this.psychomotorRemarks.remarks.principal !=null ){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },
         checkInput3(){
            if(this.domain.academicPeriodid != null && this.domain.affective_domain != []  ){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getPsych(){
            axios.get('api/psychomotors/'+this.user.branchid).then((result) => {
                this.psychtypes = result.data
            }).catch((err) => {

            });
        },

        getStudentsInClass(){
            axios.get('api/allstudentsclass/'+this.classid).then((result) => {
                this.students = result.data
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


            }).catch((err) => {

            });
        },

        getClassgroup(){
            axios.get('api/singleroomgroup/'+this.classid).then((result) => {
                this.classdetail = result.data
            }).catch((err) => {

            });
        },

        openModal(id){
            $('#student-modal').modal('show')
            this.scoreStudent.studentid = id

        },

        openPRModal(id){
            $('#remark-modal').modal('show')
            this.psychomotorRemarks.studentid = id
        },

        openAffectiveModal(id){
            $('#domain-modal').modal('show')
            this.domain.studentid = id
        },

        hideModal(){
            $('#student-modal').modal('hide')
            this.scoreStudent.resultTypeid = null
            this.scoreStudent.academicPeriodid = null
            this.scoreStudent.subjectid = null
            // this.scoreStudent.studentid = null
            this.scoreStudent.score = null

        },

        hideRemarkModal(){
            $('#remark-modal').modal('hide')
        },

        hideAffectiveModal(){
            $('#domain-modal').modal('hide')
        },

        getResultTypes(){
            axios.get('api/type/'+this.user.branchid).then((result) => {
                this.resultTypes = result.data
            }).catch((err) => {

            });
        },

        getAcademicPeriod(){
            axios.get('api/period/'+this.user.branchid).then((result) => {
                this.academicPeriods = result.data
            }).catch((err) => {

            });
        },

        getSubjectGroups(){
            axios.get('api/subjectGrp/'+this.classid).then((result) => {
                this.subjects = result.data
            }).catch((err) => {

            });
        },

        submitPsychMOtor(){
            axios.put('api/deletepsychmotor', this.psychomotorRemarks).then((result) => {
                axios.post('api/storepsychmotor', this.psychomotorRemarks).then((result) => {
                    this.psychomotorRemarks.remarks.teacher = null
                    this.psychomotorRemarks.remarks.principal = null
                    this.psychomotorRemarks.psychomotor = []
                    this.psychomotorRemarks.studentid = null
                    this.psychomotorRemarks.academicPeriodid = null
                    this.hideRemarkModal()

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
                    title: 'Error Uploading Psychomotor',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
            }).catch((err) => {

            });

        },

        getDomains(){
            axios.get('api/domains/'+this.user.branchid).then((result) => {
                this.domains = result.data
            }).catch((err) => {

            });
        },
        submitAffectiveDomain(){
            axios.put('api/deletedomain', this.domain).then((result) => {
                axios.post('api/storedomain', this.domain).then((result) => {
                    this.domain.affective_domain = []
                    this.domain.studentid = null
                    this.domain.academicPeriodid = null
                    this.hideAffectiveModal()

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
                    title: 'Error Uploading Affective Domain',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
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



    },

    created() {
        this.classid = parseInt(localStorage.getItem('classid'))
        this.scoreStudent.classid = this.classid
        EventBus.$on('userData', user => {
                this.user = user
                this.getAcademicPeriod()
                this.getResultTypes()
                this.getSubjectGroups()
                this.getPsych()
                this.getDomains()
            },
        )
        this.getClassgroup()
        this.getStudentsInClass()


    },

}
</script>
