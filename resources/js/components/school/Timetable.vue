<template>
    <div>
        <nav-bar/>
            <div class="content-body">
			    <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Timetable</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Timetable</a></li>
                        </ol>
                    </div>
                </div>
                    <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group mb-3 col-6">
                                        <label class="form-label">Time Table Type</label>
                                        <select v-model="timetable.timetabletype" class="form-control" @change="getClassGroupsRoom">
                                            <option value="">select</option>
                                            <option value="class_timetable">Class Timetable</option>
                                            <option value="exam_timetable">Exam Timetable</option>
                                        </select>
                                    </div>
                                      <div class="form-group mb-3 col-6">
                                            <label for="">Academic Period</label>
                                            <select v-model="timetable.academicPeriodid" class="form-control" @change="checkInput">
                                                <option value="">select</option>
                                                <option v-for="period in academicPeriods" :key="period.id"
                                                :value="{periodid:period.id, periodsession:period.session.session, periodterm: period.term.term}">
                                                    {{ period.session.session }} - {{ period.term.term }}
                                                </option>
                                            </select>
                                        </div><br/>

                                </div>
                                 <div class="row">
                                    <div class="form-group mb-3 col-6" v-if="this.classgroups != null">
                                        <label class="form-label">Class Group</label>
                                        <select v-model="timetable.classGroupId" class="form-control" @change="getClassGroupSubjects">
                                            <option value="">select</option>
                                                <option v-for="group in classgroups" :key="group.id"
                                                 :value="{classid:group.id, groupname:group.classgroupname}">
                                                    {{ group.classgroupname }}
                                                </option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-6" v-if="this.classrooms != null">
                                        <label class="form-label">Class Room</label>
                                        <select v-model="timetable.classGroupId" class="form-control" @change="getClassGroupSubjects">
                                            <option value="">select</option>
                                             <option v-for="room in classrooms" :key="room.classgroupid"
                                                        :value="{classid:room.classgroupid, roomid:room.id, groupname:room.classgroupname, classroom:room.classroom }">
                                                    {{ room.classgroupname }} - {{ room.classroom }}
                                                </option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-6">
                                            <label class="form-label">Subject</label>
                                                                <select v-model="timetable.subjectid" class="form-control" >
                                                                        <option value="">select</option>
                                                                        <option v-for="subject in subjects" :key="subject.id"
                                                                        :value="{subjectid:subject.id, subjecttitle:subject.subjecttitle, subjectclass:subject.classgroupname}">
                                                                            {{ subject.subjecttitle }} - {{subject.classgroupname}}
                                                                        </option>
                                                                    </select>
                                        </div>
                                </div>


                                <div class="form-group mb-3">
                                    <label class="form-label">Day</label>
                                    <select v-model="timetable.day" class="form-control">
                                        <option value="">select</option>
                                        <option value="monday">Monday</option>
                                        <option value="tuesday">Tuesday</option>
                                        <option value="wednesday">Wednesday</option>
                                        <option value="thursday">Thursday</option>
                                        <option value="friday">Friday</option>
                                        <option value="saturday">Saturday</option>
                                        <option value="sunday">Sunday</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Date</label>
                                   <input type="date" v-model="timetable.date" class="form-control">
                                </div>

                                <div class="row">
                                    <div class="form-group mb-3 col-6">
                                        <label class="form-label">From</label>
                                    <input class="form-control" v-model="timetable.from" type="time" name="">
                                    </div>

                                    <div class="form-group mb-3 col-6">
                                        <label class="form-label">To</label>
                                        <input class="form-control" type="time" name="" v-model="timetable.to">
                                    </div>
                                </div>

                                <button class="btn btn-success mb-5" @click="addToTable()">Add to table</button>

                                <div class="row">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <td colspan="2"><button class="btn btn-primary col-12 mb-2 mt-2 ml-2" @click="saveTimeTable()">Save Time Table</button></td>
                                        <td><a href="/timetablerequests" class="btn btn-info col-12 mb-2 mt-2 ml-2">Approve Time Table</a></td></tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td>Class Group</td>
                                            <td>Day</td>
                                            <td>Academic Period</td>
                                            <td>Date</td>
                                            <td>Start Time</td>
                                            <td>End Time</td>
                                            <td>Actions </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="data in timetableArray" :key="data.id">
                                            <td>{{ data.subjectid['subjecttitle'] }} - {{ data.subjectid['subjectclass']}}</td>
                                            <td v-if="data.timetabletype == 'class_timetable'">{{ data.classGroupId['groupname'] }} - {{ data.classGroupId['classroom']}}</td>
                                            <td v-else>{{ data.classGroupId['groupname'] }}</td>
                                            <td>{{ data.day }}</td>
                                            <td>{{ data.academicPeriodid['periodterm'] }}</td>
                                            <td>{{ data.date }}</td>
                                            <td>{{ data.from }}</td>
                                            <td>{{ data.to }}</td>
                                            <td>
                                                 <button class="btn btn-danger" @click="deleteTimetable(data)">
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
export default {
    components: {NavBar},
    data() {
        return {
                checkFilled:true,
                timetable:{
                    classRoomGroupid:null,
                    classGroupId:null,
                    timetabletype:null,
                    subjectid:null,
                    academicPeriodid:null,
                    from:null,
                    to:null,
                    day:null,
                    date:null,
                },
                timetableArray:[],
                branchid:null,
                updateMode:false,
                user:null,
                subjects:null,
                classrooms:null,
                classgroups:null,
                subjects:null,
                academicPeriods:null,


            }
    },

    methods: {
      getClassGroupsRoom(){
        //class_timetable exam_timetable
          if(this.timetable.timetabletype == 'class_timetable'){
              axios.get('api/classRoomGroup/'+this.user.branchid).then((result) => {
                  this.classgroups = null
                  this.classrooms = result.data

              }).catch((err) => {

              });
          }else{
              axios.get('api/classGroups/'+this.user.branchid).then((result) => {
                  this.classrooms = null
                  this.classgroups = result.data
              }).catch((err) => {

              });
          }
      },
      getClassGroupSubjects(){
          axios.get('api/subjectGrpt/'+this.timetable.classGroupId.classid).then((result) => {
              this.subjects = result.data
          }).catch((err) => {

          });
      },
        getAcademicPeriod(){
            axios.get('api/period/'+this.user.branchid).then((result) => {
                this.academicPeriods = result.data
            }).catch((err) => {

            });
        },

        addToTable(){
            //push to array
            this.timetableArray.push({
                 classRoomGroupid:this.timetable.classRoomGroupid,
                    classGroupId:this.timetable.classGroupId,
                    timetabletype:this.timetable.timetabletype,
                    subjectid:this.timetable.subjectid,
                    academicPeriodid:this.timetable.academicPeriodid,
                    from:this.timetable.from,
                    to:this.timetable.to,
                    day:this.timetable.day,
                    date:this.timetable.date,
                    branchid:this.user.branchid
            })
        },

        deleteTimetable(data){
            var index = this.timetableArray.indexOf(data)
            this.timetableArray.splice(index,1)

        },

        saveTimeTable(){
            axios.post('api/timetable/store', this.timetableArray).then((result) => {
                this.timetableArray = []
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Timetable Saved',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {

            });
        }


    },

    created() {
        EventBus.$on('userData', user => {
            this.user = user
            this.getAcademicPeriod()
        })
    },

}
</script>

