<template>
    <div>
        <div id="heading" >
            <h1>Edit Company</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Edit Company</h3>
                    <form @submit.prevent="handleUpdateCompany" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="name" required />
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
                                <input type="text" class="mt--y10" v-model="url" placeholder="Url" required />
                            </div>
                        </div>
                        <div class="row company__logo">
                            <div class="custom-file">
                                <input type="file" accept="image/*" name="image" class="custom-file-input" id="validatedCustomFile" v-on:change="saveImage">
                                <label class="custom-file-label" for="validatedCustomFile">{{ !logo ? 'Choose file...' : logo.name }}</label>
                            </div>
                        </div>
                        <div class="login__btn">
                            <button v-if="loading" class="button primary mt--y10" disabled>Update<b-spinner class="ml-1" label="Busy"></b-spinner></button>
                            <button v-if="!loading" class="button primary mt--y10">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Vue from 'vue';
export default {
    name: 'EditCompany',
    data() {
        return {
            id: this.$route.params.id,
            name: '',
            password: '',
            password_confirm: '',
            url: '',
            logo: '',
            loading: false
        }
    },
    methods: {
        handleUpdateCompany() {
            this.loading = true;
            let formData = new FormData();
            formData.append("_method", 'PATCH');
            formData.append('name', this.name);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirm);
            formData.append('url', this.url);
            formData.append('logo', this.logo);

                axios({
                    method: "post",
                    url: "company/"+this.id,
                    data: formData,
                    headers: { 
                        "Content-Type": "multipart/form-data", 
                        "Authorization": 'Bearer ' + localStorage.getItem('token') 
                    },
                }).then((response) => {
                    if (response.data.status == 200) {
                        Vue.$toast.open({
                            message: 'Company updated',
                            type: 'success'
                        });
                    } else {
                        Vue.$toast.open({
                            message: 'Company not updated, try again!',
                            type: 'error'
                        });
                    }

                this.loading = false;
            }).catch(error => {
                Vue.$toast.open({
                    message: 'Company not updated, try again!',
                    type: 'error'
                });
                this.loading = false;
            });
        },
        saveImage(e) {
            this.logo = e.target.files[0];
        }
    },
    async created() {
        const response = await axios.get('company/'+this.id);
        var company    = response.data.data;
        this.name      = company.name;
        this.url       = company.url;
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
