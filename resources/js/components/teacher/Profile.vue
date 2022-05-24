<template>
    <div>
        <nav-bar/>
              <div class="content-body">
                    <div class="container-fluid">

                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Teacher/Staff Profile</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Profile</a></li>
                        </ol>
                    </div>
                </div>

                        <div class="row mb-5">
                            <div class="col-xl-12">
                                <div class="row" >
                                    <div class="col-lg-8">
                                        <div>
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">New Staff Data</a>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">staff Data</a> -->
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Upload Photo</a> -->
                                            </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                <div v-if="step==1" >
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Title</label>
                                                                <select v-model="newStaff.title" id="" class="form-control" @input="checkInput">
                                                                    <option value="mr">Mr.</option>
                                                                    <option value="miss">Miss</option>
                                                                    <option value="mrs">Mrs.</option>
                                                                    <option value="dr">Dr.</option>
                                                                    <option value="engr">Engr.</option>
                                                                    <option value="prof">Prof</option>
                                                                </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Date of Appointment</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.appointment_date" type="date" placeholder="...">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Firstname</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.firstname" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Lastname</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.lastname" type="text" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Othername(s)</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.othernames" type="text" placeholder="...">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Staff Type</label>
                                                                <select v-model="newStaff.staff_type" class="form-control" @change="checkInput">
                                                                    <option value="teaching">Teaching Staff</option>
                                                                    <option value="non-teaching"> Non Teaching Staff</option>
                                                                </select>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Rank</label>
                                                                <select v-model="newStaff.rankid" class="form-control" @change="checkInput">
                                                                    <option value="">select</option>
                                                                    <option v-for="rank in ranks" :value="rank.id" :key="rank.id">{{rank.rank}}</option>
                                                                </select>
                                                        </div>


                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Date of Birth</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.dob" type="date" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Gender</label>
                                                            <select class="form-control" v-model="newStaff.genderid" @change="checkInput">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                    <label class="form-label">Religion</label>
                                                            <select class="form-control" v-model="newStaff.religion" @change="checkInput">
                                                                    <option value="christian">Christian</option>
                                                                    <option value="islam">Islam</option>
                                                            </select>
                                                        </div>

                                                </div>
                                                </div>
                                                 <div v-if="step==2" >
                                                    <div class="row">
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                                         <select
                                                            class="form-control"
                                                            v-model="newStaff.nationalityid"
                                                            @change="getStateofO(newStaff.nationalityid)"

                                                         ><option v-for="country in countries"  :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="form-label">State of Origin <span class="text-danger">*</span></label>
                                                        <select
                                                        class="form-control"
                                                        v-model="newStaff.stateoforiginid"
                                                        @change="checkInput"
                                                        ><option v-for="statee in stateofo" :value="statee.id" :key="statee.id" >{{statee.state}}</option>
                                                        </select>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">L.G.A</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.local_govt_area" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Address</label>
                                                                <textarea class="form-control" @input="checkInput" v-model="newStaff.address" cols="6" rows="2" placeholder="..."></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">Country </label>
                                                         <select
                                                         class="form-control"
                                                         v-model="newStaff.countryid"
                                                         @change="getState(newStaff.countryid)"
                                                         ><option  v-for="country in countries" :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">State</label>
                                                        <select
                                                        class="form-control"
                                                        v-model="newStaff.stateid"
                                                        @change="getCity(newStaff.stateid)">
                                                                <option>Select</option>
                                                                <option v-for="statee in states" :value="statee.id" :key="statee.id">{{statee.state}}</option>
                                                        </select>

                                                    </div>
                                                       <div class="col-lg-4 mt-2">
                                                            <label class="form-label">City</label>
                                                            <select
                                                                class="form-control"
                                                                v-model="newStaff.cityid"
                                                                @change="checkInput">
                                                                    <option v-for="city in cities" :value="city.id" :key="city.id" >{{ city.city }}</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div v-if="step==3" >
                                                    <div class="row">
                                                         <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Email Address</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.contactemail" type="email" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Telephone</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStaff.contacttel" type="text" placeholder="...">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div v-if="step==4" >
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">staff Image</label>

                                                                <!-- <img :src='this.image' height="100px" width="120px"  alt=""> -->
                                                                <input class="form-control" @change="pickFile" type="file" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-warning ml-3 mt-2" @click.prevent="prevStep" v-if="this.step > 1">Previous</button>
                                                <button class="btn btn-primary ml-3 mt-2" @click.prevent="nextStep" v-if="this.step != this.totalsteps && this.checkFilled == false">Next</button>
                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="addStaff" v-if="this.step == this.totalsteps && this.updateMode == false">Add New staff</button>

                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="updateStaff" v-if="this.step == this.totalsteps && this.checkFilled == false && this.updateMode == true">Update staff</button>

                                            </div>
                                            <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2.</div> -->
                                            <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">44  </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4" v-if="updateMode==true">
                                        <div>
                                           <h5 class="ml-5">staff Details</h5>
                                           <img :src="'images/staff/'+this.newStaff.photo" alt="staff photo" class="img-thumbnail">
                                        </div>
                                        <h5>Subject(s) Taught</h5>
                                        <!-- <div v-for="subject in subjectstaught" :key=subject.id> -->
                                            <div v-show="subjectstaught != ''" v-for="sub in subjectstaught" :key=sub.id>
                                                <a href="#"> {{sub.subjecttitle}} - {{sub.classgroupname}}</a>
                                                <small>
                                                    <a href="#" class="text-danger" @click="deleteTutorSubject(sub.id)">Delete</a>
                                                </small>
                                            </div>
                                            <div v-show="subjectstaught == ''">
                                                <p class="lead">Not Handling any Subject</p>
                                            </div>
                                        <!-- </div> -->
                                        <br/>

                                        <h5>Priviledges</h5>
                                        <div v-for="ward in wards" :key=ward.id>
                                            <div v-for="student in ward" :key=student.id>
                                                <a href="#" @click.prevent="getSingleStudent(student.id)">{{student.firstname}} {{student.lastname}}</a>
                                            </div>
                                        </div>

                                        <h5>Class Room Managed</h5>
                                         <div v-show="classroomsmgd != ''" v-for="sub in classroomsmgd" :key=sub.id>
                                                <a href="#"> {{sub.classgroupname}} - {{sub.classroom}}</a>
                                                <small>
                                                    <a href="#" class="text-danger" @click="deleteclassroomteacher(sub.id)">Delete</a>
                                                </small>
                                            </div>
                                            <div v-show="classroomsmgd == ''">
                                                <p class="lead">Not Managing any Class</p>
                                            </div>
                                        <!-- </div> -->


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">All Staff</h4><s></s>
                                        <p class="card-title-desc">Listed Below are all the registered staff in this school
                                        </p>
                                        <div class="table-responsive">
                                            <table id="all-staff" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Staff Type</th>
                                                    <th>Rank</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="staff in allstaff" :key="staff.id">
                                                    <td>{{staff.title}}</td>
                                                    <td>{{staff.firstname}}</td>
                                                    <td>{{staff.lastname}}</td>
                                                    <td>{{staff.staff_type}}</td>
                                                    <td>{{staff.rank.rank}}</td>
                                                    <td>
                                                        <button class="btn btn-danger" @click.prevent="deleteStaff(staff.id)" data-toggle="tooltip" data-placement="top" title="Disable staff Profile">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-info" @click.prevent="getSingleStaff(staff.id)" data-toggle="tooltip" data-placement="top" title="Modify staff" >
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-warning" v-if="staff.staff_type=='teaching'" @click.prevent="assignSubject(staff.id)" data-toggle="tooltip" data-placement="top" title="Add Students to staff profile" >
                                                            <i class="fas fa-book-open "></i>
                                                        </button>
                                                            <button class="btn btn-secondary" @click.prevent="assignClassRoomGroup(staff.id)" data-toggle="tooltip" data-placement="top" title="Manage Classroom">
                                                            <i class="fas fa-chalkboard-teacher    "></i>
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

                <!-- ASSIGN WARD MODAL -->
                <div id="subject-modal" class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transaction-detailModalLabel">Assign Subject</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- end row -->
                                <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <h4 class="card-title">All Subjects</h4>
                                                    <p class="card-title-desc">Listed Below are all the registered subjects in this school
                                                    </p>

                                                    <table id="all-subjectgroups" class="table table-bordered dt-responsive nowrap w-100">
                                                        <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Class Group</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="subjectgroup in subjectgroups" :key="subjectgroup.id">
                                                            <td>{{subjectgroup.subjecttitle}}</td>
                                                            <td>{{subjectgroup.classgroupname}}</td>
                                                            <td>
                                                                <button class="btn btn-success" @click.prevent="addSubject(subjectgroup.id, subjectgroup.subjecttitle, subjectgroup.classgroupname)" data-toggle="tooltip" data-placement="top" title="This is my child">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row" v-if="this.allsubjectgroups != ''">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Class Group</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="subject in allsubjectgroups" :key="subject.id">
                                                <td>{{subject.subject}}</td>
                                                <td>{{subject.class}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click.prevent="deleteallsubjectgroups(subject)">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" @click.prevent="saveSubjectAssign">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END ASSIGN WARD MODAL -->

                <!-- ASSIGN CLASSROOM MODAL -->
                <div id="classroom-modal" class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transaction-detailModalLabel">Assign Teacher to Class Room</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- end row -->
                                <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <h4 class="card-title">All Classrooms</h4>
                                                    <p class="card-title-desc">Listed Below are all the available classrooms in this school
                                                    </p>

                                                    <table id="all-classrooms" class="table table-bordered dt-responsive nowrap w-100">
                                                        <thead>
                                                        <tr>
                                                            <th>Class Group</th>
                                                            <th>Class Room</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="roomgroup in classroomgroups" :key="roomgroup.id">
                                                            <td>{{roomgroup.classgroupname}}</td>
                                                            <td>{{roomgroup.classroom}}</td>
                                                            <td>
                                                                <button class="btn btn-success" @click.prevent="addClassRoomGroup(roomgroup.id, roomgroup.classroom, roomgroup.classgroupname)" data-toggle="tooltip" data-placement="top" title="This is my child">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row" v-if="this.allclassroomgroups != ''">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Class Group</th>
                                                <th>Class Room</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="roomgroup in allclassroomgroups" :key="roomgroup.id">
                                                <td>{{roomgroup.classgroup}}</td>
                                                <td>{{roomgroup.classroom}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click.prevent="deleteallclassroomgroups(roomgroup)">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" @click.prevent="saveClassRoomTeacherAssign">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END ASSIGN WARD MODAL -->
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
                newStaff:{
                    title:null,
                    firstname:null,
                    lastname:null,
                    othernames:null,
                    dob:null,
                    genderid:null,
                    religion:null,
                    appointment_date:null,
                    nationalityid:null,
                    stateoforiginid:null,
                    local_govt_area:null,
                    address:null,
                    countryid:null,
                    stateid:null,
                    cityid:null,
                    contactemail:null,
                    contacttel:null,
                    photo:null,
                    branchid:null,
                    rankid:null,
                    staff_type:null

                },
                updateMode:false,
                countries:null,
                states:null,
                stateofo:null,
                cities:null,
                user:null,
                step:1,
                totalsteps:4,
                classgroups:null,
                image:null,
                allstaff:null,
                profileid:null,
                ranks:null,
                staffuserid:null,
                subjectgroups:null,
                allsubjectgroups:[],
                subjectstaught:null,
                classroomgroups:null,
                allclassroomgroups:[],
                classroomsmgd:null

            }
    },

    methods: {
        nextStep(){
            if(this.updateMode == true){
                this.checkFilled = false
            }else {
                this.checkFilled=true
            }
            this.step++
        },
        checkInput(){
            if(this.step == 1 && this.newStaff.title && this.newStaff.firstname != null && this.newStaff.lastname != null && this.newStaff.dob != null && this.newStaff.genderid != null && this.newStaff.religion != null && this.newStaff.rankid != null && this.newStaff.staff_type)
            {
                this.checkFilled = false
            }else if(this.step == 2 && this.newStaff.countryid != null && this.newStaff.stateid != null && this.newStaff.cityid != null && this.newStaff.local_govt_area != null && this.newStaff.address != null && this.newStaff.nationalityid != null && this.newStaff.stateoforiginid){
                this.checkFilled = false
            }else if(this.step == 3 && this.newStaff.contactemail != null && this.newStaff.contacttel != null){
                this.checkFilled = false
            }else if(this.step == this.totalsteps){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },
        prevStep(){
            this.checkInput()
            this.step--
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
        getStateofO(countryid){
            axios.get('api/state/'+countryid).then((result) => {
                this.stateofo = result.data
            }).catch((err) => {

            });
        },
        getCity(stateid){
             axios.get('api/city/'+stateid).then((result) => {
                this.cities = result.data
            }).catch((err) => {

            });
        },
        getRank(){
            axios.get('api/ranks/'+this.user.branchid).then((result) => {
                this.ranks = result.data
            }).catch((err) => {

            });
        },
        getClassGroups(){
            axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                this.classgroups = result.data
            }).catch((err) => {

            });
        },
        pickFile(e){
                let file = e.target.files[0]

                let reader = new FileReader()
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.newStaff.photo = reader.result
                        this.image = reader.result
                    }
                    reader.readAsDataURL(file)
                }else{
                        swal.fire({
                                    icon: 'warning',
                                    title: 'Oooops',
                                    text: 'You are uploading a large file'
                            })
                }
        },
        getStaff(){
            axios.get('api/all-staff/'+this.user.branchid).then((result) => {
                this.allstaff = result.data
            $(function() {
                $('#all-staff').DataTable({
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
        addStaff(){
            axios.post('api/staff/store', this.newStaff).then((result) => {
                  EventBus.$emit('staffCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'staff Profile Created',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                    swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error Adding Profile',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        getSingleStaff(id){
            this.checkTelInput()
            axios.get('api/staff/'+id).then((result) => {
                    this.newStaff.title = result.data[0]['title']
                    this.newStaff.appointment_date = result.data[0]['appointment_date']
                    this.newStaff.firstname = result.data[0]['firstname']
                    this.newStaff.lastname = result.data[0]['lastname']
                    this.newStaff.othernames = result.data[0]['othernames']
                    this.newStaff.dob = result.data[0]['dob']
                    this.newStaff.genderid = result.data[0]['genderid']
                    this.newStaff.religion = result.data[0]['religion']
                    this.newStaff.nationalityid = result.data[0]['nationalityid']
                    this.newStaff.stateoforiginid = result.data[0]['stateoforiginid']
                    this.newStaff.local_govt_area = result.data[0]['local_govt_area']
                    this.newStaff.address = result.data[0]['address']
                    this.newStaff.countryid = result.data[0]['countryid']
                    this.newStaff.stateid = result.data[0]['stateid']
                    this.newStaff.cityid = result.data[0]['cityid']
                    this.newStaff.rankid = result.data[0]['rankid']
                    this.newStaff.contactemail = result.data[0]['contactemail']
                    this.newStaff.contacttel = result.data[0]['contacttel']
                    this.newStaff.photo = result.data[0]['photo']
                    this.profileid = result.data[0]['id']
                    this.staffuserid = result.data[0]['staffuseraccountid']
                    this.newStaff.staff_type = result.data[0]['staff_type']
                    if(result.data != ''){
                        this.checkFilled = false
                        this.updateMode = true
                        EventBus.$emit('updateFetch')
                    }
                    this.getSubjectTeacher()
                    this.getClassRoomTeacher()

            }).catch((err) => {

            });
        },
        updateStaff(){
            this.checkTelInput()
            axios.put('api/staff-update/'+this.profileid, this.newStaff).then((result) => {
                 EventBus.$emit('staffCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'staff Profile Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            }).catch((err) => {
                 swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error Updating Profile',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            });
        },
        deleteStaff(id){
            axios.delete('api/delete-staff/'+id).then((result) => {
                EventBus.$emit('staffCrud')
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'staff Profile Deleted',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                  swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error Deleting Profile',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
         checkTelInput(){
          var tel = this.newStaff.contacttel
          if(tel.length < 14){
              swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Check if telephone has a valid length',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
          }else if(!tel.includes('+234')){
              swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Check if telephone has valid country code',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
          }
        },
        getSubjectGroup(){
            axios.get('api/subjectGroup/'+this.user.branchid).then((result) => {
                this.subjectgroups = result.data
                $(function() {
                 $('#all-subjectgroups').DataTable({
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
        assignSubject(id){
            axios.get('api/staff/'+id).then((result) => {
                this.staffuserid = result.data[0]['staffuseraccountid']
                this.getSubjectGroup()
            }).catch((err) => {

            });
            $('#subject-modal').modal('show')

        },
        addSubject(id,title,classname){
             var index = this.allsubjectgroups.findIndex(x => x.staffuseraccountid==this.staffuserid &&  x.subjectid==id)
            if(index === -1){
                this.allsubjectgroups.push(
                    {
                        'subjectid':id,
                        'staffuseraccountid':this.staffuserid,
                        'subject':title,
                        'class':classname
                    })

            }else{
                  swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Student has already been added as Ward to Parent',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        },

        saveSubjectAssign(){
            axios.post('api/savesubjectassign', this.allsubjectgroups).then((result) => {
                  EventBus.$emit('staffCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'staff Profile Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
              this.allsubjectgroups = null

            }).catch((err) => {
                  EventBus.$emit('staffCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'staff Profile not Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        getSubjectTeacher(){
            axios.get('api/suject_teacher/'+this.staffuserid).then((result) => {
                this.subjectstaught = result.data
            }).catch((err) => {

            });
        },

        deleteTutorSubject(id){
            axios.delete('api/delete-subjecttutor/'+id).then((result) => {
                this.getSubjectTeacher()
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Removed',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })

            }).catch((err) => {

            });
        },
        deleteallsubjectgroups(id){
            var getIndex = this.allsubjectgroups.indexOf(id)
            this.allsubjectgroups.splice(getIndex, 1)
        },
        getClassroomGroups(){
            axios.get('api/classRoomGroup/'+this.user.branchid).then((result) => {
                this.classroomgroups = result.data
            $(function() {
                $('#all-classrooms').DataTable({
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
        assignClassRoomGroup(id){
            axios.get('api/staff/'+id).then((result) => {
                this.staffuserid = result.data[0]['staffuseraccountid']
            }).catch((err) => {

            });
            this.getClassroomGroups()
            $('#classroom-modal').modal('show')

        },
        addClassRoomGroup(id,classname,group){
             var index = this.allclassroomgroups.findIndex(x => x.teacherid==this.staffuserid &&  x.classroomgroupid==id)
            //  console.log(index)
            if(index === -1){
                this.allclassroomgroups.push(
                    {
                        'classroomgroupid':id,
                        'teacherid':this.staffuserid,
                        'classgroup':group,
                        'classroom':classname
                    })

            }else{
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Student has already been added as Ward to Parent',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        },
        saveClassRoomTeacherAssign(){
            axios.post('api/saveclassRoomTeacher', this.allclassroomgroups).then((result) => {
                EventBus.$emit('staffCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Classroom Management Assigned',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.allclassroomgroups = null

            }).catch((err) => {
                    swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Classroom Management not Assigned',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        deleteallclassroomgroups(id){
            var getIndex = this.allclassroomgroups.indexOf(id)
            this.allclassroomgroups.splice(getIndex, 1)
        },
        getClassRoomTeacher(){
            axios.get('api/classroom_teacher/'+this.staffuserid).then((result) => {
                this.classroomsmgd = result.data
            }).catch((err) => {

            });
        },
        deleteclassroomteacher(id){
                    axios.delete('api/delete-classroomteacher/'+id).then((result) => {
                        this.getClassRoomTeacher()
                        swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Removed',
                            customClass: 'swal-wide',
                            showConfirmButton: false,
                            timer: 3000
                        })

                    }).catch((err) => {

                    });
                },
    },

    created() {
        this.getCountry()
        EventBus.$on('staffCrud', () => {
            this.getStaff()
            if(this.updateMode == true){
                this.getSingleStaff(this.profileid)
            }
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.newStaff.branchid = user.branchid
            this.getStaff()
             this.getRank()
        }
        )
        EventBus.$on('updateFetch', ()=>{
            this.getState(this.newStaff.countryid)
            this.getCity(this.newStaff.stateid)
            this.getStateofO(this.newStaff.nationalityid)
            this.getClassGroups()
        })

    },

}
</script>
