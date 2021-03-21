<template>
    <div>
        <div id="heading" >
            <h1>Create Employee</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Create Employee</h3>
                    <form @submit.prevent="handleCreateEmployee">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model.trim="$v.name.$model"  placeholder="Name" />
                                <div class="error" v-if="!$v.name.required">Name field is required</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="email" class="mt--y10" v-model="email" placeholder="Email" />
                                <div class="error" v-if="!$v.email.required">Email field is required</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model.trim="$v.password.$model" placeholder="Password" />
                                <div class="error" v-if="!$v.password.required">Password field is required</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model.trim="$v.password_confirm.$model" placeholder="Password Confirmation" />
                                <div class="error" v-if="!$v.password_confirm.sameAsPassword">Passwords must be identical.</div>
                            </div>
                        </div>
                        <b-form-select v-model.trim="$v.selected_account_type.$model" class="mb-3">
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Select an account type --</b-form-select-option>
                            </template>
                            <b-form-select-option value="Manager">Manager</b-form-select-option>
                            <b-form-select-option value="Employee">Employee</b-form-select-option>
                        </b-form-select>
                        <div class="error" v-if="!$v.selected_account_type.required">Account type field is required</div>
                        <b-form-select v-model.trim="$v.selected_company.$model" class="mb-3">
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Select a company --</b-form-select-option>
                            </template>
                            <b-form-select-option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</b-form-select-option>
                        </b-form-select>
                        <div class="error" v-if="!$v.selected_company.required">Company field is required</div>
                        <div class="login__btn">
                            <button v-if="loading" class="button primary mt--y10" disabled>Submit<b-spinner class="ml-1" label="Busy"></b-spinner></button>
                            <button v-if="!loading" class="button primary mt--y10">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Vue from 'vue';
import {mapGetters} from 'vuex';
import { required, sameAs } from 'vuelidate/lib/validators';

export default {
    name: 'CreateEmployee',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirm: '',
            selected_account_type: null,
            selected_company: null,
            companies: [],
            submitStatus: null,
            loading: false
        }
    },
    validations: {
        name: {
            required
        },
        email: {
            required
        },
        password: {
            required,
        },
        password_confirm: {
            sameAsPassword: sameAs('password')
        },
        selected_account_type: {
            required
        },
        selected_company: {
            required
        }
    },
    methods: {
        async handleCreateEmployee() {
            this.$v.$touch();
            
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR';
                Vue.$toast.open({
                    message: 'Provide required fields!',
                    type: 'error'
                });
            } else {
                this.loading = true;
                
                let formData = new FormData();
                formData.append('company_id', this.selected_company);
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('account_type', this.selected_account_type);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.password_confirm);
                
                try {
                    const response = await axios({
                        method: 'post',
                        url: 'user',
                        data: formData,
                        headers: {
                            Authorization: 'Bearer ' + this.user.token
                        }
                    });
                    
                    if (this.password !== this.password_confirm){
                        Vue.$toast.open({
                            message: 'Password mismatch!',
                            type: 'error'
                        });
                    } else {
                        if (response.status == 201) {
                            Vue.$toast.open({
                                message: 'User created',
                                type: 'success'
                            });

                            this.name               = '';
                            this.email              = '';
                            this.password           = '';
                            this.password_confirm   = '';
                            this.selected_account_type = null;
                        } else {
                            Vue.$toast.open({
                                message: "User not created",
                                type: 'error'
                            });
                        }
                    }

                    this.loading = false;
                } catch(err) {
                    console.log(err);
                    Vue.$toast.open({
                        message: 'User not created, try again!',
                        type: 'error'
                    });
                    this.loading = false;
                };
            }
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    async created() {
        try {
            const response = await axios.get('company');
            this.companies = response.data.data;
        } catch (e) {}
    },
    mounted() {
        if (!this.user){
            this.$router.push('/login');
        }

        if (this.user.info.account_type !== "Admin"){
            this.$router.push('/');
        }
    }
}
</script>

<style scoped>
    .inner {
        margin: 0 auto;
        width: 35rem;
        max-width: calc(100% - 6rem);
    }
</style>
