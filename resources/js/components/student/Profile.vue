<template>
    <div>
        <nav-bar/>
             <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>New Student & Student Managment</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Students</a></li>
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
                                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">New Student Data</a>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Student Data</a> -->
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
                                                                <label class="form-label">Firstname</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.firstname" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Lastname</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.lastname" type="text" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Othername(s)</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.othernames" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Date of Birth</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.dob" type="date" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Gender</label>
                                                            <select class="form-control" v-model="newStudent.genderid" @change="checkInput">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                    <label class="form-label">Religion</label>
                                                            <select class="form-control" v-model="newStudent.religion" @change="checkInput">
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
                                                            v-model="newStudent.nationalityid"
                                                            @change="getStateofO(newStudent.nationalityid)"

                                                         ><option v-for="country in countries"  :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="form-label">State of Origin <span class="text-danger">*</span></label>
                                                        <select
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
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.local_govt_area" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Address</label>
                                                                <textarea class="form-control" @input="checkInput" v-model="newStudent.address" cols="6" rows="2" placeholder="..."></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">Country </label>
                                                         <select
                                                         class="form-control"
                                                         v-model="newStudent.countryid"
                                                         @change="getState(newStudent.countryid)"
                                                         ><option  v-for="country in countries" :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">State</label>
                                                        <select
                                                        class="form-control"
                                                        v-model="newStudent.stateid"
                                                        @change="getCity(newStudent.stateid)">
                                                                <option>Select</option>
                                                                <option v-for="statee in states" :value="statee.id" :key="statee.id">{{statee.state}}</option>
                                                        </select>

                                                    </div>
                                                       <div class="col-lg-4 mt-2">
                                                            <label class="form-label">City</label>
                                                            <select
                                                                class="form-control"
                                                                v-model="newStudent.cityid"
                                                                @change="checkInput">
                                                                    <option v-for="city in cities" :value="city.id" :key="city.id" >{{ city.city }}</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div v-if="step==3" >
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Enrollement Date</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.enrollmentdate" type="date" placeholder="...">
                                                        </div>
                                                         <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Email Address</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.contactemail" type="email" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                          <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Contact Telephone</label>
                                                                <input class="form-control" @input="checkInput" v-model="newStudent.contacttel" type="text" placeholder="...">
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                           <label class="form-label ">Class Group</label>
                                                            <select
                                                                class="form-control"
                                                                v-model="newStudent.yearid"
                                                                @change="checkInput"
                                                                >
                                                                <option>Select</option>
                                                                <option v-for="group in classgroups" :key="group.id" :value="group.id">{{ group.classgroupname }}</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div v-if="step==4" >
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Student Image</label>

                                                                <!-- <img :src='this.image' height="100px" width="120px"  alt=""> -->
                                                                <input class="form-control" @change="pickFile" type="file" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-warning ml-3 mt-2" @click.prevent="prevStep" v-if="this.step > 1">Previous</button>
                                                <button class="btn btn-primary ml-3 mt-2" @click.prevent="nextStep" v-if="this.step != this.totalsteps && this.checkFilled == false">Next</button>
                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="addStudent" v-if="this.step == this.totalsteps && this.updateMode == false">Add New Student</button>

                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="updateStudent" v-if="this.step == this.totalsteps && this.checkFilled == false && this.updateMode == true">Update Student</button>

                                            </div>
                                            <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2.</div> -->
                                            <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">44  </div> -->
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-lg-4" v-if="updateMode==true">
                                        <div>
                                           <h5 class="ml-5">Student Details</h5>
                                           <img :src="'images/students/'+this.newStudent.photo" alt="student photo" class="img-thumbnail">
                                           <h6 class="mt-4">Student Class Room:</h6>
                                           <p  class="lead" v-show="studentClassRoom.classgroupname">
                                            {{this.studentClassRoom.classgroupname+' '+this.studentClassRoom.classroom}}
                                           </p>
                                           <p  class="lead" v-show="!studentClassRoom.classgroupname">
                                            Class Room Not Assigned
                                           </p>
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

                                        <h4 class="card-title">All Students</h4>
                                        <p class="card-title-desc">Listed Below are all the registered students in this school
                                        </p>

                                    <div class="table-responsive">
                                        <table id="my-table" class="table table-bordered dt-responsive nowrap w-100">
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
                                                    <button class="btn btn-danger" @click.prevent="deleteStudent(student.id)" data-toggle="tooltip" data-placement="top" title="Disable Student Profile">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-info" @click.prevent="getSingleStudent(student.id)" data-toggle="tooltip" data-placement="top" title="Update Student Profile">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-warning" @click.prevent="getStudentAcademicRecord(student.studentuseraccountid)" data-toggle="tooltip" data-placement="top" title="See Student Records">
                                                        <i class="fas fa-chart-line    "></i>
                                                    </button>
                                                    <button class="btn btn-secondary" @click.prevent="assignClassRoom(student.studentuseraccountid)" data-toggle="tooltip" data-placement="top" title="Assign Classrooms">
                                                        <i class="fas fa-chalkboard"></i>
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
                students:null,
                studentuserid:null,
                profileid:null,
                studentClassRoom:null
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
            if(this.step == 1 && this.newStudent.firstname != null && this.newStudent.lastname != null && this.newStudent.dob != null && this.newStudent.genderid != null && this.newStudent.religion != null)
            {
                this.checkFilled = false
            }else if(this.step == 2 && this.newStudent.countryid != null && this.newStudent.stateid != null && this.newStudent.cityid != null && this.newStudent.local_govt_area != null && this.newStudent.address != null && this.newStudent.nationalityid != null && this.newStudent.stateoforiginid){
                this.checkFilled = false
            }else if(this.step == 3 && this.newStudent.enrollmentdate != null && this.newStudent.contactemail != null && this.newStudent.contacttel != null && this.newStudent.yearid != null){
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
        getClassGroups(){
            axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                this.classgroups = result.data
            }).catch((err) => {

            });
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
          checkTelInput(){
          var tel = this.newStudent.contacttel
          if(tel.length < 14 && tel != ''){
              swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Check if telephone has a valid length',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
          }else if(!tel.includes('+234') && tel != ''){
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
        pickFile(e){
                let file = e.target.files[0]

                let reader = new FileReader()
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.newStudent.photo = reader.result
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
        getStudents(){
            axios.get('api/all-students/'+this.user.branchid).then((result) => {
                this.students = result.data

                 $(function() {
            $('#my-table').DataTable({
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
        addStudent(){
            axios.post('api/student/store', this.newStudent).then((result) => {
                  EventBus.$emit('studentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student Profile Created',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.newStudent.firstname =  null
                    this.newStudent.lastname =  null
                    this.newStudent.othernames =  null
                    this.newStudent.dob =  null
                    this.newStudent.genderid =  null
                    this.newStudent.religion =  null
                    this.newStudent.nationalityid =  null
                    this.newStudent.stateoforiginid =  null
                    this.newStudent.local_govt_area =  null
                    this.newStudent.address =  null
                    this.newStudent.countryid =  null
                    this.newStudent.stateid =  null
                    this.newStudent.cityid =  null
                    this.newStudent.enrollmentdate =  null
                    this.newStudent.contactemail =  null
                    this.newStudent.contacttel = null
                    this.newStudent.yearid =  null
                    this.newStudent.photo =  null
                    this.profileid =  null
                    this.studentuserid = null
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
                    this.studentuserid = result.data[0]['studentuseraccountid']
                    if(result.data != ''){
                        this.checkFilled = false
                        this.updateMode = true
                        EventBus.$emit('updateFetch')
                    }
                axios.get('api/studentClassroom/'+this.studentuserid).then((result) => {
                        this.studentClassRoom = result.data
            }).catch((err) => {

            });
            }).catch((err) => {

            });
        },
        updateStudent(){
            axios.put('api/student-update/'+this.profileid, this.newStudent).then((result) => {
                 EventBus.$emit('studentCrud')
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student Profile Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                this.updateMode = false
                this.newStudent.firstname =  null
                    this.newStudent.lastname =  null
                    this.newStudent.othernames =  null
                    this.newStudent.dob =  null
                    this.newStudent.genderid =  null
                    this.newStudent.religion =  null
                    this.newStudent.nationalityid =  null
                    this.newStudent.stateoforiginid =  null
                    this.newStudent.local_govt_area =  null
                    this.newStudent.address =  null
                    this.newStudent.countryid =  null
                    this.newStudent.stateid =  null
                    this.newStudent.cityid =  null
                    this.newStudent.enrollmentdate =  null
                    this.newStudent.contactemail =  null
                    this.newStudent.contacttel = null
                    this.newStudent.yearid =  null
                    this.newStudent.photo =  null
                    this.profileid =  null
                    this.studentuserid = null

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
        deleteStudent(id){
            axios.delete('api/delete-student/'+id).then((result) => {
                EventBus.$emit('studentCrud')
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student Profile Deleted',
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
        assignClassRoom(id){
            var studentid = null
            if(localStorage.getItem('studentid')){
                studentid = localStorage.getItem('studentid')

                }
                if(this.$route.params.id != ''){
                    studentid = id
                    localStorage.setItem('studentid', studentid);
                }
            EventBus.$emit('studentid')
            this.$router.push({name:'StudentDetail', params:{id:id}})
        },

        getStudentClassRoom(){
            axios.get('api/studentClassroom/'+this.studentuserid).then((result) => {
                this.studentClassRoom = result.data
            }).catch((err) => {

            });
        }
    },

    created() {
        this.getCountry()
        EventBus.$on('studentCrud', () => {
            this.getStudents()
            this.getSingleStudent(this.profileid)
            this.getStudentClassRoom()

        })
        EventBus.$on('userData', user => {
            this.user = user
            this.newStudent.branchid = user.branchid
            this.getClassGroups()
            this.getStudents()
        }
        )
        EventBus.$on('updateFetch', ()=>{
            this.getState(this.newStudent.countryid)
            this.getCity(this.newStudent.stateid)
            this.getStateofO(this.newStudent.nationalityid)
        })

    },

}
</script>
