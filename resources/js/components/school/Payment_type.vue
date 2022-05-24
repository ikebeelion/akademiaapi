<template>

    <div>
        <nav-bar/>
            <div class="content-body">
                    <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Payment Types</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Payment Types</a></li>
                        </ol>
                    </div>
                </div>
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>

                                        <div class="form-group">
                                            <label for="">Payment Type</label>
                                            <input type="text" class="form-control" v-model="paymenttype.type">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success" @click="addPaymentType" v-if="!updateMode" :disabled="checkInput">Add</button>
                                            <button class="btn btn-success"  @click="updatePaymentType" v-if="updateMode" :disabled="checkInput">Update</button>
                                        </div>

                                        <div class="table-responsive mt-5">
                                            <table id="all-students" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
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
                checkInput:true,
                user:null,
                paymenttype:{
                    type:null,
                },
                types:null,
                typeid:null
            }
    },

    methods: {
        checkInput(){},
        getPaymentTypes(){
            axios.get('api/paymenttype/'+this.user.branchid).then((result) => {
                this.types = result.data
            }).catch((err) => {

            });
        },

        addPaymentType(){
            axios.post('api/paymenttype/store', this.paymenttype).then((result) => {
                 EventBus.$emit('typeCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Type Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            });
        },

        getSingleType(id){
            axios.get('api/singlepaymenttype/'+id).then((result) => {
              this.paymenttype = result.data.paymenttype
              this.typeid = result.data.id
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            });
        },

        deletePaymentType(){
            axios.delete('api/paymenttype/'+this.typeid).then((result) => {
                 EventBus.$emit('typeCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Type Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            });
        },

        updatePaymentType(){
            axios.put('api/paymenttype/'+this.typeid).then((result) => {
                 EventBus.$emit('typeCrud')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Type Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            });
        },
    },

    created() {
        EventBus.$on('typeCrud', () => {
            this.getPaymentTypes()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getPaymentTypes()
        }
        )
    },

}
</script>

<style scoped>
    #align{
        vertical-align: middle;
    }
    @media print{
    body *{
        visibility: hidden;
        }
    #result, #result * {
        visibility: visible
    }
    #result {
        position: absolute;
        left:0;
        top:0;
        right: 0;

    }
    }
</style>
