<template>
    <div>
        <div id="heading" >
            <h1>Create Company</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Create Company</h3>
                    <form @submit.prevent="handleCreateCompany" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="name"  placeholder="Name" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="email" class="mt--y10" v-model="email" placeholder="Email" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password" placeholder="Password" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password_confirm" placeholder="Password Confirmation" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="url" placeholder="Url" />
                            </div>
                        </div>
                        <div class="row company__logo">
                            <div class="custom-file">
                                <input type="file" accept="image/*" name="image" class="custom-file-input" id="validatedCustomFile" v-on:change="saveImage">
                                <label class="custom-file-label" for="validatedCustomFile">{{ !logo ? 'Choose file...' : logo.name }}</label>
                            </div>
                        </div>
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
            loading: false
        }
    },
    methods: {
        handleCreateCompany() {
            this.loading = true;
            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirm);
            formData.append('url', this.url);
            formData.append('logo', this.logo);

                axios({
                    method: "post",
                    url: "company",
                    data: formData,
                    headers: { 
                        "Content-Type": "multipart/form-data", 
                        "Authorization": 'Bearer ' + localStorage.getItem('token') 
                    },
                }).then((response) => {
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
            }).catch(error => {
                Vue.$toast.open({
                    message: 'Company not created, try again!',
                    type: 'error'
                });
                this.loading = false;
            });
        },
        saveImage(e) {
            this.logo = e.target.files[0];
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    mounted() {
        if (this.user.account_type !== "Admin"){
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
