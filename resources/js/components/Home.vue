<template>
    <div>
        <section id="banner">
            <div class="inner">
                <h1 v-if="!user">CRM-VUE</h1>
                <h2 v-if="user">Welcome {{ user.name }}</h2>
                <p>Company / Employee Management System<br /></p>
            </div>
            <video autoplay loop muted playsinline :src="image_src"></video>
        </section>
        <section class="wrapper">
            <div class="inner">
                <header class="special">
                    <h2>Company Relationship Management</h2>
                    <p>Stay aware and in control of your company and employees.</p>
                </header>
            </div>
        </section>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: 'Home',
        computed: {
          ...mapGetters(['user'])
        },
        data() {
            return {
                image_src: '/assets/images/banner.mp4',
            }
        }
    }
</script>
