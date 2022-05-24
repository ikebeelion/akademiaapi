<template>

    <div>
        <nav-bar/>
            <div class="content-body">
                    <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Payment</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Payment</a></li>
                        </ol>
                    </div>
                </div>
                    <div class="row" v-if="!resultMode">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                           <div class="form-group">
                                            <label for="">Academic Period</label>
                                            <select v-model="getResult.academicPeriodid" class="form-control" @change="checkInput">
                                                <option value="">select</option>
                                                <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                    {{ period.session.session }} - {{ period.term.term }}
                                                </option>
                                            </select>
                                        </div><br/>

                                        <div class="form-group">
                                            <label for="">Payment Type</label>
                                            <select class="form-control" v-model="getResult.classroom" @change="getStudentsInClass()">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroups" :value="classroom.clsrmgpid" :key="classroom.clsrmgpid">
                                                    {{ classroom.classgroupname }} - {{classroom.classroom}}
                                                </option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Class Group</label>
                                            <select class="form-control" v-model="getResult.classgroup" @change="makeNull()">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroup" :value="classroom.clgid" :key="classroom.clgid">
                                                    {{ classroom.classgroupname }}
                                                </option>

                                            </select>
                                        </div><br/>



                                                <div class="table-responsive mt-5">
                                            <table id="all-students" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="student in students" :key="student.studentuseraccountid">
                                                    <td>{{student.firstname}}</td>
                                                    <td>{{student.lastname}}</td>
                                                    <td>
                                                        <button class="btn btn-primary" @click.prevent=getStudentResult(student.studentuseraccountid)>
                                                            Generate Result
                                                        </button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div v-if="resultMode" id="result">
                        <!-- SCHOOL INFORMATION -->
                        <div>
                            <center>
                                <img :src="'images/school/'+this.schoolProfile.schoollogo" alt="school photo" height="80px" width="100px">
                                <h3>{{this.schoolProfile.schoolname}}</h3>
                                <p><strong>{{this.schoolProfile.address}}</strong></p>
                                <p class="lead"> {{ resultProfile[0].session }} ACADEMIC SESSION PERFORMANCE </p>

                            </center>
                        </div>
                        <center>
                            <div id="print">
                                <h1 class="text-primary" @click.prevent="print">
                                    <i class="fas fa-print"></i>
                                </h1>
                            </div>

                        </center>
                        <!-- STUDENT INFORMATION -->
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered dt-responsive nowrap w-100" id="align">
                                <tbody>
                                    <tr>
                                        <td><b class="mr-3">NAME OF STUDENT:</b>
                                            {{resultProfile[0].firstname}}{{ resultProfile[0].othername }} {{ resultProfile[0].lastname}}
                                        </td>
                                        <td><b class="mr-3">CLASSROOM:</b>
                                            {{resultProfile[0].classgroupname}} {{resultProfile[0].classroom}}
                                        </td>
                                        <td>
                                            <img :src="'images/students/'+this.resultProfile[0].photo" alt="student photo" height="70px" width="80px">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b class="mr-3">ACADEMIC YEAR:</b>
                                            {{resultProfile[0].year}}
                                        </td>
                                        <td><b class="mr-3">TERM:</b>
                                            {{resultProfile[0].term}}
                                        </td>
                                        <td><b class="mr-3">ACADEMIC SESSION:</b>
                                            {{resultProfile[0].session}}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- STUDENT RESULT -->
                        <div class="table-responsive mt-5">
                            <h4>Result</h4>
                            <table class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="thead thead-dark">
                                    <tr>
                                        <th>SUBJECT</th>
                                        <th>1st CA</th>
                                        <th>2nd CA</th>
                                        <th>3rd CA</th>
                                        <th>EXAM</th>
                                        <th>TOTAL</th>
                                        <th>GRADE</th>
                                        <th>REMARK</th>
                                    </tr>
                                </thead>
                                <tbody >
                                        <tr v-for="res in result" :key="res.id" >
                                            <td v-if="res != ''">{{res[0].subjecttitle}}</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && res[0].restult_typeid == 1">{{res[0].score_obtained}}</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && res[1].restult_typeid == 2">{{res[1].score_obtained}}</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && res[2].restult_typeid == 3">{{res[2].score_obtained}}</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && res[3].restult_typeid == 4">{{res[3].score_obtained}}</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != ''">{{ parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) }}</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">A</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70"> B </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60"> C </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50"> D </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" > F </td>

                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">DISTINCTION</td>
                                            <td v-if="res == ''">-</td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70"> VERY GOOD </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60"> CREDIT </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50"> PASS </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" > FAIL </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <p>
                                <b> A </b>= 70 and above,
                                <b> B </b> = 60 - 69,
                                <b> C </b> = 50 - 59,
                                <b> D </b> = 40 - 49,
                                <b> F </b> = 0 - 39
                            </p>
                        </div>
                        <!-- STUDENT PSYCHOMOTOR -->
                        <div class="row">
                            <div class="table-responsive mt-3 col-4">
                                <h4>AFFECTIVE PSYCHOMOTOR</h4>
                                <table class="table table-bordered dt-responsive nowrap w-100">
                                    <tbody >
                                            <tr v-for="psych in psych" :key="psych.id" >
                                                <td>{{psych.psychomotor}}</td>
                                                <td>{{psych.rating}}</td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class=" mt-3 col-2"></div>
                        <!-- STUDENT REMARK -->
                        <div class=" mt-3 col-6">
                            <h4>REMARKS</h4>
                                <div class="form-group mb-2">
                                    <label for="my-input">
                                        Teacher Remark: <b>{{remark[0].teacher_remark}}</b>

                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="my-input">
                                        Principal Remark: <b>{{remark[0].principal_remark}}</b>

                                    </label>
                                </div>
                        </div>
                        </div>
                        <!-- SIGN -->
                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4">
                                <p><b><i>
                                    {{principalOfficer[0].title}} {{principalOfficer[0].firstname}} {{principalOfficer[0].lastname}}<br>
                                        Principal
                                </i></b><br>
                                {{date}}
                                </p>
                            </div>
                        </div>


                        </div>
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
                viewAttendance:false,
                checkFilled:true,
                classroomgroups:null,
                classroomgroup:null,
                user:null,
                students:null,
                academicPeriods:null,
                resultMode:false,
                getResult:{
                    academicPeriodid:null,
                    classroom:null,
                    classgroup:null
                },
                psych:null,
                remark:null,
                result:null,
                subjects:null,
                classid:null,
                resultProfile:null,
                principalOfficer:null,
                schoolProfile:{
                    schoolname:null,
                    alias:null,
                    schoolemail:null,
                    schooltel:null,
                    schoollogo:null,
                    schoolmotto:null,
                    address:null,
                    countryid:null,
                    stateid:null,
                    cityid:null,
                    year_of_establishment:null,
                    schoolzone:null,
                    schoolchapter:null,
                    associationAffiliation:null,
                    educationDistrict:null,
                    date:null
                },
            }
    },

    methods: {
        checkInput(){},
        makeNull(){
            this.getClassRoomTeacher()
        },
       getStudentsInClass(){
           this.getSubjectGroups()
            axios.get('api/allstudentsclass/'+this.getResult.classroom).then((result) => {
                this.students = result.data
                 $(function() {
            $('#all-students').DataTable({
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

        getClassRoomTeacher(){
            axios.get('api/classroom_teacher/'+this.user.id+'/'+this.getResult.classgroup).then((result) => {
                this.classroomgroups = result.data
            }).catch((err) => {

            });
        },
        getClassGroups(){
            axios.get('api/classroom_teacher/'+this.user.id).then((result) => {
                this.classroomgroup = result.data
            }).catch((err) => {

            });
        },
        getSubjectGroups(){
            axios.get('api/subjectGrpres/'+this.getResult.classgroup).then((result) => {
                this.subjects = result.data
            }).catch((err) => {

            });
        },

        getPrincipalOfficer(){
            axios.get('api/principalOfficer/'+this.user.branchid).then((result) => {
                this.principalOfficer = result.data
            }).catch((err) => {

            });
        },

        getStudentResult(studentid){
            for (const key in this.subjects) {
                if (Object.hasOwnProperty.call(this.subjects, key)) {
                    const element = this.subjects[key];
                    // alert(element.id)
                    var student_result = []

                    axios.get('api/result/'+studentid+'/'+this.getResult.academicPeriodid+'/'+element.id).then((result) => {
                        this.resultMode = true
                        student_result.push(result.data)
                        this.result = student_result
                        var student_profile = []

                        axios.get('api/result-profile/'+studentid+'/'+this.getResult.academicPeriodid+'/'+element.id).then((result) => {
                            student_profile.push(result.data)
                            this.resultProfile = student_profile
                        }).catch((err) => {

                        });
                    }).catch((err) => {
                    });
                }
            }
            this.getPsychoMotor(studentid)
            this.getRemarks(studentid)
        },

        getSchoolInfo(){
            axios.get('api/index/'+this.user.branch.schoolid).then((result) => {
                this.schoolProfile.schoolname = result.data['schoolname']
                this.schoolProfile.alias = result.data['alias']
                this.schoolProfile.schoolemail = result.data['schoolemail']
                this.schoolProfile.schooltel = result.data['schooltel']
                this.schoolProfile.schoollogo = result.data['schoollogo']
                this.schoolProfile.schoolmotto = result.data['schoolmotto']
                this.schoolProfile.address = result.data['address']
                this.schoolProfile.countryid = result.data['countryid']
                this.schoolProfile.stateid = result.data['stateid']
                this.schoolProfile.cityid = result.data['cityid']
                this.schoolProfile.year_of_establishment = result.data['year_of_establishment']
                this.schoolProfile.schoolzone = result.data['schoolzone']
                this.schoolProfile.schoolchapter = result.data['schoolchapter']
                this.schoolProfile.associationAffiliation = result.data['associationAffiliation']
                this.schoolProfile.educationDistrict = result.data['educationDistrict']
                EventBus.$emit('updateFetch')

            }).catch((err) => {

            });
        },
        getPsychoMotor(studentid){
            axios.get('api/psych/'+studentid+'/'+this.getResult.academicPeriodid).then((result) => {
                this.psych = result.data
            }).catch((err) => {

            });
        },

        getRemarks(studentid){
            axios.get('api/remark/'+studentid+'/'+this.getResult.academicPeriodid).then((result) => {
                this.remark = result.data
            }).catch((err) => {

            });
        },


        getAcademicPeriod(){
            axios.get('api/period/'+this.user.branchid).then((result) => {
                this.academicPeriods = result.data
            }).catch((err) => {

            });
        },

        print(){
            var x = document.getElementById('print')
            x.style.display = "none"
            window.print()
        },

        getCurrentDate(){
            let today = new Date()
            let month = today.getMonth()
            let year = today.getFullYear()
            let date = today.getDate()
            let current_date = month+'/'+date+'/'+year

            this.date = current_date
        }




        },

    created() {
        EventBus.$on('userData', user => {
            this.user = user
            this.getSchoolInfo()
            this.getPrincipalOfficer()
            this.getAcademicPeriod()
            this.getClassGroups()
            this.getCurrentDate()

        }
        )
    },

}
</script>

<style scoped>
    #align{
        vertical-align: middle;
    }
    @media print{
    body *{
        visibility: hidden;
        }
    #result, #result * {
        visibility: visible
    }
    #result {
        position: absolute;
        left:0;
        top:0;
        right: 0;

    }
    }
</style>
