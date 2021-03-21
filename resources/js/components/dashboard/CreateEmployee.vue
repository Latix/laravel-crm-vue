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
                        <b-form-select v-model="selected_account_type" class="mb-3">
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Select an account type --</b-form-select-option>
                            </template>
                            <b-form-select-option value="Manager">Manager</b-form-select-option>
                            <b-form-select-option value="Employee">Employee</b-form-select-option>
                        </b-form-select>
                        <b-form-select v-model="selected_company" class="mb-3">
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Select a company --</b-form-select-option>
                            </template>
                            <b-form-select-option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</b-form-select-option>
                        </b-form-select>
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
            loading: false
        }
    },
    methods: {
        async handleCreateEmployee() {
            this.loading = true;
            let formData = new FormData();
            formData.append('company_id', this.selected_company);
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('account_type', this.selected_account_type);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirm);
            
            try {
                const response = await axios.post('user', formData);
                console.log(response);
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
                            message: response.data.message,
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
</style>
