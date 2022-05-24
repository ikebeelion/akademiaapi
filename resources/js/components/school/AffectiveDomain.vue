<template>
    <div>
        <nav-bar/>
              <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Affective Domain</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Affecive Domain</a></li>
                        </ol>
                    </div>
                </div>
                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Affective Domain</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="affective_domain.affective_domain" @input="checkInput">
                                            </div>

                                                <button class="btn btn-success mt-1 col-4" @click.prevent=addDomain v-if="!updateMode" :disabled="this.checkFilled == true">Add</button>
                                                <button class="btn btn-success mt-1 col-4" @click.prevent=updateDomain() v-if="updateMode">Update</button>
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

                                        <h4 class="card-title">All Affective Domain</h4>
                                        <p class="card-title-desc">Listed Below are all the registered affective domain in this school
                                        </p>

                                        <table id="all-affective_domains" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Class Room</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="domain in affective_domains" :key="domain.id">
                                                <td>{{domain.affective_domain}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteDomain(domain.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click="getSingleDomain(domain.id)">
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
                affective_domain:{
                    affective_domain:null,
                },
                psychid:null,
                updateMode:false,
                affective_domains:[],
                user:null,

            }
    },

    methods: {
        checkInput(){
            if(this.affective_domain.affective_domain != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },

        getDomains(){


            axios.get('api/domains/'+this.user.branchid).then((result) => {
                this.affective_domains = result.data
                 $(function() {
                 $('#all-affective_domains').DataTable({
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
        getSingleDomain(id){
            this.updateMode = true
            axios.get('api/singledomain/'+id).then((result) => {
                this.affective_domain.affective_domain =  result.data.affective_domain
                this.psychid = result.data.id
            }).catch((err) => {

            });
        },

        addDomain(){
            var post = [this.affective_domain, this.user.branchid]
            axios.post('api/domains/store', post).then((result) => {
                EventBus.$emit('domainCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Affective Domain Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        },

        updateDomain(){
            axios.put('api/updatedomain/'+this.psychid , this.affective_domain).then((result) => {
                EventBus.$emit('domainCrud')
                swal.fire({
                position: 'top-end',
                    icon: 'success',
                    title: 'Affective Domain Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
            }).catch((err) => {

            });
        },

        deleteDomain(id){
             axios.delete('api/deletedomain/'+id).then((result) => {
                EventBus.$emit('domainCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Domain Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });

        }
    },

    created() {
        EventBus.$on('domainCrud', () => {
            this.getDomains()
        })
        EventBus.$on('userData', user => {
                this.user = user
                this.getDomains()
            }
        )

    },

}
</script>
