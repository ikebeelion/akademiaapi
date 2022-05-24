<template>
    <div>
        <nav-bar/>
                <div class="content-body">
                    <div class="container-fluid">
                        <!-- start page title -->
                           <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Attendance</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Attendance</a></li>
                        </ol>
                    </div>
                </div>

                        <!-- end page title -->

                        <!-- end row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div v-show="!viewAttendance">
                                            <div class="form-group">
                                            <label for="">Subject</label>
                                            <select class="form-control" v-model="attendance.subdetail" @change="getClassroomGroups()">
                                                <option value="">--</option>
                                                <option v-for="subject in subjectgroups" :value="{subject:subject.sub, groupid:subject.groupid }" :key="subject.sub">
                                                    {{ subject.subjecttitle }} - {{ subject.classgroupname }}
                                                </option>
                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Class Room</label>
                                            <select class="form-control" v-model="attendance.classroom" @change="getStudents()">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroups" :value="classroom.id" :key="classroom.id">
                                                    {{ classroom.classgroup.classgroupname }} - {{ classroom.classroom.classroom }}
                                                </option>

                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" v-model="attendance.date">
                                        </div>


                                     <div class="table-responsive mt-5">
                                            <table id="all-students" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Present</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="student in students" :key="student.studentuseraccountid">
                                                    <td>{{student.firstname}}</td>
                                                    <td>{{student.lastname}}</td>
                                                    <td>
                                                        <input type="checkbox" :value="{'studentuseraccount':student.studentuseraccountid, 'status':1}" v-model="student_attendance">
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <center>
                                            <button class="btn btn-success col-8 mb-4 mt-2" @click="saveAttendance" :disabled="student_attendance==''">Mark Attendance</button>

                                            <button class="btn btn-info col-4" @click="seeAttendance">View Attendance</button>
                                        </center>
                                        </div>

                                        <div v-show="viewAttendance">
                                        <h1>View Attendance</h1>
                                            <div class="form-group">
                                            <label for="">Subject</label>
                                            <select class="form-control" v-model="attendance.subdetail" @change="getClassroomGroups()">
                                                <option value="">--</option>
                                                <option v-for="subject in subjectgroups" :value="{subject:subject.sub, groupid:subject.groupid }" :key="subject.sub">
                                                    {{ subject.subjecttitle }} - {{ subject.classgroupname }}
                                                </option>
                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Class Room</label>
                                            <select class="form-control" v-model="attendance.classroom">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroups" :value="classroom.id" :key="classroom.id">
                                                    {{ classroom.classgroup.classgroupname }} - {{ classroom.classroom.classroom }}
                                                </option>

                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control col-4" v-model="attendance.date" @input="getAttendance">
                                        </div>


                                     <div class="table-responsive mt-5">
                                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Present</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="student in students" :key="student.id">
                                                    <td>{{student.firstname}}</td>
                                                    <td>{{student.lastname}}</td>
                                                    <td>{{student.status}}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <center>
                                            <button class="btn btn-info col-4" @click="seeAttendance">Goto Mark Attendance</button>
                                        </center>

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
                viewAttendance:false,
                checkFilled:true,
                classroomgroups:null,
                subjectgroups:null,
                user:null,
                classid:null,
                students:null,
                attendance:{
                    subdetail:null,
                    classroom:null,
                    date:null
                },
                student_attendance:[]
            }
    },

    methods: {
        seeAttendance(){
            this.viewAttendance = !this.viewAttendance
            this.attendance.subdetail =null
                    this.attendance.classroom =null
                    this.attendance.date =null
                this.student_attendance =[]
                this.students= null
        },

        getStudents(){
            axios.get('api/allstudentsclass/'+this.attendance.classroom).then((result) => {
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

       getClassroomGroups(){
            axios.get('api/classgroups_group/'+this.attendance.subdetail.groupid).then((result) => {
                this.classroomgroups = result.data
            }).catch((err) => {

            });
        },

        getSubjectGroup(){
           axios.get('api/suject_teacher/'+this.user.id).then((result) => {
                this.subjectgroups = result.data
            }).catch((err) => {

            });
        },
        saveAttendance(){
            var post = [this.attendance, this.student_attendance]
            axios.post('api/save_attendance/', post).then((result) => {
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Attendance Submitted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.attendance.subdetail =null
                    this.attendance.classroom =null
                    this.attendance.date =null
                this.student_attendance =[]
                this.students= null

            }).catch((err) => {

            });
        },
        getAttendance(){
            axios.get('api/attendance/'+this.attendance.classroom+'/'+this.attendance.subdetail.subject+'/'+this.attendance.date).then((result) => {
                this.students = result.data
            }).catch((err) => {

            });

        }

        },

    created() {
        EventBus.$on('userData', user => {
            this.user = user
            this.getSubjectGroup()
        }
        )
    },

}
</script>
