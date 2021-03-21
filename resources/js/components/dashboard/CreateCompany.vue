<template>
    <div>
        <div id="heading" >
            <h1>Create Company</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Create Company</h3>
                    <form @submit.prevent="handleCreateCompany" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model.trim="$v.name.$model" placeholder="Name" />
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
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model.trim="$v.url.$model" placeholder="Url" />
                                <div class="error" v-if="!$v.url.required">Url field is required</div>
                            </div>
                        </div>
                        <div class="row company__logo">
                            <div class="custom-file">
                                <input type="file" accept="image/*" name="image" class="custom-file-input" id="validatedCustomFile" v-on:change="saveImage">
                                <label class="custom-file-label" for="validatedCustomFile">{{ !logo ? 'Choose file...' : logo.name }}</label>
                            </div>
                        </div>
                        <div class="error mt__10" v-if="!$v.logo.required">Logo field is required</div>
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
    name: 'CreateCompany',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirm: '',
            url: '',
            logo: '',
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
        url: {
            required
        },
        logo: {
            required
        }
    },
    methods: {
        async handleCreateCompany() {
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
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.password_confirm);
                formData.append('url', this.url);
                formData.append('logo', this.logo);

                try {
                    const response = await axios({
                        method: 'post',
                        url: 'company',
                        data: formData,
                        headers: {
                            Authorization: 'Bearer ' + this.user.token
                        }
                    });
                    
                    if (response.status == 201) {
                        Vue.$toast.open({
                            message: 'Company created',
                            type: 'success'
                        });

                        this.name               = '';
                        this.email              = '';
                        this.password           = '';
                        this.password_confirm   = '';
                        this.url                = '';
                        this.logo               = '';
                    } else {
                        Vue.$toast.open({
                            message: 'Company not created, try again!',
                            type: 'error'
                        });
                    }

                    this.loading = false;
                } catch (err) {
                    Vue.$toast.open({
                        message: 'Company not created, try again!',
                        type: 'error'
                    });
                    
                    this.loading = false;
                }

                this.submitStatus = 'PENDING'
                setTimeout(() => {
                    this.submitStatus = 'OK'
                }, 500)
            }
        },
        saveImage(e) {
            this.logo = e.target.files[0];
        }
    },
    computed: {
        ...mapGetters(['user'])
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

    .company__logo
    {
        margin-left: 0px;
        width: 100%;
    }
</style>
