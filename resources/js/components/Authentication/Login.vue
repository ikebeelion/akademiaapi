<template>
<body>
    <div class="container">
            <center>
                <img class="Akalogo" src="images/logo.png">
                <h1>Welcome To Akademia</h1>
                <p class="mb-2">Welcome Back! please enter your details</p>
            </center>
            <!-- </div> -->

            <div class="main">
            <p class="text-danger">{{errors}}</p>
                <form action="">
                    <span>
                        <i></i>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">

                            <g id="vuesax_bulk_profile" data-name="vuesax/bulk/profile" transform="translate(-108 -252)">
                            <g id="profile">
                                <path id="Vector" class="cls-1" d="M4.75,0a4.746,4.746,0,0,0-.12,9.49.807.807,0,0,1,.22,0h.07A4.746,4.746,0,0,0,4.75,0Z" transform="translate(115.25 254)"/>
                                <path id="Vector-2" data-name="Vector" class="cls-2" d="M12.12,1.395a9.929,9.929,0,0,0-10.15,0A3.947,3.947,0,0,0,0,4.625a3.914,3.914,0,0,0,1.96,3.21,9.239,9.239,0,0,0,5.08,1.41,9.239,9.239,0,0,0,5.08-1.41,3.945,3.945,0,0,0,1.96-3.23A3.937,3.937,0,0,0,12.12,1.395Z" transform="translate(112.96 264.755)"/>
                                <path id="Vector-3" data-name="Vector" class="cls-3" d="M0,0H24V24H0Z" transform="translate(108 252)"/>
                            </g>
                            </g>
                        </svg>

                        <input type="text" placeholder="Username" name="" v-model="logindata.username" @input="checkInput">
                    </span><br>
                    <span>
                        <i></i>
                        <svg xmlns="http://www.w3.org/2000/svg" width="28.285" height="28.285" viewBox="0 0 28.285 28.285">
                            <g id="vuesax_bulk_key" data-name="vuesax/bulk/key" transform="translate(-681.858 -185.863)">
                            <g id="key">
                                <path id="Vector" class="cls-1" d="M17.793,2.213A7.577,7.577,0,0,0,5.2,9.813l-4.7,4.7A2.015,2.015,0,0,0,.013,16l.3,2.18a1.888,1.888,0,0,0,1.5,1.5l2.18.3a1.943,1.943,0,0,0,1.49-.5l.82-.82a.5.5,0,0,0,0-.71l-1.94-1.94a.75.75,0,0,1,1.06-1.06l1.95,1.95a.5.5,0,0,0,.7,0l2.12-2.11a7.568,7.568,0,0,0,7.6-12.58ZM12.5,9.993a2.5,2.5,0,1,1,2.5-2.5A2.5,2.5,0,0,1,12.5,9.993Z" transform="translate(681.858 200.009) rotate(-45)"/>
                                <path id="Vector-2" data-name="Vector" class="cls-2" d="M5.606,2.8A2.8,2.8,0,1,1,2.8,0,2.8,2.8,0,0,1,5.606,2.8Z" transform="translate(693.394 193.394)"/>
                                <path id="Vector-3" data-name="Vector" class="cls-3" d="M0,0H24V24H0Z" transform="translate(684 188)"/>
                            </g>
                            </g>
                        </svg>

                        <input type="password" placeholder="Password" name="" v-model="logindata.password" @input="checkInput">
                    </span>


                    <div class="login"> <p>Forgot Password ?</p>
                        <button :disabled="checkFilled" @click.prevent="login">Login</button>       </div>

                </form>
            </div>


            <div class="fotter">
                <p class="cr">Don't have an account? <router-link to="/register"  class="fw-medium text-primary"> Signup now </router-link></p>
                <h6 class="cr1">© 2022 Akademia. Product by Next-It Services</h6>
            </div>
    </div>
</body>
</template>

<script>
import FooterAuth from './Footer-Auth.vue'
import axios from 'axios'
export default {
    components: {FooterAuth},

    data() {
        return {
            checkFilled:true,
            rememberme:false,
            logindata: {
                username:null,
                password:null,
            },
            errors:null
        }
    },

    methods: {
        checkInput(){
            this.errors = null
            if(this.logindata.username != null && this.logindata.password != null){
                this.checkFilled = false
            }else{
                this.checkFilled = true
            }
        },
        login(){
            axios.post('api/login', this.logindata).then((result) => {
                // this.$router.push({name: 'Dashboard'})
                window.location.href = '/dashboard'

            }).catch((err) => {
                this.errors = err.response.data.errors[0][0]
                });
        }

    },

}
</script>

<style scoped>
                            .cls-1 {
                              fill: #8587dc;
                              opacity: 0.4;
                            }

                            .cls-2 {
                              fill: #200e32;
                            }

                            .cls-3 {
                              fill: none;
                              opacity: 0;
                            }
                             .cls-1 {
                              fill: #8587dc;
                              opacity: 0.4;
                            }

                            .cls-2 {
                              fill: #200e32;
                            }

                            .cls-3 {
                              fill: none;
                              opacity: 0;
                            }
                            * {
                            margin: 0;
                            padding: 0;
                            text-decoration: none;
                            box-sizing: border-box;
                            transition: all 0.3s ease-in;
                            }

body {
  min-height: 100vh;
  font-family: "PT Sans";
background: url("/images/login.png");
  overflow: hidden;
  font-size: 13px;
  background-size: cover;
}

.container {
  width: 520px;
  margin: 10% auto;
  background: #ffffff;
  border: 9px solid #8587dc;
  padding: 20px 0px;
  border-radius: 50px;
}
.container img {
  width: 150px;
  margin-bottom: 10px;
}
.header {
  text-align: center;
  padding-bottom: 50px;
  padding-top: 20px;
}

.header h1 {
  font-size: 35px;
  letter-spacing: 2px;
  font-family: "Playfair Display";
  margin-bottom: 20px;
}
.header p {
  letter-spacing: 1px;
  font-family: "PT Sans";
  color: #424242;
}

.main {
  text-align: center;
}

.main input {
  width: 400px;
  height: 50px;
  padding-left: 55px;
  border-radius: 10px;
  background-color: #dddddd;
  border: none;
  outline: none;
  box-sizing: border-box;
  font-size: 15px;
  font-family: "PT Sans";
  margin-bottom: 30px;
}

.main span {
  position: relative;
}
.main svg {
  position: absolute;
  width: 25px;
  left: 15px;
  top: -5px;
}

.main input:hover {
  border: 2.5px solid #8587dc;
}

.login {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0px 60px 0px 60px;
}

.login button {
  padding: 15px 40px 15px 40px;
  border-radius: 10px;
  background-color: #8587dc;
  color: white;
  border: none;
  outline: none;
  box-shadow: 1px 1px 3px black;
}

.login button:hover {
  background-color: #200e32;
}

.fotter {
  text-align: center;
  padding-bottom: 0px;
  padding-top: 40px;
}

.cr {
  padding-bottom: 60px;
}
.fotter .cr1 {
  font-size: 12px;
  letter-spacing: 1px;
  color: rgb(121, 121, 121);
}

@media screen and (max-width: 926px) {
  body {
    background: white;
    overflow: hidden;
  }

  .container {
    width: 100%;
    margin: 10% auto;
    background: #ffffff;
    border: none;
    padding: 20px 0px;
    border-radius: 50px;
    padding-left: 5px;
    padding-right: 5px;
  }
  .login {
    padding: 0px 100px 0px 100px;
  }
}

@media screen and (max-width: 335px) {
  .main input {
    width: 320px;
  }
}

</style>

