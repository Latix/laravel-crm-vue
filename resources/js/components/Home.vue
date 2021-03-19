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
                    <h4>Companies</h4>
                    <div class="overflow-auto">
                        <b-table
                        id="my-table"
                        :busy="isBusy"
                        :items="companies"
                        :per-page="perPage"
                        :current-page="currentPage"
                        :fields="fields"
                        large
                        striped
                        hover
                        outlined
                        bordered
                        responsive="sm"
                        >
                            <template #cell(logo)="data">
                                <img :src="data.value" style="width: 50px; height: 50px" />
                            </template>
                            <template #table-busy>
                                <div class="text-center text-danger my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                                </div>
                            </template>
                            <template #cell(actions)="row">
                                <b-icon-pencil-square class="mr-2 cr-pointer" title="Edit"></b-icon-pencil-square><span class="cr-pointer">Edit</span>&nbsp;&nbsp;
                                <b-icon-trash class="ml-2cr-pointer" title="Delete" @click="deleteCompany(row)"></b-icon-trash><span @click="deleteCompany(row)" class="cr-pointer">Delete</span>
                            </template>
                        </b-table>
                        <b-pagination
                        v-model="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        aria-controls="my-table"
                        ></b-pagination>
                    </div>
                </header>
            </div>
        </section>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import Vue from 'vue';
    export default {
        name: 'Home',
        computed: {
            ...mapGetters(['user']),
            rows() {
                return this.companies.length
            }
        },
        data() {
            return {
                isBusy: true,
                image_src: '/assets/images/banner.mp4',
                fields: [
                    {
                        key: 'logo',
                        label: 'Company Logo',
                        sortable: false,
                    },
                    {
                        key: 'name',
                        label: 'Company Name',
                        sortable: true,
                    },
                    {
                        key: 'email',
                        label: 'Email',
                        sortable: true,
                    },
                    {
                        key: 'url',
                        label: 'Url',
                        sortable: true,
                    },
                    'actions'
                ],
                companies: [],
                perPage: 5,
                currentPage: 1
            }
        },
        methods: {
            async deleteCompany (company) {
                try {
                    const response = await axios.delete('company/'+company.item.id);
                    Vue.$toast.open({
                        message: company.item.name + ' has been deleted!',
                        type: 'success'
                    });
                    this.companies = response.data[2].companies;
                } catch(error) {
                    Vue.$toast.open({
                        message: 'An error occured!',
                        type: 'error'
                    });
                }
            }
        },
        async created() {
            try {
                const response = await axios.get('company');
                this.companies = response.data.data;
                this.isBusy = false;
            } catch (e) {
                console.log();
            }
        }
    }
</script>
<style scoped>
.page-item.active .page-link {
    z-index: 3;
    color: #fff !important;
    background-color: #111111;
    border-color: #111111;
}
</style>
