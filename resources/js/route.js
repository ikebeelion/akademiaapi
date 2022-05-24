import VueRouter from "vue-router"
import Login from './components/Authentication/Login.vue'
import SchoolRegister from './components/Authentication/SchoolRegister.vue'
import Dashboard from './components/Dashboard.vue'
import NavBar from './components/NavBar.vue'
import Priviledge from './components/akademia/Priviledges.vue'
import Branches from './components/school/Branches.vue'
import ClassGroups from './components/school/Classgroup.vue'
import Classroom from './components/school/Classroom.vue'
import ClassroomGroup from './components/school/ClassRoomGroup.vue'
import StudentProfile from './components/student/Profile.vue'
import CSC from './components/akademia/CountryStateCity.vue'
import ParentProfile from './components/parent/Profile.vue'
import StudentDetail from './components/student/StudentDetails.vue'
import Subject from './components/school/Subject.vue'
import SubjectGroup from './components/school/SubjectGroup.vue'
import SchoolProfile from './components/school/Profile.vue'
import Rank from './components/school/Rank.vue'
import Staff from './components/teacher/Profile.vue'
import MyClassroom from './components/teacher/Classroom.vue'
import MyClass from './components/teacher/MyClass.vue'
import Attendance from './components/teacher/Attendance.vue'
import Assignment from './components/teacher/Assignment.vue'
import Curricula from './components/teacher/Curricula.vue'
import Timeline from './components/school/Timeline.vue'
import ResultType from './components/school/ResultType.vue'
import Result from './components/teacher/Result.vue'
import Psychomotor from './components/school/Psychomotor.vue'
import AffectieDomain from './components/school/AffectiveDomain.vue'
import Myresult from './components/student/Result.vue'
import Wardresult from './components/parent/Result.vue'
import Timetable from './components/school/Timetable.vue'
import Messages from './components/school/Messages.vue'
import Payment from './components/school/Payment.vue'
import Store from './components/school/Store.vue'
import Expenditure from './components/school/Expenditure.vue'
import ExpType from './components/school/Expendituretype.vue'
import PaymentType from './components/school/Payment_type.vue'
import TimeTableView from './components/student/viewtable.vue'
import WardTimeTable from './components/parent/viewtable.vue'
import TimeTableRequests from './components/school/ApproveTable.vue'
let routes = [
    { path: '/register', component:SchoolRegister, name:'SchoolRegister'},
    { path: '/', component:Login, name:'login'},
    {
        path: '/dashboard',
        component: Dashboard,
        name:'Dashboard',
    },
    {
        path: '/subjects',
        component: Subject,
        name:'Subject',

    },
    {
        path: '/staff',
        component: Staff,
        name:'Staff',
    },

    {
        path: '/subjectgroup',
        component: SubjectGroup,
        name:'SubjectGroup',

    },
    { path: '/nav', component: NavBar, name:'NavBar'},
    {   path: '/priviledge',
        component: Priviledge,
        name:'Priviledge',

    },
    {
        path: '/profile',
        component: SchoolProfile,
        name:'SchoolProfile',
    },
    {   path: '/rank',
        component: Rank,
        name:'Rank',
        },
    {   path: '/branches',
        component: Branches,
        name:'Branches',
    },
    {   path: '/classgroups',
        component: ClassGroups,
        name:'Classgroups',
    },
    {   path: '/classroom',
        component: Classroom,
        name:'Classroom',
    },
    {   path: '/classroomgroup',
        component: ClassroomGroup,
        name:'ClassroomGroup',
    },
    {   path: '/studentprofile',
        component: StudentProfile,
        name:'StudentProfile',
    },
    {   path: '/studentdetail',
        component: StudentDetail,
        name:'StudentDetail',
        props:true,
    },
    {
        path: '/csc',
        component: CSC,
        name:'CSC'
    },
    {
        path: '/parentprofile',
        component: ParentProfile,
        name:'ParentProfile',
    },
    {   path: '/classroom-mgt',
        component: MyClassroom,
        name:'MyClassroom',
        },
    {   path: '/myclass',
        component: MyClass,
        name:'MyClass',
    },
    {   path: '/attendance',
        component: Attendance,
        name:'Attendance',
    },
    {
        path: '/assignment',
        component: Assignment,
        name:'Assignment',
    },
    {
        path: '/curricula',
        component: Curricula,
        name:'Curricula',
    },
    {
        path: '/timeline',
        component: Timeline,
        name:'Timeline'
    },
    {
        path: '/result-type',
        component: ResultType,
        name:'ResultType'
    },
    {
        path: '/result',
        component: Result,
        name:'Result'
    },
    {
        path: '/psychomotor',
        component: Psychomotor,
        name:'Psychomotor'
    },
    {
        path: '/affectivedomain',
        component: AffectieDomain,
        name:'AffectieDomain'
    },
    {
        path: '/myresult',
        component: Myresult,
        name:'Myresult'
    },
    {
        path: '/wardresult',
        component: Wardresult,
        name:'Wardresult'
    },
    {
        path: '/timetable',
        component: Timetable,
        name:'Timetable'
    },
    {
        path: '/sendmessages',
        component: Messages,
        name:'Messages'
    },
    {
        path: '/payments',
        component: Payment,
        name:'Payments'
    },
    {
        path: '/store',
        component: Store,
        name:'Store'
    },
    {
        path: '/expenditure',
        component: Expenditure,
        name:'Expenditure'
    },
    {
        path: '/exptype',
        component: ExpType,
        name:'ExpType'
    },
    {
        path: '/payment-type',
        component: PaymentType,
        name:'PaymentType'
    },
    {
        path: '/viewtable',
        component: TimeTableView,
        name: 'TimeTableView'
    },
    {
        path: '/wardtimetable',
        component: WardTimeTable,
        name: 'WardTimeTable'
    },
    {
        path: '/timetablerequests',
        component: TimeTableRequests,
        name: 'TimeTableRequests'

    }


]

const router = new VueRouter({
    routes: routes,
    mode: "history",
    linkActiveClass: 'active'
})





export default router
