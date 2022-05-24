<template>
    <div>
        <nav-bar/>
              <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Result Types</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Result Types</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Type</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newType.type" @input="checkInput">
                                                <label class="form-label">Percentage</label>
                                                <input class="form-control" type="number" step="any" placeholder="..." v-model="newType.percentage" @input="checkInput">
                                            </div>

                                            <button class="btn btn-success mt-1 col-4" @click.prevent=addType v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateType() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">All Types</h4>
                                        <p class="card-title-desc">Listed Below are all the registered Types in this school
                                        </p>
                                        <div class="table-responsive">
                                            <table id="all-ranks" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>Result Type</th>
                                                    <th>Percentage</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="type in types" :key="type.id">
                                                    <td>{{type.resulttype}}</td>
                                                    <td>{{type.percentage}}</td>
                                                    <td>
                                                        <button class="btn btn-danger" @click="deleteType(type.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-info" @click="getSingleType(type.id)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
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
                newType:{
                    type:null,
                    percentage:null
                },
                updateMode:false,
                types:[],
                user:null,
                rankid:null

            }
    },

    methods: {
        checkInput(){
            if(this.newType.type != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getType(){
            axios.get('api/type/'+this.user.branchid).then((result) => {
                this.types = result.data
            $(function() {
                 $('#all-ranks').DataTable({
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
        getSingleType(id){
            this.updateMode = true
            axios.get('api/singletype/'+id).then((result) => {
                this.newType.type =  result.data.resulttype
                this.newType.percentage = result.data.percentage
                this.rankid = result.data.id
            }).catch((err) => {

            });
        },

        addType(){
            var post = [this.newType, this.user.branchid]
            axios.post('api/type/store', post).then((result) => {
                EventBus.$emit('typeCrud')
                this.newType.type = null
                this.newType.percentage = null
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Result type Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                  swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Result type not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        updateType(){
            axios.put('api/updateType/'+this.rankid , this.newType).then((result) => {

                EventBus.$emit('typeCrud')
                this.newType.type = null
                this.newType.percentage = null
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Result type Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                $('#all-types').DataTable().clear().destroy()


                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteType(id){
             axios.delete('api/deleteType/'+id).then((result) => {
                EventBus.$emit('typeCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Result type Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('typeCrud', () => {
            this.getType()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getType()
        }
        )

    },

}
</script>
