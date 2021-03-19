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
                                <input type="email" class="mt--y10" v-model="email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password" placeholder="Password" />
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
    name: 'Login',
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        async handleLogin() {
            try {
                const response = await axios.post('auth/login', {
                    email: this.email,
                    password: this.password
                });
                
                localStorage.setItem('token', response.data.access_token);
                this.$store.dispatch('user', response.data.user);
                this.$router.push('/');
            } catch (e) {
                console.log();
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
