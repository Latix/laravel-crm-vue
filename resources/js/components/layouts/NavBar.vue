<template>
    <div>
        <header id="header">
            <router-link class="logo" to="/">Crm-Vue</router-link>
            <nav>
                <router-link to="/">Home</router-link>
                <router-link to="/login">Login</router-link>
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
export default {
    name: 'NavBar'
}
</script>
