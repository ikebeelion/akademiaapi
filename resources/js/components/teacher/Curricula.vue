<template>
    <div>
        <nav-bar/>
            <div class="content-body">
                <div class="container-fluid">
                    <div class="row page-titles mx-0">
                        <div class="col-sm-6 p-md-0">
                            <div class="welcome-text">
                                <h4>Upload Curricula</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><router-link to="/dashboard">Dashboards</router-link></li>
                                <li class="breadcrumb-item active"><a href="#">Upload Curricula</a></li>
                            </ol>
                        </div>
                    </div>

                        <!-- end row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Document</label>
                                            <input type="file" class="form-control" @click="pickFile">
                                        </div>
                                        <button class="btn btn-success mt-2 col-4" @click="uploadCurricula">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
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
import NavBar from '../NavBar.vue'
import { EventBus } from '../../app'
export default {
    components: {NavBar},
    data() {
        return {
            uploadedDoc:{document:null}
            }
    },

    methods: {
        pickFile(e){
                let file = e.target.files[0]
                let reader = new FileReader()
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.uploadedDoc.document = reader.result
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

        uploadCurricula(){
            axios.post('api/curricula/store', this.uploadedDoc).then((result) => {
                 swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Uploaded Successfully',
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
        }
        )
    },

}
</script>
