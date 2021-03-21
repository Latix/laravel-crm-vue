<template>
    <div>
        <header id="header">
            <router-link class="logo" to="/">Crm-Vue</router-link>
            <nav>
                <a v-if="user" href="javascript:void(0)">Hello {{ user.info.name }},</a>
                <router-link class="desktop__nav_link" to="/">Home</router-link>
                <router-link class="desktop__nav_link" to="/">Companies</router-link>
                <router-link class="desktop__nav_link" v-if="user && user.info.account_type == 'Admin'" to="/company/create">Create Company</router-link>
                <router-link class="desktop__nav_link" v-if="user && user.info.account_type == 'Admin'" to="/employee/create">Create Employee</router-link>
                <router-link class="desktop__nav_link" v-if="user && user.info.account_type == 'Manager'" :to="'/company/employees/'+user.info.company_id">Employees</router-link>
                <router-link class="desktop__nav_link" v-if="user" to="/profile">Profile</router-link>
                <router-link v-if="!user" to="/login">Login</router-link>
                <a class="desktop__nav_link" v-if="user" href="javascript:void(0)" @click="handleLogout">Logout</a>
                <b-button v-b-toggle.sidebar-variant class="toggle__MenuButton mobile__nav">Menu</b-button>
                <b-sidebar id="sidebar-variant" title="Crm-Vue" bg-variant="dark" text-variant="light" shadow>
                <div class="py-2">
                    <nav class="mb-3">
                        <b-nav vertical>
                            <b-nav-item to="/">Home</b-nav-item>
                            <b-nav-item to="/">Companies</b-nav-item>
                            <b-nav-item v-if="user && user.info.account_type == 'Admin'" to="/company/create">Create Company</b-nav-item>
                            <b-nav-item v-if="user && user.info.account_type == 'Admin'" to="/employee/create">Create Employee</b-nav-item>
                            <b-nav-item v-if="user && user.info.account_type == 'Manager'" :to="'/company/employees/'+user.info.company_id">Employees</b-nav-item>
                            <b-nav-item v-if="user" to="/profile">Update Profile</b-nav-item>
                            <b-nav-item v-if="!user" to="/login">Login</b-nav-item>
                            <b-nav-item v-if="user" href="javascript:void(0)" @click="handleLogout">Logout</b-nav-item>
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
                this.$store.dispatch('user', null);
                this.$router.push('/login');
            },
        },
        computed: {
          ...mapGetters(['user'])
        }
    }
</script>
