<template>
    <div>
        <template>
            <img src="https://flagsapi.com/UA/flat/64.png" alt="flag">
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <h2>Registration App</h2>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-autocomplete
                            v-model="selectedCountry"
                            :items="countries"
                            label="Country"
                            filled
                            rounded
                            item-text="name"
                            @change="updatePhoneNumberPrefix"
                        >
                            <template v-slot:item="{ item }">
                                <v-row align="center">
                                    <v-icon style="width: 40px">{{ item.flag }}</v-icon>
                                    <img :src="'https://flagsapi.com/'+item.flag+'/flat/64.png'" alt="Flag icon"
                                         class="ml-2">
                                    <span class="ml-2">{{ item.name }}</span>
                                </v-row>
                            </template>
                        </v-autocomplete>
                        <div v-if="errorSelectedCountry"><v-progress-circular color="primary" indeterminate></v-progress-circular>
                            Please select the Country
                        </div>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="fullName"
                            label="FullName"
                            filled
                            rounded
                            @change="errorFullName = false"
                        ></v-text-field>
                        <div v-if="errorFullName"><v-progress-circular color="primary" indeterminate></v-progress-circular>
                            Please fill your name
                        </div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="phoneNumber"
                            :label="'Phone number'"
                            filled
                            rounded
                            maxlength="19"
                            :disabled="!selectedCountry"
                            v-mask="['+### ## ###-##-##']"
                            @change="errorPhoneNumber = false"
                        ></v-text-field>
                        <div v-if="errorPhoneNumber"><v-progress-circular color="primary" indeterminate></v-progress-circular>
                            Please fill your Phone Number
                        </div>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="email"
                            label="Email"
                            filled
                            rounded
                            type="email"
                           @change="errorEmail = false"
                            @blur="validateEmail"
                        ></v-text-field>
                        <div v-if="errorEmail"><v-progress-circular color="primary" indeterminate></v-progress-circular>
                            Please enter valid email
                        </div>
                    </v-col>
                </v-row>
                <div class="text-center">
                    <v-btn variant="tonal" @click="submitRegistration" >
                        Submit
                    </v-btn>
                </div>
                <v-data-table
                    :items="users"
                    hide-default-footer
                >
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.phone_book.phone_number }} </td>
                            <td>{{ item.user_country.country }}</td>
                        </tr>
                    </template>
                </v-data-table>
            </v-container>
        </template>
        <div class="card">

        </div>
    </div>

</template>

<script>
import {mask} from 'vue-the-mask';
import Swal from 'sweetalert2'

export default {
    name: "RegistrationComponent",
    directives: {mask},
    data() {
        return {
            selectedCountry: null,
            users:[],
            countries: [],
            fullName: '',
            email: '',
            phoneNumber: '',
            phoneNumberPrefix: '',
            errorFullName:null,
            errorEmail:null,
            errorPhoneNumber:null,
            errorSelectedCountry:null
        };
    },
    methods: {
        fetchCountries() {
            console.log('starting')
            axios.get('/get-countries')
                .then(response => {
                    this.countries = response.data
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        getUsers(){
            axios.get('/get-users')
                .then(response => {
                    this.users = response.data
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        updatePhoneNumberPrefix() {
            this.errorSelectedCountry = null;
            this.phoneNumber = this.countries.find(country => country.name === this.selectedCountry).idd;
        },
        submitRegistration() {
            if(!this.selectedCountry){
                this.errorSelectedCountry = true;
            }
            if(!this.fullName){
                this.errorFullName = true;
            }
            if(!this.email){
                this.errorEmail = true;
            }
            if(!this.phoneNumber || this.phoneNumber.length < 5){
                this.errorPhoneNumber = true;
            }
            const user = {
                selectedCountry: this.selectedCountry,
                fullName: this.fullName,
                email: this.email,
                phoneNumber: this.phoneNumber,
            }
            if (!user.selectedCountry || !user.fullName || !user.email || !user.phoneNumber || user.phoneNumber.length < 5) {
                Swal.fire({
                    title: "Not completed",
                    text: "Please fill all fields",
                    icon: "info",
                    showConfirmButton: false,
                    timer: 1500
                })
                return;
            }
            axios.post('/register', user)
                .then((response) => {
console.log(response)
                    if (response.data.includes('Integrity constraint violation')) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'User with this email already has been registered',
                            icon: 'error',
                            confirmButtonText: 'Got it'
                        })
                    } else {
                        Swal.fire({
                            title: 'Succes!',
                            text: 'User registered',
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        })
                    }
                    this.selectedCountry = null;
                    this.fullName = null;
                    this.email = null;
                    this.phoneNumber = null;

                    this.getUsers()
                })
                .catch(error => {
                    console.error('Error:', error)
                });

        },
        validateEmail() {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
                this.errorEmail = false;
            } else {
                this.errorEmail = true;
            }
        }

    },
    mounted() {
        this.fetchCountries();
        this.getUsers()
    },
    created() {
    },
    computed: {},
}
</script>

<style lang="scss">

</style>
