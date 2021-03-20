<template>
    <div>
        <header id="header">
            <router-link class="logo" to="/">Crm-Vue</router-link>
            <nav>
                <a v-if="user" href="javascript:void(0)">Hello, {{ user.name }}</a>
                <router-link to="/">Home</router-link>
                <!-- <b-icon-power v-if="user"  @click="handleLogout">Logout</b-icon-power> -->
                <b-button v-b-toggle.sidebar-variant class="toggle__MenuButton">Menu</b-button>
                <b-sidebar id="sidebar-variant" title="Crm-Vue" bg-variant="dark" text-variant="light" shadow>
                <div class="py-2">
                    <nav class="mb-3">
                        <b-nav vertical>
                            <b-nav-item to="/">Home</b-nav-item>
                            <b-nav-item v-if="user && user.account_type == 'Admin'" to="/company/create">Create Company</b-nav-item>
                            <b-nav-item v-if="user && user.account_type == 'Admin'" to="/employee/create">Create Employee</b-nav-item>
                            <b-nav-item v-if="user && user.account_type == 'Admin'" to="/employee/create">Employees</b-nav-item>
                            <b-nav-item v-if="!user" to="/login">Login</b-nav-item>
                            <b-nav-item v-if="user" href="javascript:void(0)"  @click="handleLogout">Logout</b-nav-item>
                        </b-nav>
                    </nav>
                </div>
                </b-sidebar>
            </nav>
        </header>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: 'NavBar',
        methods: {
            handleLogout() {
                localStorage.removeItem('token');
                axios.post('auth/logout');
                this.$store.dispatch('user', null);
                this.$router.push('/login');
            },
        },
        computed: {
          ...mapGetters(['user'])
        },
    }
</script>
