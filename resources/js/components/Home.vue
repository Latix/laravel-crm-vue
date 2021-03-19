<template>
    <div>
        <section id="banner">
            <div class="inner">
                <h1>CRM-VUE</h1>
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
    export default {
        name: 'Home',
        data() {
            return {
                image_src: '/assets/images/banner.mp4',
            }
        }
    }
</script>
