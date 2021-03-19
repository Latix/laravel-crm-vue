<template>
    <div>
        <div id="heading" >
            <h1>Access Control</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Login</h3>
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <input type="email" class="mt--y10" name="email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" name="password" placeholder="Password" />
                            </div>
                        </div>
                        <div class="login__btn">
                            <button class="button primary mt--y10">Login</button>
                        </div>
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

<style scoped>
    .inner {
        margin: 0 auto;
        width: 35rem;
        max-width: calc(100% - 6rem);
    }
</style>