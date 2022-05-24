<template>
    <div>
        <nav-bar/>
            <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Send Messages</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Communication</a></li>
                        </ol>
                    </div>
                </div>
                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label"> Category </label>
                                                <select name="" id="" v-model="message.category" class="form-control" @change="getGroup">
                                                    <option value=""> -- </option>
                                                    <option value="1"> Parents </option>
                                                    <option value="2"> Students </option>
                                                    <option value="3"> Staff </option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-2" v-show="this.classgroups != null" >
                                                <label class="form-label"> Class Group </label>
                                                <select name="" id="" v-model="message.group" class="form-control">
                                                    <option  :value="0"> All Students </option>
                                                    <option  v-for="group in classgroups" :value="group.id" :key="group.id"> {{ group.classgroupname}} </option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-2" v-show="this.wardgroups != null" >
                                                <label class="form-label"> Ward Group </label>
                                                <select name="" id="" v-model="message.wardgroup" class="form-control">
                                                    <option  :value="0"> All </option>
                                                    <option  v-for="group in wardgroups" :value="group.id" :key="group.id"> {{ group.classgroupname}} </option>
                                                </select>
                                            </div>
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
                                        <h4 class="card-title">Message</h4>
                                        <textarea class="form-control" v-model="message.content" id="" cols="30" rows="10"></textarea>
                                        <button class="btn btn-success mt-3" @click.prevent="sendSms">Send SMS</button>
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
                message:{
                    category:null,
                    content:null,
                    group:null,
                    wardgroup:null
                },
                updateMode:false,
                ranks:[],
                user:null,
                rankid:null,
                classgroups:null,
                wardgroups:null


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

        getGroup(){
            // get group student group
            if(this.message.category == 2){
                axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                    this.classgroups = result.data
                    this.wardgroups = null
                }).catch((err) => {
                });
            }else if(this.message.category == 1){
                axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                    this.wardgroups = result.data
                    this.classgroups = null
                }).catch((err) => {
                });                
            }else{
                this.classgroups = null
            }
        },

        sendSms(){
            axios.post('api/sms/'+this.user.branchid, this.message).then((result) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Messages Sent',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Messages not Sent',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
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
