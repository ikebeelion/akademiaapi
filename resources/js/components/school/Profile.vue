<template>
    <div>
        <nav-bar/>
            <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>School Profile</h4>
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
                                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">School Data</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Principal Officer Contact Information</a>
                                            </li>

                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Name</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.schoolname" type="text" placeholder="...">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Alias</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.alias" type="text" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                       <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Address</label>
                                                                <textarea class="form-control" @input="checkInput" v-model="schoolProfile.address" cols="6" rows="2" placeholder="..."></textarea>
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Date of Establishment</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.year_of_establishment" type="date" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">Country </label>
                                                         <select
                                                         class="form-control"
                                                         v-model="schoolProfile.countryid"
                                                         @change="getState(schoolProfile.countryid)"
                                                         ><option  v-for="country in countries" :value="country.id" :key="country.id"> {{ country.country   }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 mt-2">
                                                        <label class="form-label">State</label>
                                                        <select
                                                        class="form-control"
                                                        v-model="schoolProfile.stateid"
                                                        @change="getCity(schoolProfile.stateid)">
                                                                <option>Select</option>
                                                                <option v-for="statee in states" :value="statee.id" :key="statee.id">{{statee.state}}</option>
                                                        </select>

                                                    </div>
                                                       <div class="col-lg-4 mt-2">
                                                            <label class="form-label">City</label>
                                                            <select
                                                                class="form-control"
                                                                v-model="schoolProfile.cityid"
                                                                @change="checkInput">
                                                                    <option v-for="city in cities" :value="city.id" :key="city.id" >{{ city.city }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                         <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Email Address</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.schoolemail" type="email" placeholder="...">
                                                        </div>
                                                            <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Telephone</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.schooltel" type="text" placeholder="...">
                                                            </div>
                                                    </div>
                                                    <div class="row">

                                                            <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Moto</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.schoolmotto" type="text" placeholder="...">
                                                            </div>
                                                                                         <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Logo</label>

                                                                <!-- <img :src='this.image' height="100px" width="120px"  alt=""> -->
                                                                <input class="form-control" @change="pickFile" type="file" placeholder="...">
                                                        </div>

                                                </div>
                                                  <div class="row">

                                                            <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Zone</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.schoolzone" type="text" placeholder="...">
                                                            </div>
                                                            <div class="col-lg-6 mt-2">
                                                            <label class="form-label">School Chapter</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.schoolchapter" type="text" placeholder="...">
                                                        </div>

                                                </div>
                                                  <div class="row">

                                                            <div class="col-lg-6 mt-2">
                                                                <label class="form-label">School Association of Affiliation</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.associationAffiliation" type="text" placeholder="...">
                                                            </div>
                                                                    <div class="col-lg-6 mt-2">
                                                                <label class="form-label">Student Educaton District</label>
                                                                <input class="form-control" @input="checkInput" v-model="schoolProfile.educationDistrict" type="text" placeholder="...">
                                                        </div>

                                                </div>





                                                <button class="btn btn-success ml-3 mt-2" @click.prevent="updateSchoolProfile" >Update School Profile</button>

                                            </div>
                                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                <div v-for="principalOfficer in principalOfficer" :key="principalOfficer.id">
    <!-- {{ this.principalOfficer[0] }} -->
                                                 <div class="table-responsive">
                                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">

                                                <tbody>
                                                <tr>
                                                    <td>Title</td>
                                                    <td>{{principalOfficer.title}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Appointment Date</td>
                                                    <td>{{principalOfficer.appointment_date}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Firstname</td>
                                                    <td>{{principalOfficer.firstname}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Lastname</td>
                                                    <td>{{principalOfficer.lastname }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email Adress</td>
                                                    <td>{{principalOfficer.contactemail }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Telephone</td>
                                                    <td>{{principalOfficer.contacttel}}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                                </div>
                                            </div>

                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-lg-4">
                                        <div>
                                           <h5 class="ml-5">School Details</h5>
                                           <img :src="'images/school/'+this.schoolProfile.schoollogo" alt="school photo" class="img-thumbnail">
                                            <p class="lead">{{this.schoolProfile.schoolmotto}}</p>
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
    components: { NavBar},
    data() {
        return {
                checkFilled:true,
                schoolProfile:{
                    schoolname:null,
                    alias:null,
                    schoolemail:null,
                    schooltel:null,
                    schoollogo:null,
                    schoolmotto:null,
                    address:null,
                    countryid:null,
                    stateid:null,
                    cityid:null,
                    year_of_establishment:null,
                    schoolzone:null,
                    schoolchapter:null,
                    associationAffiliation:null,
                    educationDistrict:null,
                    // principal:null
                },
                countries:null,
                states:null,
                cities:null,
                user:null,
                image:null,
                principalOfficer:null
            }
    },

    methods: {

        checkInput(){
            if(this.schoolProfile.schoolname != null && this.schoolProfile.schoolemail != null && this.schoolProfile.schooltel != null && this.schoolProfile.year_of_establishment != null && this.schoolProfile.address != null && this.schoolProfile.countryid != null && this.schoolProfile.stateid != null && this.schoolProfile.cityid != null)
            {
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
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
        checkTelInput(){
          var tel = this.schoolProfile.schooltel
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
        getPrincipalOfficer(){
            axios.get('api/principalOfficer/'+this.user.branchid).then((result) => {
                this.principalOfficer = result.data
            }).catch((err) => {

            });
        },
        getCity(stateid){
             axios.get('api/city/'+stateid).then((result) => {
                this.cities = result.data
            }).catch((err) => {

            });
        },
        pickFile(e){
                let file = e.target.files[0]

                let reader = new FileReader()
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.schoolProfile.schoollogo = reader.result
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
        getSchoolInfo(){
            axios.get('api/index/'+this.user.branch.schoolid).then((result) => {
                this.schoolProfile.schoolname = result.data['schoolname']
                this.schoolProfile.alias = result.data['alias']
                this.schoolProfile.schoolemail = result.data['schoolemail']
                this.schoolProfile.schooltel = result.data['schooltel']
                this.schoolProfile.schoollogo = result.data['schoollogo']
                this.schoolProfile.schoolmotto = result.data['schoolmotto']
                this.schoolProfile.address = result.data['address']
                this.schoolProfile.countryid = result.data['countryid']
                this.schoolProfile.stateid = result.data['stateid']
                this.schoolProfile.cityid = result.data['cityid']
                this.schoolProfile.year_of_establishment = result.data['year_of_establishment']
                this.schoolProfile.schoolzone = result.data['schoolzone']
                this.schoolProfile.schoolchapter = result.data['schoolchapter']
                this.schoolProfile.associationAffiliation = result.data['associationAffiliation']
                this.schoolProfile.educationDistrict = result.data['educationDistrict']
                EventBus.$emit('updateFetch')

            }).catch((err) => {

            });
        },
        updateSchoolProfile(){
            this.checkTelInput()
            axios.put('api/school/'+this.user.branch.schoolid, this.schoolProfile).then((result) => {
                    this.getSchoolInfo()
                    swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Schoool Profile Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                    swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Schoool Profile not Updated',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        }
    },
    created() {
        this.getCountry()

        EventBus.$on('userData', user => {
            this.user = user
            this.getSchoolInfo()
            this.getPrincipalOfficer()
        }
        )
        EventBus.$on('updateFetch', ()=>{
            this.getState(this.schoolProfile.countryid)
            this.getCity(this.schoolProfile.stateid)
        })

    },

}
</script>
