<template>
    <div>
        <nav-bar/>
                <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Branches</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Branches</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group row mb-2">
                                                <div class="col-6">
                                                    <label class="form-label">Branch Name</label>
                                                    <input class="form-control" @input="checkInput" type="text" placeholder="..." v-model="newBranch.branchname">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Branch Address</label>
                                                    <input class="form-control" @input="checkInput" type="text" placeholder="..." v-model="newBranch.branchaddress">
                                                </div>
                                            </div>

                                              <div class="row">
                                                <div class="mb-3 col-12">
                                                        <label class="form-label">Country <span class="text-danger">*</span></label>

                                                         <select
                                                         class="form-control"
                                                         v-model="newBranch.countryid"
                                                         @change="getState(newBranch.countryid)"
                                                         >
                                                            <option
                                                                v-for="country in countries"
                                                                :value="country.id"
                                                                :key="country.id"
                                                            > {{ country.country   }}</option>
                                                        </select>
                                                </div>
                                                      <div class="mb-3 col-6">
                                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                                        <select
                                                        class="form-control"
                                                        v-model="newBranch.stateid"
                                                        @change="getCity(newBranch.stateid)">
                                                        <option>Select</option>
                                                                <option
                                                                v-for="statee in states"
                                                                :value="statee.id"
                                                                :key="statee.id"
                                                                 >{{statee.state}}</option>
                                                        </select>

                                                    </div>
                                                       <div class="mb-3 col-6">
                                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                                            <select
                                                                class="form-control"
                                                                v-model="newBranch.cityid"
                                                                @change="checkInput">
                                                                    <option>Select</option>
                                                                    <option
                                                                    v-for="city in cities" :key="city.id"
                                                                    :value="city.id">{{ city.city }}</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                            <div class="form-group mb-2">
                                                <label class="form-label">Branch Contact Tel</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newBranch.branchtel" @input="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=addBranch v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateBranch() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">All Branches</h4>
                                        <p class="card-title-desc">Listed Below are all the registered branches in this school
                                        </p>

                                        <table id="all-branches" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Branch Name</th>
                                                <th>Branch Address</th>
                                                <!-- <th>Country</th>
                                                <th>State</th>
                                                <th>City</th> -->
                                                <th>Contact Tel.</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="branch in allbranches" :key="branch.id">
                                                <td>{{branch.branchname}}</td>
                                                <td>{{branch.branchaddress}}</td>
                                                <!-- <td>{{branch.country.country}}</td>
                                                <td>{{branch.state.state}}</td>
                                                <td>{{branch.city.city}}</td> -->
                                                <td>{{branch.branchtel}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteBranch(branch.id)" :disabled="user.branchid == branch.id">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleBranch(branch.id)">
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
                newBranch:{
                    branchname:null,
                    branchaddress:null,
                    countryid:null,
                    stateid:null,
                    cityid:null,
                    branchtel:null
                },
                updateMode:false,
                countries:null,
                states:null,
                cities:null,
                branchid:null,
                schoolid:null,
                allbranches:[],
                user:null
            }
    },

    methods: {
        checkInput(){
            if(this.newBranch.branchname != null && this.newBranch.branchaddress != null && this.newBranch.countryid != null && this.newBranch.stateid != null && this.newBranch.cityid != null && this.newBranch.branchtel != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },
getCountry(){
            axios.get('api/country/').then((result) => {
                this.countries = result.data
            }).catch((err) => {

            });
        },
        getState(countryid){
            axios.get('api/state/'+countryid).then((result) => {
                this.states = result.data
            }).catch((err) => {

            });
        },
        getCity(stateid){
             axios.get('api/city/'+stateid).then((result) => {
                this.cities = result.data
            }).catch((err) => {

            });
        },

        getBranches(){
                axios.get('api/branch/'+this.schoolid).then((result) => {
                    this.allbranches = result.data
                       $(function() {
                 $('#all-branches').DataTable({
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
        addBranch(){
            console.log(this.schoolid)
            var post = [this.newBranch, this.schoolid]
            axios.post('api/branch/store', post).then((result) => {
                EventBus.$emit('branchCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Branch Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },
        getSingleBranch(id){
            // get Branch details
            axios.get('api/singlebranch/'+id).then((result) => {
                    this.updateMode = true
                    this.newBranch.branchname = result.data.branchname
                    this.newBranch.branchaddress = result.data.branchaddress
                    this.newBranch.countryid = result.data.countryid
                    this.newBranch.stateid = result.data.stateid
                    this.newBranch.cityid = result.data.cityid
                    this.newBranch.branchtel = result.data.branchtel
                    this.branchid = result.data.id
                    this.getState(this.newBranch.countryid)
                    this.getCity(this.newBranch.stateid)
            }).catch((err) => {

            });
        },

        updateBranch(){
            axios.put('api/updateBranch/'+this.branchid , this.newBranch).then((result) => {
                EventBus.$emit('branchCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Branch Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteBranch(id){
             axios.delete('api/deleteBranch/'+id).then((result) => {
                EventBus.$emit('branchCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Branch Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        this.getCountry()
        EventBus.$on('branchCrud', () => {
            this.getBranches()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.schoolid = user.branch.schoolid
            this.getBranches()
        }
        )

    },

}
</script>
