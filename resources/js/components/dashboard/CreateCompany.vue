<template>
    <div>
        <div id="heading" >
            <h1>Create Company</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <!-- <div class="alert alert-success">Company created</div> -->
                    <h3 class="login__btn">Create Company</h3>
                    <form @submit.prevent="handleCreateCompany" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="name"  placeholder="Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="email" class="mt--y10" v-model="email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password" placeholder="Password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password_confirm" placeholder="Password Confirmation" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="url" placeholder="Url" />
                            </div>
                        </div>
                        <div class="row company__logo">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="validatedCustomFile" v-on:change="saveImage">
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            </div>
                        </div>
                        <div class="login__btn">
                            <button class="button primary mt--y10">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
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
            logo: ''
        }
    },
    methods: {
        handleCreateCompany() {
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
                    console.log(response);
                    if (response.status == 201) {
                        this.$utils.showSuccess('success', "Company created!");
                    } else {
                        this.$utils.showError('error', "Company not created!");
                    }
            }).catch(error => {
                this.$utils.showError('error', "There was an error");
                console.log();
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
