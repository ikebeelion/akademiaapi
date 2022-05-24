<template>
    <div>
        <nav-bar/>
              <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Psychomotor</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Psychomotor</a></li>
                        </ol>
                    </div>
                </div>
                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Psychomotor</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="psychomotor.psych" @input="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=addPsychomotor v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updatePsych() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">All Psychomotor</h4>
                                        <p class="card-title-desc">Listed Below are all the registered Psychomotor in this school
                                        </p>

                                        <table id="all-Psychomotors" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Class Room</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="psych in psychomotors" :key="psych.id">
                                                <td>{{psych.psychomotor}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deletePsych(psych.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSinglePsych(psych.id)">
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
                psychomotor:{
                    psych:null,
                },
                psychid:null,
                updateMode:false,
                psychomotors:[],
                user:null,

            }
    },

    methods: {
        checkInput(){
            if(this.psychomotor.psych != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getPsychomotors(){

            axios.get('api/psychomotors/'+this.user.branchid).then((result) => {
                this.psychomotors = result.data
                 $(function() {
                 $('#all-Psychomotors').DataTable({
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
        getSinglePsych(id){
            this.updateMode = true
            axios.get('api/singlepsych/'+id).then((result) => {
                this.psychomotor.psych =  result.data.psychomotor
                this.psychid = result.data.id
            }).catch((err) => {

            });
        },

        addPsychomotor(){
            var post = [this.psychomotor, this.user.branchid]
            axios.post('api/psychomotors/store', post).then((result) => {
                EventBus.$emit('psychCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Psychomotor Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },

        updatePsych(){
            axios.put('api/updatepsych/'+this.psychid , this.psychomotor).then((result) => {
                EventBus.$emit('psychCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Psychomotor Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deletePsych(id){
             axios.delete('api/deletepsych/'+id).then((result) => {
                EventBus.$emit('psychCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Psychomotor Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('psychCrud', () => {
            this.getPsychomotors()
        })
        EventBus.$on('userData', user => {
                this.user = user
                this.getPsychomotors()
            }
        )

    },

}
</script>
