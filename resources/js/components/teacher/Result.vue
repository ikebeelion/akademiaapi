<template>

    <div>
            <div v-if="resultMode" id="printResult">
                        <div class="card">
                          <div class="card-body"  id="result">
                                <p class="card-text">
                                    <!-- SCHOOL INFORMATION -->
                                    <div class="row">
                                        <div class="col-3"><img :src="'images/school/'+this.schoolProfile.schoollogo" alt="school photo" height="80px" width="100px"> </div>
                                        <div class="col-6">
                                                <center>
                                            <h3 id="school-name">{{this.schoolProfile.schoolname}}</h3>
                                                    <p><strong>{{this.schoolProfile.address}}</strong></p>
                                                </center>
                                            </div>
                                    </div>
                                    <!-- STUDENT INFORMATION -->
                                    <center>
                                        <u><h5> {{ resultProfile[0].term}} Student Performance Report </h5></u>

                                    </center>
                                    <div class="table-responsive mt-5">
                                        <table class="w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="mr-3"><b>NAME OF STUDENT:</b>
                                                        {{resultProfile[0].firstname}}{{ resultProfile[0].othername }} {{ resultProfile[0].lastname}}
                                                    </td>
                                                    <td class="mr-3"><b>GENDER:</b>
                                                        {{resultProfile[0].genderid}}
                                                    </td>
                                                    <td><b>ADMISSION NO:</b>
                                                        WVHS/{{ resultProfile[0].studentuseraccountid}}0

                                                    </td>
                                                    <td rowspan=3>
                                                        <img :src="'images/students/'+this.resultProfile[0].photo" alt="student photo" height="80px" width="90px">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><b>CLASSROOM:</b>
                                                        {{resultProfile[0].classgroupname}} {{resultProfile[0].classroom}}
                                                    </td>
                                                    <td><b>ACADEMIC SESSION:</b>
                                                        {{resultProfile[0].session}}
                                                    </td >
                                                    <td><b>TERM:</b>
                                                        {{ resultProfile[0].term}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="mr-1"><b>DOB:</b>
                                                        {{resultProfile[0].dob}}
                                                    </td>
                                                    <td class="mr-1"><b>Age:</b>
                                                        {{ age(resultProfile[0].dob) }} years
                                                    </td>

                                                    <td class="mr-1"><b>Students in Class:</b>
                                                        {{ studentsCount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="mr-1"><b>Next Term Begins:</b>
                                                        {{ resultProfile[0].next_resumption }}
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- STUDENT RESULT -->
                                    <div class="table-responsive mt-1">
                                        <table class="table table-striped table-bordered dt-responsive nowrap w-100">
                                            <thead class="thead">
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <!-- <td rowspan="2">HESOYAM</td> -->
                                                    <th colspan="3">
                                                        <center>CA</center>
                                                    </th>
                                                    <th rowspan="2">EXAM</th>
                                                    <th rowspan="2">TOTAL</th>
                                                    <th rowspan="2">GRADE</th>
                                                    <th rowspan="2">REMARK</th>
                                                </tr>
                                                <tr>
                                                    <th>Subjects</th>
                                                    <th>Credit Load</th>
                                                    <th>G.P.A</th>
                                                    <th>1st</th>
                                                    <th>2nd</th>
                                                    <th>3rd</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <tr v-for="res in result" :key="res.id" >
                                                        <td id="subject" class="bg-info text-light" v-if="res != ''">{{res[0].subjecttitle}}</td>
                                                        <td class="bg-gray" v-if="res==[]">-</td>
                                                        <td class="bg-info text-dark" v-if="res != ''">
                                                        {{  parseFloat(res[0].credit_load)}}
                                                        </td>
                                                        <td v-if="res==[]">-</td>
                                                        <td class="bg-info text-dark" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">
                                                            <input type="hidden" @change="scoreGPA">
                                                        {{  parseFloat(res[0].credit_load) * 5 }}
                                                        </td>
                                                        <td class="bg-info text-dark"
                                                            v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70">
                                                            <input type="hidden" @change="scoreGPA">
                                                            {{  parseFloat(res[0].credit_load) * 4 }}
                                                        </td>
                                                        <td class="bg-info text-dark" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60">
                                                        <input type="hidden"
                                                            :value="parseFloat(res[0].credit_load) * 3"
                                                            @change="scoreGPA">
                                                            {{  parseFloat(res[0].credit_load) * 3 }}
                                                        </td>
                                                        <td class="bg-info text-dark" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50">
                                                            <input type="hidden"
                                                            :value="parseFloat(res[0].credit_load) * 1"
                                                            @change="scoreGPA">
                                                            {{  parseFloat(res[0].credit_load) * 1 }}
                                                        </td>
                                                        <td class="bg-info text-dark" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" >
                                                            <input type="hidden"
                                                            :value="parseFloat(res[0].credit_load) * 0"
                                                            @change="scoreGPA">
                                                            {{  parseFloat(res[0].credit_load) * 0 }}
                                                        </td>
                                                        <td class="bg-gray" v-if="res==[]">-</td>
                                                        <td v-if="res != '' && res[0].restult_typeid == 1">{{res[0].score_obtained}}</td>
                                                        <td v-if="res==[]">-</td>
                                                        <td v-if="res != '' && res[1].restult_typeid == 2">{{res[1].score_obtained}}</td>
                                                        <td v-if="res==[]">-</td>
                                                        <td v-if="res != '' && res[2].restult_typeid == 3">{{res[2].score_obtained}}</td>
                                                        <td v-if="res==[]">-</td>
                                                        <td v-if="res != '' && res[3].restult_typeid == 4">{{res[3].score_obtained}}</td>
                                                        <td v-if="res==[]">-</td>
                                                        <td v-if="res != ''">
                                                            <input type="hidden"
                                                            :value="parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained)"
                                                            :name="parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained)"
                                                            @change="scoreTotal">
                                                            {{ parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) }}
                                                        </td>
                                                        <td v-if="res==[]">-</td>
                                                        <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">A</td>
                                                        <td v-if="res==[]">-</td>
                                                        <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70"> B </td>
                                                        <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60"> C </td>
                                                        <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50"> D </td>
                                                        <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" > F </td>
                                                        <td class="text-light distinction" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">Distinction</td>
                                                        <td v-if="res==[]">-</td>
                                                        <td class="text-dark verygood" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70"> Very Good </td>
                                                        <td class="text-dark credit" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60"> Credit </td>
                                                        <td class="text-light pass" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50"> Pass </td>
                                                        <td class="text-white fail" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" > Fail </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <center>
                                                <div class="row">

                                                <div class="col-4">
                                                    <table class="table table-bordered mt-2">
                                                            <tr>
                                                                <!-- <th>Overall</th> -->
                                                                <!-- <th>C.P.A</th> -->
                                                                <th><center>Average</center></th>
                                                                <!-- <th>REMARK</th> -->
                                                            </tr>
                                                            <tr>
                                                                <!-- <td>400</td> -->
                                                                <!-- <td>4</td> -->
                                                                <td>
                                                                    <center>{{ Math.round(this.average * 100) / 100}}</center>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                </div>
                                                <div class="col-4">
                                                <table class="table table-bordered mt-2">
                                                            <tr>
                                                                <!-- <th>Overall</th> -->
                                                                <!-- <th>C.P.A</th> -->
                                                                <th><center>G.P.A</center></th>
                                                                <th>REMARK</th>
                                                            </tr>
                                                            <tr>
                                                                <!-- <td>400</td> -->
                                                                <!-- <td>4</td> -->
                                                                <td>
                                                                    <center>{{roundPoints()}}</center>
                                                                </td>
                                                                <td v-if="this.totalpoints >= 4.5">First Class</td>
                                                                <td v-if="this.totalpoints >= 3.5 && this.totalpoints <= 4.4">Second Class Upper</td>
                                                                <td v-if="this.totalpoints >= 3.0 && this.totalpoints <= 3.4">Second Class Lower</td>
                                                                <td v-if="this.totalpoints < 3.0">Third Class</td>
                                                            </tr>
                                                        </table>
                                                </div>
                                                <div class="col-4">
                                                <small>
                                                    <table class="table table-bordered mt-2">
                                                            <tr>
                                                                <th> A </th>
                                                                <th> B </th>
                                                                <th> C </th>
                                                                <th> D </th>
                                                                <th> F </th>
                                                            </tr>
                                                            <tr>
                                                                <td>70 & above</td>
                                                                <td>60 - 69 </td>
                                                                <td>50 - 59</td>
                                                                <td>40 - 49</td>
                                                                <td>0 - 39</td>
                                                            </tr>
                                                        </table>
                                                </small>

                                                </div>
                                                </div>



                                        </center>
                                    </div>

                                    <!-- STUDENT PSYCHOMOTOR -->
                                    <small>
                                        <div class="row">
                                            <div class="table-responsive mt-3 col-4">
                                                <table class="table table-bordered dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>AFFECTIVE DOMAIN</th>
                                                            <th colspan="2">RATING</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                            <tr v-for="psych in psych" :key="psych.id" >
                                                                <td>{{psych.psychomotor}}</td>
                                                                <td>{{psych.rating}}</td>
                                                                <td class="text-light distinction" v-if="psych.rating == 5">Excellent</td>
                                                                <td class="text-dark verygood" v-if="psych.rating == 4">Very good</td>
                                                                <td class="text-dark credit" v-if="psych.rating == 3">Satisfactory</td>
                                                                <td class="text-light pass" v-if="psych.rating == 2">Fair</td>
                                                                <td class="text-light fail" v-if="psych.rating == 1">Poor</td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive mt-3 col-4">
                                                <table class="table table-bordered dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th><center>RATING INDICES</center></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                            <tr>
                                                                <td>
                                                                    <p>5 - Maintains an Excellent degree of Observable traits</p>
                                                                    <p>4 - Maintains an High Level of Observable traits</p>
                                                                    <p>3 - Acceptable Level of Observable traits</p>
                                                                    <p>2 - Shows Minimal regard for Observable traits</p>
                                                                    <p>1 - Has No regard for Observable traits</p>
                                                                </td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- </div> -->
                                        <!-- STUDENT REMARK -->
                                        <div class=" mt-3 col-6">
                                            <h4>REMARKS</h4>
                                                <div class="form-group mb-2">
                                                    <label for="my-input">
                                                        Class Teacher Remark: <b>{{remark[0].teacher_remark}}</b>
                                                    </label>

                                                </div>

                                                <div class="form-group">
                                                    <label for="my-input">
                                                        Principal Remark: <b>{{remark[0].principal_remark}}</b>
                                                    </label>
                                                </div>
                                        </div>
                                        </div>
                                    </small>
                                    <!-- PERFORMANCE COMMENT -->
                                    <div id="performance"></div>
                                    <small>
                                        <div class="row" >
                                            <table class="table table-bordered">
                                                <thead class="thead bg-dark">
                                                    <tr>
                                                        <td class="text-light" id="comment">Subject</td>
                                                        <td class="text-light" id="comment">comment</td>
                                                        <td class="text-light" id="comment">Score</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <!--
                                                    <tr v-for="comment in comments" :key="comment.id">
                                                        <td>{{comment.subjecttitle}}</td>
                                                        <td>{{comment.teacher_remark}}</td>
                                                    </tr>-->

                                                    <tr v-for="comment in comments" :key="comment.id">
                                                        <td>{{comment.subjecttitle}}</td>
                                                        <td>{{comment.teacher_remark}}</td>
                                                        <td>
                                                            <small>
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>C.A</td>
                                                                        <td>EXAM</td>
                                                                        <td>SCORE</td>
                                                                        <td>CLASS AVG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{comment.ca}}</td>
                                                                        <td>{{comment.exam}}</td>
                                                                        <td>{{comment.score}}</td>
                                                                        <td>{{comment.avg}}</td>
                                                                    </tr>
                                                                </table>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="table-responsive mt-3 col-12">
                                                <table class="table table-bordered dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>PSYCHOMOTIVE DOMAIN</th>
                                                            <th colspan="2">RATING</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <tr v-for="dom in domain" :key="dom.id" >
                                                                <td>{{dom.affective_domain}}</td>
                                                                <td>{{dom.rating}}</td>
                                                                <td class="text-light distinction" v-if="dom.rating == 5">Excellent</td>
                                                                <td class="text-dark verygood" v-if="dom.rating == 4">Very good</td>
                                                                <td class="text-dark credit" v-if="dom.rating == 3">Satisfactory</td>
                                                                <td class="text-light pass" v-if="dom.rating == 2">Fair</td>
                                                                <td class="text-light fail" v-if="dom.rating == 1">Poor</td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </small>
                            </div>
                        </div>
            </div>
        <nav-bar/>
            <div class="content-body">
                    <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Check Result of Students in your class</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                            <li class="breadcrumb-item active"><a href="#">Result</a></li>
                        </ol>
                    </div>
                </div>
                        <div class="row" v-if="!resultMode">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>

                                        <div class="form-group">
                                            <label for="">Class Group</label>
                                            <select class="form-control" v-model="getResult.classgroup" @change="makeNull()">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroup" :value="classroom.clgid" :key="classroom.clgid">
                                                    {{ classroom.classgroupname }}
                                                </option>

                                            </select>
                                        </div><br/>
                                        <div class="form-group">
                                            <label for="">Class Room</label>
                                            <select class="form-control" v-model="getResult.classroom" @change="getStudentsInClass()">
                                                <option value="">--</option>
                                                <option v-for="classroom in classroomgroups" :value="classroom.clsrmgpid" :key="classroom.clsrmgpid">
                                                    {{ classroom.classgroupname }} - {{classroom.classroom}}
                                                </option>

                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label for="">Academic Period</label>
                                            <select v-model="getResult.academicPeriodid" class="form-control" @change="checkInput">
                                                <option value="">select</option>
                                                <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                                    {{ period.session.session }} - {{ period.term.term }}
                                                </option>
                                            </select>
                                        </div><br/>


                                                <div class="table-responsive mt-5">
                                            <table id="all-students" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="student in students" :key="student.studentuseraccountid">
                                                    <td>{{student.firstname}}</td>
                                                    <td>{{student.lastname}}</td>
                                                    <td>
                                                        <button class="btn btn-primary" @click.prevent=getStudentResult(student.studentuseraccountid)>
                                                            Generate Result
                                                        </button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div v-if="resultMode">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">
                        <!-- SCHOOL INFORMATION -->
                        <div class="row">
                            <div class="col-3"><img :src="'images/school/'+this.schoolProfile.schoollogo" alt="school photo" height="80px" width="100px"> </div>
                            <div class="col-6">
                                    <center>
                                <h3 id="school-name">{{this.schoolProfile.schoolname}}</h3>
                                        <p><strong>{{this.schoolProfile.address}}</strong></p>
                                    </center>
                                </div>
                        </div>
                        <!-- STUDENT INFORMATION -->
                        <center>
                            <u><h5> {{ resultProfile[0].term}} Student Performance Report </h5></u>

                        </center>
                        <div class="table-responsive mt-5">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="mr-3"><b>NAME OF STUDENT:</b>
                                            {{resultProfile[0].firstname}}{{ resultProfile[0].othername }} {{ resultProfile[0].lastname}}
                                        </td>
                                        <td class="mr-3"><b>GENDER:</b>
                                            {{resultProfile[0].genderid}}
                                        </td>
                                        <td><b>ADMISSION NO:</b>
                                             WVHS/{{ resultProfile[0].studentuseraccountid}}0
                                        </td>
                                        <td rowspan=3>
                                            <img :src="'images/students/'+this.resultProfile[0].photo" alt="student photo" height="80px" width="90px">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>CLASSROOM:</b>
                                            {{resultProfile[0].classgroupname}} {{resultProfile[0].classroom}}
                                        </td>
                                        <td><b>ACADEMIC SESSION:</b>
                                            {{resultProfile[0].session}}
                                        </td >
                                        <td><b>TERM:</b>
                                            {{ resultProfile[0].term}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="mr-1"><b>DOB:</b>
                                            {{resultProfile[0].dob}}
                                        </td>
                                        <td class="mr-1"><b>Age:</b>
                                            {{ age(resultProfile[0].dob) }} years
                                        </td>

                                        <td class="mr-1"><b>Students in Class:</b>
                                            {{ studentsCount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="mr-1"><b>Next Term Begins:</b>
                                            {{ resultProfile[0].next_resumption }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- STUDENT RESULT -->
                        <div class="table-responsive mt-1">
                            <table class="table table-striped table-bordered dt-responsive nowrap w-100">
                                <thead class="thead">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <!-- <td rowspan="2">HESOYAM</td> -->
                                        <th colspan="3">
                                            <center>CA</center>
                                        </th>
                                        <th rowspan="2">EXAM</th>
                                        <th rowspan="2">TOTAL</th>
                                        <th rowspan="2">GRADE</th>
                                        <th rowspan="2">REMARK</th>
                                    </tr>
                                    <tr>
                                        <th>Subjects</th>
                                        <th>Credit Load</th>
                                        <th>G.P.A</th>
                                        <th>1st</th>
                                        <th>2nd</th>
                                        <th>3rd</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr v-for="res in result" :key="res.id" >
                                            <td class="bg-info text-light" v-if="res != ''">{{res[0].subjecttitle}}</td>
                                            <td class="bg-gray" v-if="res==[]">-</td>
                                            <td class="bg-info text-light" v-if="res != ''">
                                               {{  parseFloat(res[0].credit_load)}}
                                            </td>
                                            <td v-if="res==[]">-</td>
                                            <td class="bg-info text-light" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">
                                                <input type="hidden" @change="scoreGPA">
                                               {{  parseFloat(res[0].credit_load) * 5 }}
                                            </td>
                                            <td class="bg-info text-light"
                                                v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70">
                                                <input type="hidden" @change="scoreGPA">
                                                {{  parseFloat(res[0].credit_load) * 4 }}
                                            </td>
                                            <td class="bg-info text-light" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60">
                                            <input type="hidden"
                                                :value="parseFloat(res[0].credit_load) * 3"
                                                @change="scoreGPA">
                                                {{  parseFloat(res[0].credit_load) * 3 }}
                                            </td>
                                            <td class="bg-info text-light" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50">
                                                <input type="hidden"
                                                :value="parseFloat(res[0].credit_load) * 1"
                                                @change="scoreGPA">
                                                {{  parseFloat(res[0].credit_load) * 1 }}
                                            </td>
                                            <td class="bg-info text-light" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" >
                                                <input type="hidden"
                                                :value="parseFloat(res[0].credit_load) * 0"
                                                @change="scoreGPA">
                                                {{  parseFloat(res[0].credit_load) * 0 }}
                                            </td>
                                            <td class="bg-gray" v-if="res==[]">-</td>
                                            <td v-if="res != '' && res[0].restult_typeid == 1">{{res[0].score_obtained}}</td>
                                            <td v-if="res==[]">-</td>
                                            <td v-if="res != '' && res[1].restult_typeid == 2">{{res[1].score_obtained}}</td>
                                            <td v-if="res==[]">-</td>
                                            <td v-if="res != '' && res[2].restult_typeid == 3">{{res[2].score_obtained}}</td>
                                            <td v-if="res==[]">-</td>
                                            <td v-if="res != '' && res[3].restult_typeid == 4">{{res[3].score_obtained}}</td>
                                            <td v-if="res==[]">-</td>
                                            <td v-if="res != ''">
                                                <input type="hidden"
                                                :value="parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained)"
                                                :name="parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained)"
                                                @change="scoreTotal">
                                                {{ parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) }}
                                            </td>
                                            <td v-if="res==[]">-</td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">A</td>
                                            <td v-if="res==[]">-</td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70"> B </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60"> C </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50"> D </td>
                                            <td v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" > F </td>
                                            <td class="text-light distinction" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70">Distinction</td>
                                            <td v-if="res==[]">-</td>
                                            <td class="text-dark verygood" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70"> Very Good </td>
                                            <td class="text-dark credit" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 60"> Credit </td>
                                            <td class="text-light pass" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 50"> Pass </td>
                                            <td class="text-white fail" v-if="res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40" > Fail </td>
                                    </tr>
                                </tbody>
                            </table>
                            <center>
                                    <div class="row">

                                    <div class="col-4">
                                        <table class="table table-bordered mt-2">
                                                <tr>
                                                    <!-- <th>Overall</th> -->
                                                    <!-- <th>C.P.A</th> -->
                                                    <th><center>Average</center></th>
                                                    <!-- <th>REMARK</th> -->
                                                </tr>
                                                <tr>
                                                    <!-- <td>400</td> -->
                                                    <!-- <td>4</td> -->
                                                    <td>
                                                        <center>{{ Math.round(this.average * 100) / 100}}</center>
                                                    </td>
                                                </tr>
                                            </table>
                                    </div>
                                    <div class="col-4">
                                      <table class="table table-bordered mt-2">
                                                <tr>
                                                    <!-- <th>Overall</th> -->
                                                    <!-- <th>C.P.A</th> -->
                                                    <th><center>G.P.A</center></th>
                                                    <th>REMARK</th>
                                                </tr>
                                                <tr>
                                                    <!-- <td>400</td> -->
                                                    <!-- <td>4</td> -->
                                                    <td>
                                                        <center>{{roundPoints()}}</center>
                                                    </td>
                                                    <td v-if="this.totalpoints >= 4.5">First Class</td>
                                                    <td v-if="this.totalpoints >= 3.5 && this.totalpoints <= 4.4">Second Class Upper</td>
                                                    <td v-if="this.totalpoints >= 3.0 && this.totalpoints <= 3.4">Second Class Lower</td>
                                                    <td v-if="this.totalpoints < 3.0">Third Class</td>
                                                </tr>
                                            </table>
                                    </div>
                                    <div class="col-4">
                                    <small>
                                        <table class="table table-bordered mt-2">
                                                <tr>
                                                    <th> A </th>
                                                    <th> B </th>
                                                    <th> C </th>
                                                    <th> D </th>
                                                    <th> F </th>
                                                </tr>
                                                <tr>
                                                    <td>70 & above</td>
                                                    <td>60 - 69 </td>
                                                    <td>50 - 59</td>
                                                    <td>40 - 49</td>
                                                    <td>0 - 39</td>
                                                </tr>
                                            </table>
                                    </small>

                                    </div>
                                    </div>



                            </center>
                        </div>

                        <!-- STUDENT PSYCHOMOTOR -->
                        <small>
                            <div class="row">
                                <div class="table-responsive mt-3 col-4">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>AFFECTIVE DOMAIN</th>
                                                <th colspan="2">RATING</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                                <tr v-for="psych in psych" :key="psych.id" >
                                                    <td>{{psych.psychomotor}}</td>
                                                    <td>{{psych.rating}}</td>
                                                    <td class="text-light distinction" v-if="psych.rating == 5">Excellent</td>
                                                    <td class="text-dark verygood" v-if="psych.rating == 4">Very good</td>
                                                    <td class="text-dark credit" v-if="psych.rating == 3">Satisfactory</td>
                                                    <td class="text-light pass" v-if="psych.rating == 2">Fair</td>
                                                    <td class="text-light fail" v-if="psych.rating == 1">Poor</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive mt-3 col-4">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th><center>RATING INDICES</center></th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                                <tr>
                                                    <td>
                                                        <p>5 - Maintains an Excellent degree of Observable traits</p>
                                                        <p>4 - Maintains an High Level of Observable traits</p>
                                                        <p>3 - Acceptable Level of Observable traits</p>
                                                        <p>2 - Shows Minimal regard for Observable traits</p>
                                                        <p>1 - Has No regard for Observable traits</p>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- </div> -->
                            <!-- STUDENT REMARK -->
                            <div class=" mt-3 col-6">
                                <h4>REMARKS</h4>
                                    <div class="form-group mb-2">
                                        <label for="my-input">
                                            Class Teacher Remark: <b>{{remark[0].teacher_remark}}</b>
                                        </label>

                                    </div>

                                    <div class="form-group">
                                        <label for="my-input">
                                            Principal Remark: <b>{{remark[0].principal_remark}}</b>
                                        </label>
                                    </div>
                            </div>
                            </div>
                        </small>
                        <!-- PERFORMANCE COMMENT -->
                        <small>
                            <div class="row" >
                                <table class="table table-bordered">
                                    <thead class="thead bg-dark">
                                        <tr>
                                            <td class="text-light">Subject</td>
                                            <td class="text-light">comment</td>
                                            <td class="text-light">Score</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!--
                                        <tr v-for="comment in comments" :key="comment.id">
                                            <td>{{comment.subjecttitle}}</td>
                                            <td>{{comment.teacher_remark}}</td>
                                        </tr>-->

                                        <tr v-for="comment in comments" :key="comment.id">
                                            <td>{{comment.subjecttitle}}</td>
                                            <td>{{comment.teacher_remark}}</td>
                                            <td>
                                                <small>
                                                    <table class="table">
                                                        <tr>
                                                            <td>C.A</td>
                                                            <td>EXAM</td>
                                                            <td>SCORE</td>
                                                            <td>CLASS AVG</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{comment.ca}}</td>
                                                            <td>{{comment.exam}}</td>
                                                            <td>{{comment.score}}</td>
                                                            <td>{{comment.avg}}</td>
                                                        </tr>
                                                    </table>
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                 <div class="table-responsive mt-3 col-12">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>PSYCHOMOTIVE DOMAIN</th>
                                                <th colspan="2">RATING</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr v-for="dom in domain" :key="dom.id" >
                                                    <td>{{dom.affective_domain}}</td>
                                                    <td>{{dom.rating}}</td>
                                                    <td class="text-light distinction" v-if="dom.rating == 5">Excellent</td>
                                                    <td class="text-dark verygood" v-if="dom.rating == 4">Very good</td>
                                                    <td class="text-dark credit" v-if="dom.rating == 3">Satisfactory</td>
                                                    <td class="text-light pass" v-if="dom.rating == 2">Fair</td>
                                                    <td class="text-light fail" v-if="dom.rating == 1">Poor</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </small>
                        <!--
                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4">
                                <p><b><i>
                                    {{principalOfficer[0].title}} {{principalOfficer[0].firstname}} {{principalOfficer[0].lastname}}<br>
                                        Principal
                                </i></b><br>
                                {{date}}
                                </p>
                            </div>
                        </div>
                        SIGN -->




                            </div>
                            <div class="card-footer">
                                <div id="print">
                                <h1 class="text-primary" @click.prevent="print">
                                    <i class="fas fa-print"></i>
                                </h1>
                            </div>
                            </div>
                        </div>
                        </div>

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
                printMode: false,
                viewAttendance:false,
                checkFilled:true,
                classroomgroups:null,
                classroomgroup:null,
                user:null,
                students:null,
                academicPeriods:null,
                resultMode:false,
                getResult:{
                    academicPeriodid:null,
                    classroom:null,
                    classgroup:null
                },
                totalScores:null,
                psych:null,
                remark:null,
                result:null,
                subjects:null,
                classid:null,
                resultProfile:null,
                principalOfficer:null,
                studentsCount:null,
                schoolProfile:{
                    schoolname:null,
                    total:null,
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
                    date:null
                },
                date:null,
                gpa:null,
                average:null,
                domain:null,
                comments:null,
                totalCredit:null,
                creditloadpoints:null,
                totalpoints:null

            }
    },
    computed: {
        scoreTotal() {
            const totalScores = []
            this.result.forEach(result => {
                if(result != ''){
                    totalScores.push(parseFloat(result[0].score_obtained)  + parseFloat(result[1].score_obtained) + parseFloat(result[2].score_obtained) + parseFloat(result[3].score_obtained))
                }
                    }
                );
            // add values in total score
            var overall = totalScores.reduce((a,b) => a + b, 0)
            var length = totalScores.length
            this.average = overall / length
        },

          scoreGPA() {
            const allGPA = []
            // get total load
            this.result.forEach(result => {
                if(result != ''){
                    allGPA.push(
                parseFloat(result[0].credit_load)
            )
                }

            });
            var totalGPA = allGPA.reduce((a,b) => a + b, 0)
            this.totalCredit = totalGPA

            const points = []
            // LOOP RESULTS
            this.result.forEach(res => {
                if(res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 70){
                    var loadvalue = []
                    loadvalue.push(parseFloat(res[0].credit_load) * 5)
                    points.push(loadvalue)
                }
                // b
                if(res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 60 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 70){
                    var loadvalue = []
                    loadvalue.push(parseFloat(res[0].credit_load) * 4)
                    points.push(loadvalue)
                }
                // c
                if(res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 50 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 6){
                    var loadvalue = []
                    loadvalue.push(parseFloat(res[0].credit_load) * 3)
                    points.push(loadvalue)
                }
                // d
                if(res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) >= 40 && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 5){
                    var loadvalue = []
                    loadvalue.push(parseFloat(res[0].credit_load) * 1)
                    points.push(loadvalue)
                }
                // f
                if(res != '' && parseFloat(res[0].score_obtained)  + parseFloat(res[1].score_obtained) + parseFloat(res[2].score_obtained) + parseFloat(res[3].score_obtained) < 40){
                    var loadvalue = []
                    loadvalue.push(parseFloat(res[0].credit_load) * 0)
                    points.push(loadvalue)
                }
            });

            this.creditloadpoints = points
            // sum all the values in creditloadpoints
            var totalpoints = []
            this.creditloadpoints.forEach(result => totalpoints.push(
                parseFloat(result[0])
            ));
            var calculateTotalGPA = totalpoints.reduce((a,b) => a + b, 0)
            this.totalpoints = calculateTotalGPA/this.totalCredit

            this.gpa = allGPA
        },
    },

    methods: {
        scoreTotal(){
            console.log('loop')
        },
        roundPoints(){
            const point= this.totalpoints
            // var strPoint = point.toString()
            // return strPoint.substring(0, 4)

        },
        checkInput(){},
        makeNull(){
            this.getClassRoomTeacher()
        },
        getStudentsInClass(){
           this.getSubjectGroups()
           this.getStudentsCount()
            axios.get('api/allstudentsclass/'+this.getResult.classroom).then((result) => {
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

        getClassRoomTeacher(){
            axios.get('api/classroom_teacher/'+this.user.id+'/'+this.getResult.classgroup).then((result) => {
                this.classroomgroups = result.data
            }).catch((err) => {

            });
        },

        getClassGroups(){
            axios.get('api/classroom_teacher/'+this.user.id).then((result) => {
                this.classroomgroup = result.data
            }).catch((err) => {

            });
        },

        getSubjectGroups(){
            axios.get('api/subjectGrpres/'+this.getResult.classgroup).then((result) => {
                this.subjects = result.data
            }).catch((err) => {

            });
        },

        getPrincipalOfficer(){
            axios.get('api/principalOfficer/'+this.user.branchid).then((result) => {
                this.principalOfficer = result.data
            }).catch((err) => {

            });
        },

         getStudentsCount(){
                    axios.get('api/studentscount/'+this.classroomgroups[0]['clsrmgpid']).then((result) => {
                        this.studentsCount = result.data
                    }).catch((err) => {

                    });
                },


        getStudentResult(studentid){
            for (const key in this.subjects) {
                if (Object.hasOwnProperty.call(this.subjects, key)) {
                    const element = this.subjects[key];
                    // alert(element.id)
                    var student_result = []

                    axios.get('api/result/'+studentid+'/'+this.getResult.academicPeriodid+'/'+element.id).then((result) => {
                        this.resultMode = true
                        student_result.push(result.data)
                        this.result = student_result
                        var student_profile = []


                        axios.get('api/result-profile/'+studentid+'/'+this.getResult.academicPeriodid+'/'+element.id).then((result) => {
                            student_profile.push(result.data)
                            this.resultProfile = student_profile

                        }).catch((err) => {

                        });
                    }).catch((err) => {
                    });
                }
            }
            this.getPsychoMotor(studentid)
            this.getRemarks(studentid)
            this.getAffectiveDomain(studentid)
            this.getComments(studentid, this.getResult.academicPeriodid )

        },


        getComments(studentid, periodid){
            axios.get('api/comment/'+periodid+'/'+studentid).then((result) => {
                this.comments = result.data
            }).catch((err) => {

            });

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

        getPsychoMotor(studentid){
            axios.get('api/psych/'+studentid+'/'+this.getResult.academicPeriodid).then((result) => {
                this.psych = result.data
            }).catch((err) => {

            });
        },

        getAffectiveDomain(studentid){
            axios.get('api/domain/'+studentid+'/'+this.getResult.academicPeriodid).then((result) => {
                this.domain = result.data
            }).catch((err) => {

            });
        },

        getRemarks(studentid){
            axios.get('api/remark/'+studentid+'/'+this.getResult.academicPeriodid).then((result) => {
                this.remark = result.data
            }).catch((err) => {

            });
        },

        getAcademicPeriod(){
            axios.get('api/period/'+this.user.branchid).then((result) => {
                this.academicPeriods = result.data
            }).catch((err) => {

            });
        },

        print(){
            var x = document.getElementById('print')
            x.style.display = "none"
            window.print()
        },

        getCurrentDate(){
            let today = new Date()
            let month = today.getMonth()
            let year = today.getFullYear()
            let date = today.getDate()
            let current_date = month+'/'+date+'/'+year

            this.date = current_date
            this.year = year
        },


        age(dob){
            let year = dob.substring(0,4).trim()
            let age = this.year - year

            return age
        }
    },

    created() {
        EventBus.$on('userData', user => {
            this.user = user
            this.getSchoolInfo()
            this.getPrincipalOfficer()
            this.getAcademicPeriod()
            this.getClassGroups()
            this.getCurrentDate()
         }
        )
    },

}
</script>

<style scoped>
    #printResult{
        display:none;
    }
    body{
        background-color: white;
        -webkit-print-color-adjust: exact;
    }
    .distinction{
    background-color: green;
    }
    .verygood{
    background-color: greenyellow;
    }
    .credit{
    background-color:cyan;
    }
    .pass{
    background-color: chocolate;
    }
    .fail{
    background-color: red;
    }

    #align{
        vertical-align: middle;
    }
    #school-name{
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    }
    .psyh{
        background-color: crimson;
        color: white;
    }
 @media print{
        #printResult{
        display:block;
    }
    .psyh{
        background-color: crimson !important;
        color: white !important;
    }
    .distinction{
    background-color: green !important;
    }
    .verygood{
    background-color: greenyellow !important;
    }
    .credit{
    background-color:cyan !important;
    }
    .pass{
    background-color: chocolate !important;
    }
    .fail{
    background-color: red !important;
    }
    #comment{
        background-color: black !important;
        color: white !important;
    }

    #subject{
        background-color: cadetblue !important;
    }
    body *{
        visibility: hidden;
        -webkit-print-color-adjust: exact;
        }

    #result, #result * {
        visibility: visible;
        -webkit-print-color-adjust: exact;

    }
    #result {
        position: absolute;
        left:0;
        top:0;
        right: 0;
        bottom:0;
        -webkit-print-color-adjust: exact;
        -webkit-print-color-adjust: exact;


    }
     #performance{
            page-break-after: always;
        }

    }
</style>
