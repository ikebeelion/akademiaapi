<template>
       <div>
        <nav-bar/>
              <div class="content-body">
                    <div class="container-fluid">
                        <div class="row">
                        </div>
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
         </div>

</template>

<script>
import FooterBar from './Footer.vue'
import NavBar from './NavBar.vue'
import axios from 'axios'
export default {
    components: {FooterBar, NavBar},
    methods: {
         getAuth(){
            axios.get('api/authenticated').then(()=>{

            }).catch(()=>{
                window.location.href = '/'
            })
        },
    },
    created() {
        // this.getAuth()
    },
}

</script>
