import Vue from 'vue';
import VueRouter from 'vue-router'
import router from './route'
// import JlDatatable from 'jl-datatable'
require('./bootstrap');
window.Vue = require('vue').default;
// Vue.use(BootstrapVue)

// app.component('jl-datatable', JlDatatable)
import VueQuillEditor from 'vue-quill-editor'

// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(VueQuillEditor, /* { default global options } */)


import swal from 'sweetalert2'
window.swal = swal
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', toast.addEventListener('mouseleave'))
    }
})

export const EventBus = new Vue()
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router
});
