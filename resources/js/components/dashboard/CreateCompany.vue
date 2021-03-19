<template>
    <div>
        <div id="heading" >
            <h1>Create Company</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <!-- <div class="alert alert-success">Company created</div> -->
                    <h3 class="login__btn">Login</h3>
                    <form @submit.prevent="handleCreateCompany">
                        <div class="row">
                            <div class="col-12">
                                <input type="email" class="mt--y10"  placeholder="Email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" placeholder="Password" />
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
    name: 'CreateCompany',
    async created() {
        try {
            const response = await axios.get('company');
            console.log(response);
        } catch(e) {
            console.log(e.response.data);
        }
        
    }
}
</script>

<style scoped>
    .inner {
        margin: 0 auto;
        width: 35rem;
        max-width: calc(100% - 6rem);
    }
</style>
