<template>
    <div>
        <div id="heading" >
            <h1>Update Profile</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Update Profile</h3>
                    <form @submit.prevent="handleUpdateUser">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="name"  placeholder="Name" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password" placeholder="New Password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password_confirm" placeholder="Confirm New Password" />
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
    name: 'Profile',
    data() {
        return {
            name: '',
            password: '',
            password_confirm: '',
            loading: false
        }
    },
    methods: {
        handleUpdateUser() {
            this.loading = true;
            let formData = new FormData();
            formData.append("_method", 'PATCH');
            formData.append('name', this.name);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirm);

                axios({
                    method: "post",
                    url: "user/"+this.user.id,
                    data: formData,
                    headers: { 
                        "Authorization": 'Bearer ' + localStorage.getItem('token') 
                    },
                }).then((response) => {
                    if (this.password !== this.password_confirm){
                        Vue.$toast.open({
                            message: 'Password mismatch!',
                            type: 'error'
                        });
                    } else {
                        if (response.status == 200) {
                            Vue.$toast.open({
                                message: 'User updated!',
                                type: 'success'
                            });

                            this.$store.dispatch('user', response.data.user);
                            
                        } else {
                            Vue.$toast.open({
                                message: response.data.message,
                                type: 'error'
                            });
                        }
                    }

                this.loading = false;
            }).catch(error => {
                console.log(error.response.data);
                Vue.$toast.open({
                    message: 'User not updated, try again!',
                    type: 'error'
                });
                this.loading = false;
            });
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    mounted() {
        if (!this.user){
            this.$router.push('/login');
        }
        
        this.name = this.user.name;
        if (!this.user){
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
