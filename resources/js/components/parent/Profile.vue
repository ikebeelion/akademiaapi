<template>
    <div>
        <nav-bar/>
             <div class="content-body">
                    <div class="container-fluid">

                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Parents & Wards</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Parents and Wards</a></li>
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
                                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">New Parent Data</a>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">parent Data</a> -->
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
                                                                <select v-model="newParent.title" id="" class="form-control" @input="checkInput">
                                                                    <option value="mr">Mr.</option>
                                                                    <option value="miss">Miss</option>
                                                                    <option value="mrs">Mrs.</option>
                                                                    <option value="dr">Dr.</option>
                                                                    <option value="engr">Engr.</option>
                                                                    <option value="prof">Prof</option>
                                                                </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Occupation</label>
                                                                <input class="form-control" @input="checkInput" v-model="newParent.occupation" type="text" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Firstname</label>
                                                                <input class="form-control" @input="checkInput" v-model="newParent.firstname" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Lastname</label>
                                                                <input class="form-control" @input="checkInput" v-model="newParent.lastname" type="text" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Othername(s)</label>
                                                                <input class="form-control" @input="checkInput" v-model="newParent.othernames" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Date of Birth</label>
                                                                <input class="form-control" @input="checkInput" v-model="newParent.dob" type="date" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Gender</label>
                                                            <select class="form-control" v-model="newParent.genderid" @change="checkInput">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                    <label class="form-label">Religion</label>
                                                            <select class="form-control" v-model="newParent.religion" @change="checkInput">
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
                                                            v-model="newParent.nationalityid"
                                                            @change="getStateofO(newParent.nationalityid)"

                                                         ><option v-for="country in countries"  :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="form-label">State of Origin <span class="text-danger">*</span></label>
                                                        <select
                                                        class="form-control"
                                                        v-model="newParent.stateoforiginid"
                                                        @change="checkInput"
                                                        ><option v-for="statee in stateofo" :value="statee.id" :key="statee.id" >{{statee.state}}</option>
                                                        </select>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">L.G.A</label>
                                                                <input class="form-control" @input="checkInput" v-model="newParent.local_govt_area" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Address</label>
                                                                <textarea class="form-control" @input="checkInput" v-model="newParent.address" cols="6" rows="2" placeholder="..."></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">Country </label>
                                                         <select
                                                         class="form-control"
                                                         v-model="newParent.countryid"
                                                         @change="getState(newParent.countryid)"
                                                         ><option  v-for="country in countries" :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">State</label>
                                                        <select
                                                        class="form-control"
                                                        v-model="newParent.stateid"
                                                        @change="getCity(newParent.stateid)">
                                                                <option>Select</option>
                                                                <option v-for="statee in states" :value="statee.id" :key="statee.id">{{statee.state}}</option>
                                                        </select>

                                                    </div>
                                                       <div class="col-lg-4 mt-2">
                                                            <label class="form-label">City</label>
                                                            <select
                                                                class="form-control"
                                                                v-model="newParent.cityid"
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
                                                                <input class="form-control" @input="checkInput" v-model="newParent.contactemail" type="email" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Telephone</label>
                                                                <input class="form-control" @input="checkTelInput" v-model="newParent.contacttel" type="text" placeholder="...">
                                                        </div>

                                                    </div>
                                                </div>

                                                <div v-if="step==4" >
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">parent Image</label>

                                                                <!-- <img :src='this.image' height="100px" width="120px"  alt=""> -->
                                                                <input class="form-control" @change="pickFile" type="file" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-warning ml-3 mt-2" @click.prevent="prevStep" v-if="this.step > 1">Previous</button>
                                                <button class="btn btn-primary ml-3 mt-2" @click.prevent="nextStep" v-if="this.step != this.totalsteps && this.checkFilled == false">Next</button>
                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="addParent" v-if="this.step == this.totalsteps && this.updateMode == false">Add New parent</button>

                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="checkTelInput" v-if="this.step == this.totalsteps && this.checkFilled == false && this.updateMode == true">Update Parent</button>

                                            </div>
                                            <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2.</div> -->
                                            <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">44  </div> -->
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-lg-4" v-if="updateMode==true">
                                        <div>
                                           <h5 class="ml-5">parent Details</h5>
                                           <img :src="'images/parents/'+this.newParent.photo" alt="parent photo" class="img-thumbnail">
                                        </div>
                                        <h5>Wards</h5>
                                        <div v-for="ward in wards" :key=ward.id>
                                            <div v-for="student in ward" :key=student.id>
                                                <a href="#" @click.prevent="getSingleStudent(student.id)">
                                                {{student.firstname }} {{student.lastname}}</a>
                                                 <small>
                                                    <a href="#" class="text-danger" @click="deleteward(student.studentuseraccountid)">Delete</a>
                                                </small>
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

                                        <h4 class="card-title">All Parents</h4>
                                        <p class="card-title-desc">Listed Below are all the registered parents in this school
                                        </p>
                                    <div class="table-responsive">
                                        <table id="all-parents" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Gender</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="parent in parents" :key="parent.id">
                                                <td>{{parent.title}}</td>
                                                <td>{{parent.firstname}}</td>
                                                <td>{{parent.lastname}}</td>
                                                <td>{{parent.genderid}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click.prevent="deleteParent(parent.id)" data-toggle="tooltip" data-placement="top" title="Disable Parent Profile">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info getSingleParent" @click.prevent="getSingleParent(parent.id)" data-toggle="tooltip" data-placement="top" title="Modify Parent" >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-warning" @click.prevent="assignWards(parent.id)" data-toggle="tooltip" data-placement="top" title="Add Students to Parent profile" >
                                                        <i class="fas fa-users"></i>
                                                    </button>
                                                        <button class="btn btn-secondary" @click.prevent="getStudentAcademicRecord(parent.id)" data-toggle="tooltip" data-placement="top" title="View Child Performance">
                                                        <i class="fas fa-chart-line"></i>
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
                <div id="ward-modal" class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transaction-detailModalLabel">Add Ward</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- end row -->
                                <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <h4 class="card-title">All Students</h4>
                                                    <p class="card-title-desc">Listed Below are all the registered students in this school
                                                    </p>
                                                    <div class="table-responsive">
                                                        <table id="all-students" class="table table-bordered dt-responsive nowrap w-100">
                                                            <thead>
                                                            <tr>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Class Group</th>
                                                                <th>Enrollment Date</th>
                                                                <th>Gender</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="student in students" :key="student.id">
                                                                <td>{{student.firstname}}</td>
                                                                <td>{{student.lastname}}</td>
                                                                <td>{{student.class_group.classgroupname}}</td>
                                                                <td>{{student.enrollmentdate}}</td>
                                                                <td>{{student.genderid}}</td>
                                                                <td>
                                                                    <button class="btn btn-success" @click.prevent="addWard(student.studentuseraccountid, student.firstname, student.lastname, student.class_group.classgroupname,student.genderid)" data-toggle="tooltip" data-placement="top" title="This is my child">
                                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row" v-if="this.newWard != ''">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Class Group</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ward in newWard" :key="ward.id">
                                                <td>{{ward.firstname}}</td>
                                                <td>{{ward.lastname}}</td>
                                                <td>{{ward.classgroupname}}</td>
                                                <td>
                                                    <button class="btn btn-danger" @click.prevent="removeFromWard(ward)">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" @click.prevent="saveWard">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END ASSIGN WARD MODAL -->

                <!-- WARD DETAIL MODAL -->
                <div id="ward-detail" class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transaction-detailModalLabel">My Ward</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Student Image</label>
                                                                <img :src="'images/students/'+this.newStudent.photo" alt="parent photo" height="150px" width="150px">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Firstname</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.firstname" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Lastname</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.lastname" type="text" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Othername(s)</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.othernames" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Date of Birth</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.dob" type="date" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Gender</label>
                                                            <select readonly class="form-control" v-model="newStudent.genderid" @change="checkInput">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                    <label class="form-label">Religion</label>
                                                            <select readonly class="form-control" v-model="newStudent.religion" @change="checkInput">
                                                                    <option value="christian">Christian</option>
                                                                    <option value="islam">Islam</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                            <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                                            <select
                                                                readonly
                                                                class="form-control"
                                                                v-model="newStudent.nationalityid"
                                                                @change="getStateofO(newStudent.nationalityid)"

                                                            ><option v-for="country in countries"  :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                            <label class="form-label">State of Origin <span class="text-danger">*</span></label>
                                                            <select
                                                            readonly
                                                            class="form-control"
                                                            v-model="newStudent.stateoforiginid"
                                                            @change="checkInput"
                                                            ><option v-for="statee in stateofo" :value="statee.id" :key="statee.id" >{{statee.state}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">L.G.A</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.local_govt_area" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Address</label>
                                                                <textarea readonly class="form-control" @input="checkInput" v-model="newStudent.address" cols="6" rows="2" placeholder="..."></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 mt-2">
                                                            <label class="form-label">Country </label>
                                                            <select
                                                            readonly
                                                            class="form-control"
                                                            v-model="newStudent.countryid"
                                                            @change="getState(newStudent.countryid)"
                                                            ><option  v-for="country in countries" :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4 mt-2">
                                                            <label class="form-label">State</label>
                                                            <select
                                                            readonly
                                                            class="form-control"
                                                            v-model="newStudent.stateid"
                                                            @change="getCity(newStudent.stateid)">
                                                                    <option>Select</option>
                                                                    <option readonly v-for="statee in states" :value="statee.id" :key="statee.id">{{statee.state}}</option>
                                                            </select>

                                                        </div>
                                                       <div class="col-lg-4 mt-2">
                                                            <label class="form-label">City</label>
                                                            <select
                                                            readonly
                                                                class="form-control"
                                                                v-model="newStudent.cityid"
                                                                @change="checkInput">
                                                                    <option readonly v-for="city in cities" :value="city.id" :key="city.id" >{{ city.city }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Enrollement Date</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.enrollmentdate" type="date" placeholder="...">
                                                        </div>
                                                         <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Email Address</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.contactemail" type="email" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                          <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Telephone</label>
                                                                <input readonly class="form-control" @input="checkInput" v-model="newStudent.contacttel" type="text" placeholder="...">
                                                        </div>
                                                    <div class="col-lg-6 mt-2">
                                                           <label class="form-label ">Class Group</label>
                                                            <select
                                                                class="form-control"
                                                                v-model="newStudent.yearid"
                                                                @change="checkInput"
                                                                readonly
                                                                >
                                                                <option>Select</option>
                                                                <option v-for="group in classgroups" :key="group.id" :value="group.id">{{ group.classgroupname }}</option>
                                                            </select>
                                                        </div>

                                                    </div>



                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END WARD DETAIL MODAL -->
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
                newParent:{
                    title:null,
                    firstname:null,
                    lastname:null,
                    othernames:null,
                    dob:null,
                    genderid:null,
                    religion:null,
                    occupation:null,
                    classgroups:null,
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
                    branchid:null

                },
                 newStudent:{
                    firstname:null,
                    lastname:null,
                    othernames:null,
                    dob:null,
                    genderid:null,
                    religion:null,

                    nationalityid:null,
                    stateoforiginid:null,
                    local_govt_area:null,
                    address:null,
                    countryid:null,
                    stateid:null,
                    cityid:null,

                    enrollmentdate:null,
                    contactemail:null,
                    contacttel:null,
                    yearid:null,
                    photo:null,
                    branchid:null

                },
                newWard: [],
                wards:[],
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
                parents:null,
                profileid:null,
                students:null,
                parentuserid:null
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
            if(this.step == 1 && this.newParent.title && this.newParent.firstname != null && this.newParent.lastname != null && this.newParent.dob != null && this.newParent.genderid != null && this.newParent.religion != null)
            {
                this.checkFilled = false
            }else if(this.step == 2 && this.newParent.countryid != null && this.newParent.stateid != null && this.newParent.cityid != null && this.newParent.local_govt_area != null && this.newParent.address != null && this.newParent.nationalityid != null && this.newParent.stateoforiginid){
                this.checkFilled = false
            }else if(this.step == 3 && this.newParent.contactemail != null && this.newParent.contacttel != null){
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
        checkTelInput(){
          var tel = this.newParent.contacttel
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
        getCity(stateid){
             axios.get('api/city/'+stateid).then((result) => {
                this.cities = result.data
            }).catch((err) => {

            });
        },
        getStudents(){
            axios.get('api/all-students/'+this.user.branchid).then((result) => {
                this.students = result.data
                 $(function() {
                 $('#all-students').DataTable({
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
        getClassGroups(){
            axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                this.classgroups = result.data
            }).catch((err) => {

            });
        },
        getSingleStudent(id){
                axios.get('api/student/'+id).then((result) => {
                        this.newStudent.firstname = result.data[0]['firstname']
                        this.newStudent.lastname = result.data[0]['lastname']
                        this.newStudent.othernames = result.data[0]['othernames']
                        this.newStudent.dob = result.data[0]['dob']
                        this.newStudent.genderid = result.data[0]['genderid']
                        this.newStudent.religion = result.data[0]['religion']
                        this.newStudent.nationalityid = result.data[0]['nationalityid']
                        this.newStudent.stateoforiginid = result.data[0]['stateoforiginid']
                        this.newStudent.local_govt_area = result.data[0]['local_govt_area']
                        this.newStudent.address = result.data[0]['address']
                        this.newStudent.countryid = result.data[0]['countryid']
                        this.newStudent.stateid = result.data[0]['stateid']
                        this.newStudent.cityid = result.data[0]['cityid']
                        this.newStudent.enrollmentdate = result.data[0]['enrollmentdate']
                        this.newStudent.contactemail = result.data[0]['contactemail']
                        this.newStudent.contacttel = result.data[0]['contacttel']
                        this.newStudent.yearid = result.data[0]['yearid']
                        this.newStudent.photo = result.data[0]['photo']
                        this.profileid = result.data[0]['id']
                        $('#ward-detail').modal('show')

                }).catch((err) => {

                });
        },
        pickFile(e){
                let file = e.target.files[0]

                let reader = new FileReader()
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.newParent.photo = reader.result
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
        getParents(){
            axios.get('api/all-parents/'+this.user.branchid).then((result) => {
                this.parents = result.data
                 $(function() {
                 $('#all-parents').DataTable({
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
        addParent(){
            this.checkTelInput()
            axios.post('api/parent/store', this.newParent).then((result) => {
                  EventBus.$emit('parentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'parent Profile Created',
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
        getSingleParent(id){
            // $("#all-parents").on('click', '.getSingleParent', function(){

            // })
            axios.get('api/parent/'+id).then((result) => {
                        this.newParent.title = result.data[0]['title']
                        this.newParent.occupation = result.data[0]['occupation']
                        this.newParent.firstname = result.data[0]['firstname']
                        this.newParent.lastname = result.data[0]['lastname']
                        this.newParent.othernames = result.data[0]['othernames']
                        this.newParent.dob = result.data[0]['dob']
                        this.newParent.genderid = result.data[0]['genderid']
                        this.newParent.religion = result.data[0]['religion']
                        this.newParent.nationalityid = result.data[0]['nationalityid']
                        this.newParent.stateoforiginid = result.data[0]['stateoforiginid']
                        this.newParent.local_govt_area = result.data[0]['local_govt_area']
                        this.newParent.address = result.data[0]['address']
                        this.newParent.countryid = result.data[0]['countryid']
                        this.newParent.stateid = result.data[0]['stateid']
                        this.newParent.cityid = result.data[0]['cityid']
                        this.newParent.contactemail = result.data[0]['contactemail']
                        this.newParent.contacttel = result.data[0]['contacttel']
                        this.newParent.photo = result.data[0]['photo']
                        this.profileid = result.data[0]['id']
                        this.parentuserid = result.data[0]['useraccountid']
                        if(result.data != ''){
                            this.checkFilled = false
                            this.updateMode = true
                            EventBus.$emit('updateFetch')
                        }
                        this.getWards()
                }).catch((err) => {
                });

        },
        updateParent(){
            this.checkTelInput()
            axios.put('api/parent-update/'+this.profileid, this.newParent).then((result) => {
                 EventBus.$emit('parentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Parent Profile Updated',
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
        deleteParent(id){
            axios.delete('api/delete-parent/'+id).then((result) => {
                EventBus.$emit('parentCrud')
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'parent Profile Deleted',
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
        assignWards(id){
            axios.get('api/parent/'+id).then((result) => {
                this.parentuserid = result.data[0]['useraccountid']
                this.getWards()
            }).catch((err) => {

            });
        },
        addWard(studentuseraccountid, firstname, lastname, classgroupname,genderid){
            var index = this.newWard.findIndex(x => x.studentid==studentuseraccountid &&  x.parentid==this.parentuserid)
            if(index === -1){
                this.newWard.push(
                    {
                        'parentid':this.parentuserid,
                        'studentid':studentuseraccountid,
                        'firstname':firstname,
                        'lastname':lastname,
                        'classgroupname':classgroupname,
                        'genderid':genderid
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
        removeFromWard(id){
            var getIndex = this.newWard.indexOf(id)
            this.newWard.splice(getIndex, 1)
        },

        saveWard(){
            axios.post('api/ward/store', this.newWard).then((result) => {
                 this.getWards()
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student added as Ward to Parent',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.newWard = null
                    $('#ward-modal').modal('hide')
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Student has already been added as Ward to Parent',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        getWards(){
            axios.get('api/ward/'+this.parentuserid).then((result) => {
                this.wards = result.data
            }).catch((err) => {

            });
        },
        deleteward(id){
            axios.put('api/delete-ward/'+id).then((result) => {
                this.getWards()
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'deleted',
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
        EventBus.$on('parentCrud', () => {
            this.getParents()
            if(this.updateMode == true){
                this.getSingleParent(this.profileid)
            }
        })
        EventBus.$on('userData', user => {
            this.user = user
            this.newParent.branchid = user.branchid
            this.getParents()
             this.getStudents()
        }
        )
        EventBus.$on('updateFetch', ()=>{
            this.getState(this.newParent.countryid)
            this.getCity(this.newParent.stateid)
            this.getStateofO(this.newParent.nationalityid)
            this.getClassGroups()
        })

    },

}
</script>
