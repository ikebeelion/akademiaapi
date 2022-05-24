<template>
    <div>
        <nav-bar/>
            <div class="content-body">
			    <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Timetable Approval Requests</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Approve Timetable</a></li>
                        </ol>
                    </div>
                </div>
                    <div class="row">
                            <div class="col-12">
                                <div class="row">
                                <table class="table table-bordered" id="all-request">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Class Group</th>
                                            <th>Day</th>
                                            <th>Academic Period</th>
                                            <th>Status</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="data in table" :key="data.id">
                                            <td>{{ data.subjecttitle }}</td>
                                            <td v-if="data.timetabletype == 'class_timetable'">{{ data.classgroupname}} - {{ data.classroom}}</td>
                                            <td v-else>{{ data.classgroupname }} </td>
                                            <td>{{ data.day }}</td>
                                            <td>{{ data.session}} {{ data.term }}</td>
                                            <td v-if="data.t_status == 'not_approved'">
                                                <center>
                                                    <i class="text-warning fa fa-times"></i>
                                                </center>
                                            </td>
                                            <td>{{ data.from }}</td>
                                            <td>{{ data.to }}</td>
                                            <td>
                                                 <button class="btn btn-info" @click="approve(data.tid)" v-if="data.t_status == 'not_approved'">
                                                    <i class="fas fa-check" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-warning" @click="disapprove(data.tid)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <button class="btn btn-danger" @click="deleteTimetable(data.tid)">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
         </div>
</template>

<script>
import NavBar from '../NavBar.vue'
import { EventBus } from '../../app'
import axios from 'axios'
export default {
    components: {NavBar},
    data() {
        return {
                checkFilled:true,
                branchid:null,
                updateMode:false,
                user:null,
                subjects:null,
                classrooms:null,
                classgroups:null,
                subjects:null,
                academicPeriods:null,
                table:null,
            }
    },

    methods: {
        getTable(){
            axios.get('api/gettable/'+this.user.branchid).then((result) => {
                this.table = result.data
                     $(function() {
                 $('#all-request').DataTable({
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

        approve(id){
            axios.put('api/approvetable/'+id).then((result) => {
                EventBus.$emit('tableapprove')
            }).catch((err) => {

            });
        },

        disapprovetable(id){
            axios.put('api/disapprovetable/'+id).then((result) => {}).catch((err) => {});
        },

        deleteTimetable(id){
            axios.delete('api/deletetable/'+id).then((result) => {
                EventBus.$emit('tableapprove')
            }).catch((err) => {

            });
        }


    },

    created() {
        EventBus.$on('userData', user => {
            this.user = user
            this.getTable()
        })
        EventBus.$on('tableapprove', () => {
            this.getTable()
        })
    },

}
</script>

