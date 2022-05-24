<template>
    <div>
        <nav-bar/>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Student Details</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Student Details</a></li>
                        </ol>
                    </div>
                </div>

                            <div class="row mb-5">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                                <h4>Assign Student To Class Room </h4><br/>
                                                <div class="form-gorup">
                                                    <label for="">Current Class Group</label>
                                                    <input type="text" class="form-control" readonly
                                                        v-model="studentData[0].class_group.classgroupname">
                                                </div>
                                                <div class="form-gorup mt-3">
                                                    <label for="">Select Class Room</label>
                                                    <select class="form-control" v-model="newClassDetails.classroom" @change="addGroup">
                                                        <option value="">select</option>
                                                        <option v-for="classRoom in classRooms"
                                                        :value="classRoom.id"
                                                        :key="classRoom.id">
                                                            {{ classRoom.class_room.classroom }}
                                                        </option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button class="btn btn-success mt-3" @click.prevent="addStudentToClassRoom">Add Student To Class</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-5">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <h4>Student Academic Record </h4><br/>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->
        <footer-bar/>
    </div>
</template>

<script>
import FooterBar from '../Footer.vue'
import NavBar from '../NavBar.vue'
import { EventBus } from '../../app'
import axios from 'axios'
export default {
    components: {FooterBar, NavBar},
    data() {
        return {
                user:null,
                studentid:null,
                studentData:null,
                classRooms:null,
                newClassDetails:{
                    student:null,
                    classroom:null
                }
            }
    },
    methods: {
        addGroup(){
            this.newClassDetails.student = this.studentid
        },
        addStudentToClassRoom(){
            axios.post('api/studentclassroom', this.newClassDetails).then((result) => {
                   swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student Classroom is set',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.studentData = null
            }).catch((err) => {
                   swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Did not Assign',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        addIdToStorage(){
            var studentid = null
            if(localStorage.getItem('studentid')){
                studentid = JSON.parse(localStorage.getItem('studentid'))
                }
                if(this.$route.params.id != ''){
                    studentid = this.$route.params.id
                    localStorage.setItem('studentid', JSON.stringify(studentid));
                }
                EventBus.$emit('studentid')
        },
        getSingleStudent(){
            axios.get('api/user/'+this.studentid).then((result) => {
                   this.studentData = result.data
                axios.get('api/yearclassroom/'+this.studentData[0].yearid).then((result) => {
                    this.classRooms = result.data
                        }).catch((err) => {

                    });
            }).catch((err) => {

            });
        },
    },

    created() {
        this.studentid = parseInt(localStorage.getItem('studentid'))
        this.getSingleStudent()
        EventBus.$on('userData', user => {
            this.user = user
            }
        )


    },

}
</script>
