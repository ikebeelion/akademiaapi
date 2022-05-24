<template>
    <div>
        <nav-bar/>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Assignment</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Assignment</a></li>
                        </ol>
                    </div>
                </div>

                        <!-- end row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div v-show="!viewAssignment">
                                            <div class="form-group">
                                            <label for="">Subject</label>
                                            <select class="form-control" v-model="assignment.subdetail" @change="getClassroomGroups()">
                                                <option value="">--</option>
                                                <option v-for="subject in subjectgroups" :value="{subject:subject.sub, groupid:subject.groupid }" :key="subject.sub">
                                                    {{ subject.subjecttitle }} - {{ subject.classgroupname }}
                                                </option>
                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Class Room</label>
                                            <select class="form-control" v-model="assignment.classroom" @change="checkInput">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroups" :value="classroom.id" :key="classroom.id">
                                                    {{ classroom.classgroup.classgroupname }} - {{ classroom.classroom.classroom }}
                                                </option>

                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea cols="30" rows="2" @input="checkInput" class="form-control" v-model="assignment.description" placeholder="..."></textarea>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Submission Date</label>
                                            <input type="date" class="form-control" @input="checkInput" v-model="assignment.submission_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="">Image/Diagram</label>
                                            <input type="file" class="form-control" @click="pickFile">
                                        </div>
                                        <center>
                                            <button class="btn btn-success col-8 mt-4 mb-4" v-show="updateMode == false" @click.prevent="submitAssignment" :disabled="checkFilled==true">Set Assignment</button>
                                            <button class="btn btn-success col-8 mt-4 mb-4" v-show="updateMode == true" @click.prevent="updateAssignment" :disabled="checkFilled==true">Update Assignment</button>

                                            <button class="btn btn-info col-4" @click.prevent="seeAssignment">View assignment</button>
                                        </center>
                                        </div>

                                        <div v-show="viewAssignment">
                                        <h1>View assignment</h1>
                                            <div class="form-group">
                                            <label for="">Subject</label>
                                            <select class="form-control" v-model="assignment.subdetail" @change="getClassroomGroups()">
                                                <option value="">--</option>
                                                <option v-for="subject in subjectgroups" :value="{subject:subject.sub, groupid:subject.groupid }" :key="subject.sub">
                                                    {{ subject.subjecttitle }} - {{ subject.classgroupname }}
                                                </option>
                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Class Room</label>
                                            <select class="form-control" v-model="assignment.classroom">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroups" :value="classroom.id" :key="classroom.id">
                                                    {{ classroom.classgroup.classgroupname }} - {{ classroom.classroom.classroom }}
                                                </option>

                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Submission Date</label>
                                            <input type="date" class="form-control col-4" v-model="assignment.submission_date" @input="getAssignment">
                                        </div>


                                     <div class="table-responsive mt-5">
                                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Class Room</th>
                                                    <th>Submission Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="assignment in allassignments" :key="assignment.assid">
                                                    <td>{{assignment.subjecttitle}}</td>
                                                    <td>{{assignment.classgroupname}}</td>
                                                    <td>{{assignment.submission_date}}</td>
                                                    <td>
                                                        <button class="btn btn-danger" @click.prevent="deleteAssignment(assignment.assid)">
                                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                        <button class="btn btn-info" @click.prevent="getSingleAssignment(assignment.assid)">
                                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <center>
                                            <button class="btn btn-info col-4" @click.prevent="seeAssignment">Goto Set Assignment</button>
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
    components: { NavBar},
    data() {
        return {
                viewAssignment:false,
                checkFilled:true,
                classroomgroups:null,
                subjectgroups:null,
                user:null,
                classid:null,
                students:null,
                selectedid:null,
                assignment:{
                    subdetail:null,
                    classroom:null,
                    submission_date:null,
                    description:null,
                    image:null
                },
                updateMode:false,
                allassignments:null
            }
    },

    methods: {
        checkInput(){
            if(this.assignment.subdetail && this.assignment.classroom != null && this.assignment.description != '' && this.assignment.submission_date != null)
            {
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },
        seeAssignment(){
            this.viewAssignment = !this.viewAssignment
            this.assignment.subdetail =null
                    this.assignment.classroom =null
                    this.assignment.submission_date =null
                    this.assignment.description = null
        },
        pickFile(e){
                let file = e.target.files[0]

                let reader = new FileReader()
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.assignment.image = reader.result
                        // this.image = reader.result
                    }
                    reader.readAsDataURL(file)
                }else{
                        swal.fire({
                                    icon: 'warning',
                                    title: 'Oooops',
                                    text: 'You are uploading a large file'
                            })
                }
        },
       getClassroomGroups(){
            axios.get('api/classgroups_group/'+this.assignment.subdetail.groupid).then((result) => {
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
        submitAssignment(){
            axios.post('api/assignment/store/', this.assignment).then((result) => {
                EventBus.$emit('assignmentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Assignment Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },
        getAssignment(){
            axios.get('api/assignments/'+this.assignment.classroom+'/'+this.assignment.subdetail.subject).then((result) => {
                this.allassignments = result.data
            }).catch((err) => {

            });
        },
        getSingleAssignment(id){
            axios.get('api/getSingleAssignment/'+id).then((result) => {
                this.assignment.subdetail.subject = result.data[0]['subjectid']
                this.assignment.classroom = result.data[0]['classid']
                this.assignment.submission_date = result.data[0]['submission_date']
                this.assignment.description = result.data[0]['description']
                this.assignment.image = result.data[0]['image']
                this.selectedid = result.data[0]['assid']
                this.updateMode = true
                this.viewAssignment = false
                this.checkFilled = false
            }).catch((err) => {

            });

        },
        updateAssignment(){
            axios.put('api/updateAssignment/'+this.selectedid, this.assignment).then((result) => {
                // EventBus.$emit('assignmentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Assignment Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.assignment.subdetail.subject = null
                this.assignment.classroom = null
                this.assignment.submission_date = null
                this.assignment.description = null
                this.assignment.image = null
                this.selectedid = null
                this.updateMode = false
                this.allassignments = null
            }).catch((err) => {

            });
        },

        deleteAssignment(id){
            axios.delete('api/delete-assignment/'+id).then((result) => {
                EventBus.$emit('assignmentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Assignment Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        }

    },


    created() {
        EventBus.$on('assignmentCrud',() => {
            this.getAssignment()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getSubjectGroup()
        }
        )
    },

}
</script>
