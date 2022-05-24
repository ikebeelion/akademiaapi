<template>
    <div>
        <nav-bar/>
                  <div class="content-body">
                <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Subject Groups</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Subject Groups</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                    <label class="form-label ">Class Group</label>
                                                    <select
                                                        class="form-control"
                                                        v-model="newSubjectGroup.classgroup"
                                                        @change="checkInput"
                                                        >
                                                        <option>Select</option>
                                                        <option v-for="group in classgroups" :key="group.id" :value="group.id">{{ group.classgroupname }}</option>
                                                    </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                    <label class="form-label ">Subject</label>
                                                    <select
                                                        class="form-control "
                                                        v-model="newSubjectGroup.subject"
                                                        @change="checkInput"
                                                    >
                                                        <option>Select</option>
                                                        <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{ subject.subjecttitle }}</option>
                                                    </select>
                                            </div>
                                                <div class="form-group mb-2">
                                                    <label class="form-label ">Credit Load</label>
                                                    <input type="number" class="form-control "
                                                        v-model="newSubjectGroup.load"
                                                        @change="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=assignSubjectGroup v-if="!updateMode" :disabled="this.checkFilled == true">Assign</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateSubjectGroup() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">Assigned Subjects to Class Groups</h4>
                                        <p class="card-title-desc">Listed Below are all the assigned subjects in this school
                                        </p>

                                        <table id="all-subjects" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Class Group</th>
                                                <th>Credit Load</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="subjectGroup in subjectGroups" :key="subjectGroup.id">
                                                <td>{{subjectGroup.subjecttitle}}</td>
                                                <td>{{subjectGroup.classgroupname}}</td>
                                                <td>{{subjectGroup.credit_load}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteSubjectGroup(subjectGroup.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleSubjectGroup(subjectGroup.id)">
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
    components: { NavBar},
    data() {
        return {
                checkFilled:true,
                newSubjectGroup:{
                    subject:null,
                    classgroup:null,
                    load:null,
                },
                updateMode:false,
                user:null,
                subjects:[],
                classgroups:[],
                subjectGroups:[],
                subjgroupid:null

            }
    },

    methods: {
        checkInput(){
            if(this.newSubjectGroup.subject != null && this.newSubjectGroup.classgroup != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getSubjects(){
            axios.get('api/subjects/'+this.user.branchid).then((result) => {
                this.subjects = result.data

            }).catch((err) => {

            });
        },

        getClassGroups(){
            axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                this.classgroups = result.data
            }).catch((err) => {

            });
        },

        getSubjectGroup(){
            axios.get('api/subjectGroup/'+this.user.branchid).then((result) => {
                this.subjectGroups = result.data
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

        getSingleSubjectGroup(id){
            this.updateMode = true
            axios.get('api/singlesubjectgroup/'+id).then((result) => {
                this.newSubjectGroup.subject =  result.data.subjectid
                this.newSubjectGroup.classgroup = result.data.classgroupid
                this.newSubjectGroup.load = result.data.credit_load
                this.subjgroupid = result.data.id
            }).catch((err) => {

            });
        },

        assignSubjectGroup(){
            axios.post('api/subjectGroup/store', this.newSubjectGroup).then((result) => {
                EventBus.$emit('subjectGroupCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Subject Group Assigned',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                 swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Subject Group not Assigned',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        updateSubjectGroup(){
            axios.put('api/updateSubjectGroup/'+this.subjgroupid , this.newSubjectGroup).then((result) => {
                EventBus.$emit('subjectGroupCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Subject Group updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {
                  swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Subject Group not updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        deleteSubjectGroup(id){
             axios.delete('api/deleteSubjectGroup/'+id).then((result) => {
                EventBus.$emit('subjectGroupCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Room Group Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {});
        }
    },

    created() {
        EventBus.$on('subjectGroupCrud', () => {
            this.getSubjectGroup()
        })
        EventBus.$on('userData', user => {
                this.user = user
                this.getSubjects()
                this.getClassGroups()
                this.getSubjectGroup()
            }
        )

    },

}
</script>
