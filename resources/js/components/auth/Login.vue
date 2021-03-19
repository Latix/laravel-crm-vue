<template>
    <div>
        <div id="heading" >
            <h1>Access Control</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3>Login</h3>
                    <form method="post" action="#">
                        <div class="row gtr-uniform">
                            <div class="col-12">
                                <input type="email" class="mt--y10" name="email" id="email" value="" placeholder="Email" />
                            </div>
                        </div>
                        <div class="row gtr-uniform">
                            <div class="col-12">
                                <input type="password" class="mt--y10" name="password" id="password" value="" placeholder="Password" />
                            </div>
                        </div>
                        <button class="button primary mt--y10">Login</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'Login'
}
</script>

<style>

</style>