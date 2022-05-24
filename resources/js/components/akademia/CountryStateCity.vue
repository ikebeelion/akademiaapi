<template>
    <div class="container col-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ADD COUNTRY</h5>
        <div class="form-group">
            <label for="">Country</label>
            <input type="text" v-model="createCountry.country" class="form-control" required>
        </div>
        <button type="submit" class="mt-2 btn btn-success" @click.prevent="addCountry">Add Country</button>

        </div>
    </div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Add State</h5>
        <div class="form-group">
            <label>Country</label>
            <select v-model="createState.countryid" class="form-control" >
                <option>Select</option>
                <option v-for="country in countries" :key="country.id" :value="country.id">{{country.country}}</option>
            </select>
        </div>

        <div class="form-group">
        <label for="">State</label>
        <input type="text" v-model="createState.state" class="form-control" required>
        </div>
        <button class="mt-2 btn btn-success" type="submit" @click.prevent="addState">Add State</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Add City</h5>
        <div class="form-group">
            <label for="">State</label>
            <select v-model="createCity.stateid" class="form-control">
                <option>Select</option>
                <option v-for="state in states" :key="state.id" :value="state.id">{{state.state}}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="">City</label>
            <input class="form-control" type="text" v-model="createCity.city" required>
        </div>
        <button type="submit" class="mt-2 btn btn-success " @click.prevent="addCity">Add City </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Add Role</h5>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" v-model="createRole.role" class="form-control">
        </div>
        <button class="mt-2 btn btn-success" @click="addRole">Add Role</button>
    </div>
</div>

<div>
</div>


    </div>
</template>

<script>
import { EventBus } from '../../app'

export default {
    data() {
        return {
            checkFilled:true,
            countries:{},
            states:{},
            createState: {
                countryid:null,
                state:null
            },
            createCountry: {country:null},
            createCity:{
                stateid:null,
                city:null
            },
            msg:false,
            createRole: {
                role:null
            }

        }
    },

    methods: {
        getCountry(){
            axios.get('api/country').then((result) => {
                this.countries = result.data
            }).catch((err) => {

            });
        },

        getState(){
            axios.get('api/state').then((result) => {
                this.states = result.data
            }).catch((err) => {

            });
        },

        addCountry(){
            axios.post('api/country/store', this.createCountry).then((result) => {
                this.msg = 'Country Added'
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Country Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
                EventBus.$emit('crud')
            }).catch((err) => {

            });
        },

        addState(){
            axios.post('api/state/store', this.createState).then((result) => {
                this.msg = 'State Creation Successful'
                EventBus.$emit('crud')
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'State Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                    swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'state not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },

        addCity(){
            axios.post('api/city/store', this.createCity).then((result) => {
                this.msg = 'City Creation Successful'
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'City Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            }).catch((err) => {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'City not Added',
                    customClass: 'swal-wide',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        },
        addRole(){
            axios.post('api/role/store', this.createRole).then((result) => {
                  swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Role Added',
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
        this.getState()
        EventBus.$on('crud', ()=>{
            this.getCountry()
            this.getState()
        })
    },

}
</script>
