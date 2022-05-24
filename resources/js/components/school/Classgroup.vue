<template>
    <div>
        <nav-bar/>
               <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Class Groups</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">classgroups</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Class Groups</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newClassGroup.classgroupname" @input="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=addClassGroup v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateGroup() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">All Class Groups</h4>
                                        <p class="card-title-desc">Listed Below are all the registered class groups in this school
                                        </p>

                                        <table id="all-classgroups" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Class Group</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="classGroup in classgroups" :key="classGroup.id">
                                                <td>{{classGroup.classgroupname}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteGroup(classGroup.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleGroup(classGroup.id)">
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
                newClassGroup:{
                    classgroupname:null,
                },
                groupid:null,
                updateMode:false,
                classgroups:[],
                user:null,

            }
    },

    methods: {
        checkInput(){
            if(this.newClassGroup.classgroupname != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getClassGroups(){
            axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                this.classgroups = result.data
                $(function() {
                 $('#all-classgroups').DataTable({
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
        getSingleGroup(id){
            this.updateMode = true
            axios.get('api/singlegroup/'+id).then((result) => {
                this.newClassGroup.classgroupname =  result.data.classgroupname
                this.groupid = result.data.id
            }).catch((err) => {

            });
        },

        addClassGroup(){
            var post = [this.newClassGroup, this.user.branchid]
            axios.post('api/classGroups/store', post).then((result) => {
                EventBus.$emit('classGroupCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Class Group Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },

        updateGroup(){
            axios.put('api/updateGroup/'+this.groupid , this.newClassGroup).then((result) => {
                EventBus.$emit('classGroupCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Class Group Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteGroup(id){
             axios.delete('api/deleteGroup/'+id).then((result) => {
                EventBus.$emit('classGroupCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Group Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('classGroupCrud', () => {
            this.getClassGroups()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getClassGroups()
        }
        )

    },

}
</script>
