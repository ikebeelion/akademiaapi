<template>
    <div>
        <div class="nav-header">
            <a href="#" class="brand-logo">
                <img class="logo-abbr" width="50" height="50" src="images/favicon.ico" alt="">
                <p class="brand-title mt-3 text-orange" width="74" height="32"> Akademia </p>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

       <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
							<div class="input-group search-area right d-lg-inline-flex d-none">
								<input type="text" class="form-control" placeholder="Find something here...">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="javascript:void(0)">
											<i class="flaticon-381-search-2"></i>
										</a>
									</span>
								</div>
							</div>
                        </div>
                        <ul class="navbar-nav header-right main-notification">
							<!-- <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-theme-mode" href="#">
									<i id="icon-light" class="fa fa-sun-o"></i>
                                    <i id="icon-dark" class="fa fa-moon-o"></i>
                                </a>
							</li> -->
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-fullscreen" href="#">
                                    <svg id="icon-full" viewbox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                                    <svg id="icon-minimize" width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                                </a>
							</li>

							<li class="nav-item dropdown ">
                                <a class="nav-link text-danger  ai-icon" href="javascript:void(0)" @click="logout">
                                    <i class="fas fa-power-off" aria-hidden="true"></i>
                                </a>
							</li>

                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="flaticon-381-user"></i>
									<div class="header-info">
										<span>{{ this.user.username }}</span>
										<small v-if="this.user.roleid == 1">Super Admin</small>
                                        <small v-if="this.user.roleid == 2">Admin</small>
                                        <small v-if="this.user.roleid == 3">Staff</small>
                                        <small v-if="this.user.roleid == 4">Student</small>
                                        <small v-if="this.user.roleid == 5">Parent</small>
									</div>
                                </a>

                            </li>
                        </ul>
                    </div>
                </nav>
				<div class="sub-header">
					<div class="d-flex align-items-center flex-wrap mr-auto">
						<h5 class="dashboard_bar"></h5>
					</div>
					<div class="d-flex align-items-center">
						<a href="javascript:void(0);" class="btn btn-xs btn-primary light mr-1">{{ this.day }}</a>
						<a href="javascript:void(0);" class="btn btn-xs btn-primary light mr-1">{{ this.month }}</a>
						<a href="javascript:void(0);" class="btn btn-xs btn-primary light">{{this.year}}</a>
					</div>
				</div>
			</div>
        </div>

        <div class="deznav">
            <div class="deznav-scroll">
				<div class="main-profile">
					<div class="image-bx">
						<img :src="'images/school/'+this.schoollogo" alt="">
						<a href="javascript:void(0);"></a>
					</div>
					<h5 class="name text-light">{{ this.schoolname }}</h5>
					<p class="email">{{this.user.branch.branchname}}</p>
				</div>
			<ul class="metismenu" id="menu">
					<li class="nav-label first" v-if="role==1 || role==2">Admin Menu</li>
                    <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false" v-if="role==1 || role==2">
							<i class="flaticon-381-user-4 "></i>
							<span class="nav-text">Admin</span>
						</a>
                        <ul aria-expanded="false" v-if="role==1 || role==2">
							<li><a href="/profile">School Profile</a></li>
							<li><a href="/branches">Branches</a></li>
							<li><a href="/subjects">Subjects</a></li>
							<li><a href="/subjectgroup">Subject Group</a></li>
							<li><a href="/classgroups">Class Groups</a></li>
							<li><a href="/classroom">Class Room</a></li>
							<li><a href="/classroomgroup">Classroom Groups</a></li>
                            <li><a href="/psychomotor">Psychomotor</a></li>
                            <li><a href="/affectivedomain">Affective Domain</a></li>
                            <li><a href="/studentprofile">Student Profile</a></li>
                            <li><a href="/staff">Staff Profile</a></li>
                            <li><a href="/parentprofile">Parent Profile</a></li>
                            <li><a href="/timetable">Time Table</a></li>
                            <li><a href="#">Calendar</a></li>
                            <li><a href="#">Assign Priviledges</a></li>
                            <li><a href="#">Feedback</a></li>
                            <li><a href="/rank">Rank</a></li>
                            <li><a href="/timeline">Academic Timeline</a></li>
                            <li><a href="/result-type">Result Type</a></li>
						</ul>

                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false" v-if="role==1 || role==2">
							<i class="flaticon-381-list-1"></i>
							<span class="nav-text">Accounting</span>
					    </a>
                        <ul aria-expanded="false" v-if="role==1 || role==2">
                            <li><a href="/payment-type">Payment Type</a></li>
                            <li><a href="/payments">Manage Student Payments</a></li>
                            <li><a href="/exptype">Expenditure Type</a></li>
                            <li><a href="/expenditure">Manage Expenditures</a></li>
                            <li><a href="/store">Store</a></li>
                        </ul>
                    </li>
                      <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false" v-if="role==1 || role==2">
							<i class="flaticon-381-infinity"></i>
							<span class="nav-text">Communication</span>
						</a>
                        <ul aria-expanded="false" v-if="role==1 || role==2">
                            <li><a href="/sendmessages">Send Messages</a></li>
                        </ul>
                      </li>


					<li class="nav-label" v-if="role==1 || role==3">Staff Menu</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" v-if="role==1 || role==3" aria-expanded="false">
						<i class="flaticon-381-user"></i>
							<span class="nav-text">Tutor/Class Teacher</span>
						</a>
                        <ul aria-expanded="false" v-if="role==1 || role==3">
                            <li><a href="/curricula">Curricula</a></li>
							<li><a href="/attendance">Class Attendance</a></li>
                            <!-- <li><a href="/attendance">School Attendance</a></li> -->
							<li><a href="/assignment">Assignment</a></li>
                            <li><a href="/classroom-mgt">Manage Class Room</a></li>
                            <li><a href="/result">Result</a></li>
                        </ul>
                    </li>

					<li class="nav-label" v-if="role==1 || role==4">Student Menu</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false" v-if="role==1 || role==4">
							<i class="flaticon-381-user-4 "></i>
							<span class="nav-text">Student</span>
						</a>
                        <ul aria-expanded="false" v-if="role==1 || role==4">
                            <li><a href="/viewtable">View Time Table</a></li>
                            <li><a href="/myresult">View My Result</a></li>
                        </ul>
                    </li>

                    <li class="nav-label" v-if="role==1 || role==5">Parent Menu</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false" v-if="role==1 || role==5">
							<i class="flaticon-381-user-4 "></i>
							<span class="nav-text">Parent</span>
						</a>
                        <ul aria-expanded="false" v-if="role==1 || role==5">
                            <li><a href="/wardresult">View Ward Result</a></li>
                        </ul>
                        <ul aria-expanded="false" v-if="role==1 || role==5">
                            <li><a href="/wardtimetable">View Ward Timetable</a></li>
                        </ul>
                    </li>



                </ul>
				<div class="copyright">
					<p><strong>A Product of Next-it Services</strong> © 2022 All Rights Reserved</p>
					<p class="fs-12">Made with <span class="heart"></span> by Next-it Services</p>
				</div>
			</div>
        </div>
    </div>

