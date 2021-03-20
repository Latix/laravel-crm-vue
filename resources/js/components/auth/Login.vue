<template>
    <div>
        <div id="heading" >
            <h1>Access Control</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Login</h3>
                    <form @submit.prevent="handleLogin">
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
                        <div class="login__btn">
                            <button v-if="loading" class="button primary mt--y10" disabled>Login<b-spinner class="ml-1" label="Busy"></b-spinner></button>
                            <button v-if="!loading" class="button primary mt--y10">Login</button>
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
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            loading: false
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            try {
                const response = await axios.post('auth/login', {
                    email: this.email,
                    password: this.password
                });
                if (response.status == 200) {
                    localStorage.setItem('token', response.data.access_token);
                    this.$store.dispatch('user', response.data.user);
                    this.$router.push('/');
                } else {
                    Vue.$toast.open({
                        message: 'Invalid credentials, try again!',
                        type: 'error'
                    });
                } 
                this.loading = false;
            } catch (e) {
                Vue.$toast.open({
                    message: 'Invalid credentials, try again!',
                    type: 'error'
                });
                this.loading = false;
            }
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    mounted() {
        if (this.user){
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
