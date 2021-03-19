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
                    <hr />
                    <h4>Companies</h4>
                    <p v-for="company in companies" :key="company.id">{{ company.name }}</p>
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
                companies: []
            }
        },
        async created() {
            try {
                const response = await axios.get('company');
                console.log(response);
                this.companies = response.data.data;
            } catch (e) {
                console.log();
            }
        }
    }
</script>