</template>
<script>
import { EventBus } from '../app';
import axios from 'axios'
export default {
    data() {
        return {
            user:null,
            priviledges:null,
            schoolProfile:null,
            userprofile:null,
            username:null,
            schoollogo:null,
            schoolname:null,
            alias:null,
            role:null,
            date:null,
            day:null,
            month:null,
            year:null
        }
    },

    methods: {
        getuserdata(){
            axios.get('api/user').then((result) => {
                this.user = result.data
                this.role = result.data['roleid']
                this.username = result.data.username

                    axios.get('api/index/'+this.user.branch.schoolid).then((result) => {
                            this.schoollogo = result.data['schoollogo']
                            this.schoolname = result.data['schoolname']
                            this.alias = result.data['alias']
                        }).catch((err) => {

                        });

                EventBus.$emit('userData', this.user)
            }).catch((err) => {
            });
        },
        getCurrentDate(){
            let today = new Date()
            let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
            let month = months[today.getMonth()]
            let year = today.getFullYear()
            let date = today.getDate()
            let current_date = month+'/'+date+'/'+year
            this.day = date
            this.year = year
            this.month = month
            this.date = current_date
        },
        // getAuth(){
        //     axios.get('api/authenticated').then(()=>{

        //     }).catch(()=>{
        //         window.location.href = '/'
        //     })
        // },
        logout(){
            axios.post('api/logout').then((result) => {
                window.location.href = '/'
                // this.$router.push({name: 'login'})
            }).catch((err) => {

            });
        },
    },

    created() {
        // this.getAuth()
        this.getuserdata()
        this.getCurrentDate()
    },
}
</script>
<style scoped>
    #animation {
        transition-property: width;
        transition-duration: 2s;
        transition-timing-function: linear;
        transition-delay: 1s;
    }
</style>
