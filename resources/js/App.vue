<template>
    <div>
        <header id="header">
            <a class="logo" href="#">Crm-Vue</a>
            <nav>
                <a href="#menu">Menu</a>
            </nav>
        </header>
        <nav id="menu">
            <ul class="links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Login</a></li>
            </ul>
        </nav>
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
        <footer id="footer">
            <div class="inner">
                <div class="copyright">
                    &copy; All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data() {
            return {
                image_src: '/public/assets/images/banner.mp4',
            }
        }
    }
</script>
