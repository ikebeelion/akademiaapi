<template>
    <div>
        <nav-bar/>
            <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Ranks</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Ranks</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Rank</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newRank.rank" @input="checkInput">
                                            </div>

                                            <button class="btn btn-success mt-1 col-4" @click.prevent=addRank v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateRank() v-if="updateMode">Update</button>
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
                                        <h4 class="card-title">All Ranks</h4>
                                        <p class="card-title-desc">Listed Below are all the registered ranks in this school
                                        </p>
                                        <div class="table-responsive">
                                            <table id="all-ranks" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="rank in ranks" :key="rank.id">
                                                    <td>{{rank.rank}}</td>
                                                    <td>
                                                        <button class="btn btn-danger" @click="deleteRank(rank.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-info" @click="getSingleRank(rank.id)">
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
    components: { NavBar},
    data() {
        return {
                checkFilled:true,
                newRank:{
                    rank:null,
                },
                updateMode:false,
                ranks:[],
                user:null,
                rankid:null

            }
    },

    methods: {
        checkInput(){
            if(this.newRank.rank != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getRanks(){
            axios.get('api/ranks/'+this.user.branchid).then((result) => {
                this.ranks = result.data
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
        getSingleRank(id){
            this.updateMode = true
            axios.get('api/singlerank/'+id).then((result) => {
                this.newRank.rank =  result.data.rank
                this.rankid = result.data.id
            }).catch((err) => {

            });
        },

        addRank(){
            var post = [this.newRank, this.user.branchid]
            axios.post('api/rank/store', post).then((result) => {
                EventBus.$emit('rankCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Rank Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                  swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Rank not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        updateRank(){
            axios.put('api/updateRank/'+this.rankid , this.newRank).then((result) => {
                EventBus.$emit('rankCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Rank Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteRank(id){
             axios.delete('api/deleteRank/'+id).then((result) => {
                EventBus.$emit('rankCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Rank Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('rankCrud', () => {
            this.getRanks()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getRanks()
        }
        )

    },

}
</script>
