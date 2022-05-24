<template>
    <div>
        <nav-bar/>
            <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Class Rooms</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Class Rooms</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Class Rooms</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newClassRoom.classroom" @input="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=addClassRoom v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateRoom() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">All Class Rooms</h4>
                                        <p class="card-title-desc">Listed Below are all the registered class Rooms in this school
                                        </p>

                                        <table id="all-classrooms" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Class Room</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="classRoom in classRooms" :key="classRoom.id">
                                                <td>{{classRoom.classroom}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteRoom(classRoom.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleRoom(classRoom.id)">
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
                newClassRoom:{
                    classroom:null,
                },
                roomid:null,
                updateMode:false,
                classRooms:[],
                user:null,

            }
    },

    methods: {
        checkInput(){
            if(this.newClassRoom.classroom != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getClassRooms(){
            axios.get('api/classRooms/'+this.user.branchid).then((result) => {
                this.classRooms = result.data
                 $(function() {
                 $('#all-classrooms').DataTable({
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
        getSingleRoom(id){
            this.updateMode = true
            axios.get('api/singleroom/'+id).then((result) => {
                this.newClassRoom.classroom =  result.data.classroom
                this.roomid = result.data.id
            }).catch((err) => {

            });
        },

        addClassRoom(){
            var post = [this.newClassRoom, this.user.branchid]
            axios.post('api/classRooms/store', post).then((result) => {
                EventBus.$emit('classRoomCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Class Room Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },

        updateRoom(){
            axios.put('api/updateRoom/'+this.roomid , this.newClassRoom).then((result) => {
                EventBus.$emit('classRoomCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Class Room Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteRoom(id){
             axios.delete('api/deleteRoom/'+id).then((result) => {
                EventBus.$emit('classRoomCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Room Deleted',
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
            this.getClassRooms()
        })
        EventBus.$on('userData', user => {
                this.user = user
                this.getClassRooms()
            }
        )

    },

}
</script>
