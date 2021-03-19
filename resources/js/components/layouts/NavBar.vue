<template>
    <div>
        <header id="header">
            <router-link class="logo" to="/">Crm-Vue</router-link>
            <nav>
                <a v-if="user" href="javascript:void(0)">Hello, {{ user.name }}</a>
                <router-link to="/">Home</router-link>
                <router-link v-if="!user" to="/login">Login</router-link>
                <a v-if="user" href="javascript:void(0)"  @click="handleLogout">Logout</a>
                <!-- <a class="btn btn-secondary dropdown-toggle nav__dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Settings
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div> -->
            </nav>
            <!-- <div class="nav__menu">
                <router-link class="nav__menu_item" to="/">Home</router-link>
            </div> -->
        </header>
        <!-- <nav id="menu">
            <ul class="links">
                <li><router-link class="logo" to="/">Home</router-link></li>
                <li><router-link class="logo" to="/login">Login</router-link></li>
            </ul>
        </nav> -->
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
          }
        },
        computed: {
          ...mapGetters(['user'])
        },
    }
</script>
