<template>
    <div>
        <nav-bar/>
              <div class="content-body">
                <div class="container-fluid">
                    <div class="row page-titles mx-0">
                        <div class="col-sm-6 p-md-0">
                            <div class="welcome-text">
                                <h4>Class Rooms Groups</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                                <li class="breadcrumb-item active"><a href="#">Class Rooms Groups</a></li>
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
                                                        v-model="newClassRoomGroup.classgroup"
                                                        @change="checkInput"
                                                        >
                                                        <option>Select</option>
                                                        <option v-for="group in classgroups" :key="group.id" :value="group.id">{{ group.classgroupname }}</option>
                                                    </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                    <label class="form-label ">Class Room</label>
                                                    <select
                                                        class="form-control "
                                                        v-model="newClassRoomGroup.classroom"
                                                        @change="checkInput"
                                                    >
                                                        <option>Select</option>
                                                        <option v-for="room in classrooms" :key="room.id" :value="room.id">{{ room.classroom }}</option>
                                                    </select>
                                            </div>

                                            <button class="btn btn-success mt-1 col-4" @click.prevent=assignClassRoomGroup v-if="!updateMode" :disabled="this.checkFilled == true">Assign</button>
                                            <button class="btn btn-success mt-1 col-4" @click.prevent=updateRoomGroup() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">Assigned Class Rooms to Class Groups</h4>
                                        <p class="card-title-desc">Listed Below are all the assigned class Rooms in this school
                                        </p>

                                        <table id="all-roomgroups" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Class Room</th>
                                                <th>Class Group</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="classRoomGroup in roomGroups" :key="classRoomGroup.id">
                                                <td>{{classRoomGroup.classroom}}</td>
                                                <td>{{classRoomGroup.classgroupname}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteRoomGroup(classRoomGroup.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleClassRoomGroup(classRoomGroup.id)">
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
                newClassRoomGroup:{
                    classroom:null,
                    classgroup:null
                },
                updateMode:false,
                user:null,
                crmgroupid:null,
                classrooms:[],
                classgroups:[],
                roomGroups:[]

            }
    },

    methods: {
        checkInput(){
            if(this.newClassRoomGroup.classroom != null && this.newClassRoomGroup.classgroup != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getClassRooms(){
            axios.get('api/classRooms/'+this.user.branchid).then((result) => {
                this.classrooms = result.data
            }).catch((err) => {

            });
        },

        getClassGroups(){
            axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                this.classgroups = result.data
            }).catch((err) => {

            });
        },

        getClassRoomGroup(){
            axios.get('api/classRoomGroup/'+this.user.branchid).then((result) => {
                this.roomGroups = result.data
                  $(function() {
                 $('#all-roomgroups').DataTable({
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

        getSingleClassRoomGroup(id){
            axios.get('api/singleroomgroup/'+id).then((result) => {
                this.updateMode = true
                this.newClassRoomGroup.classroom =  result.data.classroomid
                this.newClassRoomGroup.classgroup = result.data.classgroupid
                this.crmgroupid = result.data.id
            }).catch((err) => {

            });
        },

        assignClassRoomGroup(){
            axios.post('api/classRoomGroup/store', this.newClassRoomGroup).then((result) => {
                EventBus.$emit('classRoomCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Class Room Group Assigned',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },

        updateRoomGroup(){
            axios.put('api/updateRoomGroup/'+this.crmgroupid , this.newClassRoomGroup).then((result) => {
                EventBus.$emit('classRoomCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Class Room Group updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteRoomGroup(id){
             axios.delete('api/deleteRoomGroup/'+id).then((result) => {
                EventBus.$emit('classRoomCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Room Group Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('classRoomCrud', () => {
            this.getClassRoomGroup()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getClassRooms()
            this.getClassGroups()
            this.getClassRoomGroup()
        }
        )

    },

}
</script>
