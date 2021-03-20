<template>
    <div>
        <section id="banner">
            <div class="inner">
                <h1 v-if="!user">CRM-VUE</h1>
                <h2 v-if="user">{{ user.account_type }} Dashboard</h2>
                <p>Company / Employee Management System<br /></p>
            </div>
            <video autoplay loop muted playsinline :src="image_src"></video>
        </section>
        <section class="wrapper">
            <div class="inner">
                <header class="special">
                    <h2>Company Relationship Management</h2>
                    <p>Stay aware and in control of your company and employees.</p>
                    <hr />
                    <Companies :user="user" />
                </header>
            </div>
        </section>
    </div>
</template>

<script>
    import Companies from './partials/Companies';
    import {mapGetters} from 'vuex';

    export default {
        name: 'Home',
        components: {
            Companies
        },
        computed: {
            ...mapGetters(['user']),
        },
        data() {
            return {
                image_src: '/assets/images/banner.mp4'
            }
        }
    }
</script>
