<template>
    <div>
        <section id="main">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn mb__30">Companies</h3>
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
                            >
                                <template #table-busy>
                                    <div class="text-center text-danger my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                    </div>
                                </template>
                                <template #cell(logo)="data">
                                    <div class="text-center">
                                        <b-avatar variant="secondary" :src="data.value"></b-avatar>
                                    </div>
                                </template>
                                <template #cell(name)="data">
                                    <div class="text-center">
                                        <p>{{ data.value }}</p>
                                    </div>
                                </template>
                                <template #cell(email)="data">
                                    <div class="text-center">
                                        <p>{{ data.value }}</p>
                                    </div>
                                </template>
                                <template #cell(url)="data">
                                    <div class="text-center">
                                        <p>{{ data.value }}</p>
                                    </div>
                                </template>
                                <template #cell(Employees)="data">
                                    <div class="text-center">
                                        <b>{{ data.item.employees.length }}</b>
                                    </div>
                                </template>
                                <template #cell(actions)="row">
                                    <div class="text-center">
                                        <b-dropdown v-if="user && user.info.account_type == 'Admin'" id="dropdown-1" text="Actions" class="m-md-2">
                                            <b-dropdown-item  @click="editCompany(row)">Edit Company</b-dropdown-item>
                                            <b-dropdown-item  @click="viewEmployees(row)">View Employees</b-dropdown-item>
                                            <b-dropdown-item  @click="deleteCompany(row)">Delete Company</b-dropdown-item>
                                        </b-dropdown>
                                        <p v-else>...</p>
                                    </div>
                                </template>
                            </b-table>
                            <b-pagination
                            v-model="currentPage"
                            :total-rows="rows"
                            :per-page="perPage"
                            aria-controls="my-table"
                            class="justify__content"
                            ></b-pagination>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Vue from 'vue';
export default {
    name: 'Companies',
    props: ['user'],
    computed: {
        rows() {
            return this.companies.length
        }
    },
    data() {
        return {
            isBusy: true,
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
                {
                    key: 'Employees',
                    label: 'Total Employees',
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
            this.isBusy = true;
            try {
                const response = await axios({
                    method: 'delete',
                    url: "company/"+company.item.id,
                    headers: {
                        Authorization: 'Bearer ' + this.user.token
                    }
                });
                
                Vue.$toast.open({
                    message: company.item.name + ' has been deleted!',
                    type: 'success'
                });
                this.companies = response.data[2].companies;
                this.isBusy = false;
            } catch (error) {
                Vue.$toast.open({
                    message: 'An error occured!',
                    type: 'error'
                });
                this.isBusy = false;
            }
        },
        editCompany (company) {
            this.$router.push('company/edit/'+company.item.id);
        },
        viewEmployees (company) {
            this.$router.push('company/employees/'+company.item.id);
        }
    },
    async created() {
        try {
            const response = await axios.get('company');
            this.companies = response.data.data;
            this.isBusy = false;
        } catch (e) {
            Vue.$toast.open({
                message: 'An error occured!',
                type: 'error'
            });
            this.isBusy = false;
        }
    },
}
</script>

<style>
    .justify__content
    {
        justify-content: flex-end;
    }
</style>