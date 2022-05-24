<template>
    <div>
        <nav-bar/>
             <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>View Time Table</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Students</a></li>
                        </ol>
                    </div>
                </div>

                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                            <label for="">Academic Period</label>
                                            <select v-model="getTable.period" class="form-control">
                                                <option value="">select</option>
                                                <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                    {{ period.session.session }} - {{ period.term.term }}
                                                </option>
                                            </select>
                                        </div><br/>
                                         <div class="form-group">
                                        <label class="form-label">Time Table Type</label>
                                        <select  v-model="getTable.type" class="form-control" @change="emptyTable()">
                                            <option value="">select</option>
                                            <option  value="class_timetable">Class Timetable</option>
                                            <option value="exam_timetable">Exam Timetable</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success" @click="getTimeTable()">
                                            See timetable
                                        </button>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="this.timetable != null">
                                        <div class="col-12 mt-3">
                                        <h4 class="card-title" v-if="getTable.type == 'class_timetable' ">
                                            Class Time Table For {{ allrooms.classgroupname  }} {{ allrooms.classroom}}
                                        </h4>
                                        <h4 class="card-title" v-else>Exam Time Table</h4>
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Monday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'monday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'monday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <h4>Tuesday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'tuesday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'tuesday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <h4>Wednesday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'wednesday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'wednesday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <h4>Thursday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'thursday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'thursday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <h4>Friday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'friday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'friday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <h4>Saturday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'saturday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'saturday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <h4>Sunday</h4>
                                                <div >
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        <tr v-for="table in timetable" :key='table.id'>
                                                            <td v-if="table.day == 'sunday'">{{table.subjecttitle}}</td>
                                                            <td v-if="table.day == 'sunday'">{{table.from}} - {{table.to}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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
import FooterBar from '../Footer.vue'
import NavBar from '../NavBar.vue'
import { EventBus } from '../../app'
export default {
    components: {FooterBar, NavBar},
    data() {
        return {
                checkFilled:true,
                user:null,
                academicPeriods:null,
                getTable: {
                    type:null,
                    period:null,
                    classgroup:null,
                    classroom:null,
                },
                profile:null,
                allrooms:null,
                timetable:null,
                mytable:null
            }
    },

    methods: {
        getAcademicPeriod(){
            axios.get('api/period/'+this.user.branchid).then((result) => {
                this.academicPeriods = result.data
            }).catch((err) => {

            });
        },


        emptyTable(){
            this.timetable = null
        },
        getTimeTable(){
            if(this.getTable.type == 'exam_timetable'){
                axios.get('api/examtimetable/'+this.getTable.classgroup+'/'+this.getTable.period).then((result) => {
                    this.timetable = []
                    this.timetable = result.data
                }).catch((err) => {

                });
            }else{
                axios.get('api/classtimetable/'+this.getTable.classroom+'/'+this.getTable.period).then((result) => {
                    this.timetable = []
                    this.timetable = result.data
                }).catch((err) => {

                });
            }
        },

        getDays(monday, myArray){
            var day =  monday
           for(var i=0; i < myArray.length; i++){
               if(myArray[i]['day'] === day ){
                   console.log(myArray)
               }
           }
        },
        getProfile(){
            axios.get('api/get-profile/'+this.user.id).then((result) => {
                this.profile = result.data
                this.getTable.classgroup = result.data['yearid']
                this.getTable.classroom = result.data['classid']
                axios.get('api/singleroomgroup/'+this.profile.classid).then((result) => {
                this.allrooms = result.data
            }).catch((err) => {

            });
            }).catch((err) => {

            });
        },



    },

    created(){
        EventBus.$on('userData', user => {
            this.user = user
            this.getAcademicPeriod()
            this.getProfile()
            })
    }

}
</script>
