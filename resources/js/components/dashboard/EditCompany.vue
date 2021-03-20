<template>
    <div>
        <div id="heading" >
            <h1>Edit Company</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Edit Company</h3>
                    <form  enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" :value="name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password" placeholder="Password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="password" class="mt--y10" v-model="password_confirm" placeholder="Password Confirmation" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="mt--y10" v-model="url" placeholder="Url" />
                            </div>
                        </div>
                        <div class="row company__logo">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="validatedCustomFile" v-on:change="saveImage">
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            </div>
                        </div>
                        <div class="login__btn">
                            <button class="button primary mt--y10">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'EditCompany',
    data() {
        return {
            id: this.$route.params.id,
            name: '',
            password: '',
            password_confirm: '',
            url: '',
            logo: ''
        }
    },
    methods: {
        saveImage(e) {
            this.logo = e.target.files[0];
        }
    },
    async created() {
        const response = await axios.get('company/'+this.id);
        var company    = response.data.data;
        this.name      = company.name;
        this.url       = company.url;
    }
}
</script>

<style scoped>
    .inner {
        margin: 0 auto;
        width: 35rem;
        max-width: calc(100% - 6rem);
    }

    .company__logo
    {
        margin-left: 0px;
        width: 100%;
    }
</style>
