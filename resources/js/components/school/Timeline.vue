<template>
    <div>
        <nav-bar/>
                <div class="content-body">
                <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Academic Timeline</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Academic Timeline</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row ">
                            <div class="col-12">
                                <div class="row" id="card">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Academic Year</label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newYear.year" @input="checkInput">
                                            </div>

                                            <center>
                                                <button class="btn btn-success text-light mt-1 col-6" @click.prevent=addYear :disabled="this.checkFilled == true && this.newYear.year == null || this.newYear.year == ''">Add</button>
                                            </center>

                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="card">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">
                                                <center> Term </center></label>
                                                <input class="form-control" type="text" placeholder="..." v-model="newTerm.term" @input="checkInput">
                                            </div>

                                            <center>
                                                <button class="btn btn-success text-light mt-1 col-6" @click.prevent=addTerm :disabled="this.checkFilled == true && this.newTerm.term == null || this.newTerm.term == ''">Add</button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="card">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="form-group mb-2 mt-5">
                                                <label class="form-label">Academic Session</label>
                                                <input class="form-control" type="text" placeholder="yyyy/yyyy" v-model="newSession.session" @input="checkInput"><br/>
                                                <label class="form-label">Start Date</label>
                                                <input class="form-control" type="date" placeholder="..." v-model="newSession.startdate" @input="checkInput">
                                                <label class="form-label">End Date</label>
                                                <input class="form-control" type="date" placeholder="..." v-model="newSession.enddate" @input="checkInput">
                                            </div>

                                            <button class="btn btn-success text-light mt-1 col-12" @click.prevent=addSession :disabled="this.checkFilled == true && this.newSession.session == null || this.newSession.session == ''">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row" id="card">
                                    <div class="col-lg-12">
                                        <div>
                                            <h3>Academic Period</h3>
                                            <div class="form-group">
                                                <label class="form-label">Academic Year</label>
                                                <select v-model="academicPeriod.yearid" class="form-control" @change="checkInput">
                                                <option value="">select</option>
                                                    <option v-for="year in years" :key="year.id" :value="year.id">
                                                        {{ year.year }}
                                                    </option>
                                                </select>
                                                <label class="form-label">Term</label>
                                                <select v-model="academicPeriod.termid" class="form-control" @change="checkInput">
                                                    <option value="">select</option>
                                                    <option v-for="term in terms" :key="term.id" :value="term.id">
                                                        {{ term.term }}
                                                    </option>
                                                </select>
                                                <label class="form-label">Session</label>
                                                <select v-model="academicPeriod.sessionid" class="form-control" @change="checkInput">
                                                    <option value="">select</option>
                                                    <option v-for="session in sessions" :key="session.id" :value="session.id">
                                                        {{ session.session }}
                                                    </option>
                                                </select>
                                                <label class="form-label">Next Resumption Date</label>
                                                <input type="date" v-model="academicPeriod.next_resumption" class="form-control" @change="checkInput">                                                    
                                            </div>

                                            <button class="btn btn-success text-light mt-1 col-12" @click.prevent=addAcademicPeriod :disabled="this.checkFilled == true && this.newYear.year == null || this.newYear.year == ''">Add</button>

                                        </div>
                                    </div>
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
export default {
    components: {NavBar},
    data() {
        return {
                checkFilled:true,
                newYear:{
                    year:null,
                },
                newSession:{
                    session:null,
                    startdate:null,
                    enddate:null

                },
                newTerm: {
                    term:null
                },
                updateMode:false,
                ranks:[],
                user:null,
                rankid:null,
                sessions:null,
                terms:null,
                years:null,
                academicPeriod:{
                    sessionid:null,
                    termid:null,
                    yearid:null,
                    next_resumption:null
                }
            }
    },

    methods: {
        checkInput(){
            if(this.newYear.year != null){
                this.checkFilled = false
            }else if(this.newSession.session != null && this.newSession.startdate != null && this.newSession.enddate){
                this.checkFilled = false
            }else if(this.newTerm.term != null ){
                this.checkFilled = false
            }else if(this.academicPeriod.sessionid != null && this.academicPeriod.termid != null && this.academicPeriod.yearid != null && this.academicPeriod.next_resumption != null){
                this.checkFilled = false
            }else {
                this.checkFilled = true
            }
        },

        addYear(){
            var post = [this.newYear, this.user]
            axios.post('api/year/store', post).then((result) => {
                EventBus.$emit('timelineCrud')
                this.newYear.year = null
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Academic year added',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 3000
                    })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Academic year not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        addTerm(){
            var post = [this.newTerm, this.user]
             axios.post('api/term/store', post).then((result) => {
                EventBus.$emit('timelineCrud')
                this.newTerm.term = null
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Term added',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 3000
                    })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Term not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        addSession(){
            var post = [this.newSession, this.user]
             axios.post('api/session/store', post).then((result) => {
                EventBus.$emit('timelineCrud')
                this.newSession.session = null
                this.newSession.startdate = null
                this.newSession.enddate = null
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Academic session added',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 3000
                    })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Academic session not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        getSessions(){
            axios.get('api/academicSessions/'+this.user.branchid).then((result) => {
                this.sessions = result.data
            }).catch((err) => {

            });
        },

        getTerm(){
            axios.get('api/terms/'+this.user.branchid).then((result) => {
                this.terms = result.data
            }).catch((err) => {

            });
        },

        getYears(){
            axios.get('api/academicYears/'+this.user.branchid).then((result) => {
                this.years = result.data
            }).catch((err) => {

            });
        },

        addAcademicPeriod(){
            axios.post('api/addAcademicPeriod', this.academicPeriod).then((result) => {
                swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Academic period added',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 3000
                    })
                     this.academicPeriod.sessionid = null
                    this.academicPeriod.termid = null
                    this.academicPeriod.yearid = null
            }).catch((err) => {
                swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Academic period not added',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 3000
                    })
            });
        }

    },

    created() {
        EventBus.$on('timelineCrud', () => {
            this.getSessions()
            this.getTerm()
            this.getYears()
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.getSessions()
            this.getTerm()
            this.getYears()
        }
        )

    },

}
</script>

<style scoped>
#card {
    border: 1px solid #fbe5dc;
    border-radius: 20px;
    margin-bottom: 10px;
    padding: 6px 0 6px 0;
    outline: none;
}
</style>