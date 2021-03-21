<template>
    <div>
        <div id="heading" >
            <h1>Employees</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn mb__30">Employees</h3>
                    <div class="overflow-auto">
                        <b-table
                        id="my-table"
                        :busy="isBusy"
                        :items="employees"
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
                            <template #table-busy>
                                <div class="text-center text-danger my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                                </div>
                            </template>
                            <template #cell(name)="data">
                                <p class="text-center">{{ data.value }}</p>
                            </template>
                            <template #cell(email)="data">
                                <p class="text-center">{{ data.value }}</p>
                            </template>
                            <template #cell(CompanyName)="">
                                <p class="text-center">{{ company.name }}</p>
                            </template>
                            <template #cell(actions)="row">
                                <p v-if="user.account_type == 'Admin'" class="text-center"><b-icon-trash class="ml-2 cr-pointer" title="Delete" @click="deleteEmployee(row)"></b-icon-trash>&nbsp;<span @click="deleteEmployee(row)" class="cr-pointer">Delete</span></p>
                                <p v-else class="text-center">...</p>
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
import {mapGetters} from 'vuex';
import Vue from 'vue';
export default {
    name: 'Employees',
    data() {
        return {
            company_id: this.$route.params.company_id,
            isBusy: true,
            fields: [
                {
                    key: 'name',
                    label: 'Employee Name',
                    sortable: true,
                },
                {
                    key: 'email',
                    label: 'Email',
                    sortable: true,
                },
                'CompanyName',
                'actions'
            ],
            employees: [],
            company: '',
            perPage: 5,
            currentPage: 1
        }
    },
    methods: {
        async deleteEmployee (employee) {
            this.isBusy = true;
            try {
                const response = await axios.delete('user/'+employee.item.id);
                Vue.$toast.open({
                    message: employee.item.name + ' has been deleted!',
                    type: 'success'
                });
                this.employees = response.data[2].employees;
                this.isBusy = false;
            } catch(error) {
                Vue.$toast.open({
                    message: 'An error occured!',
                    type: 'error'
                });
                this.isBusy = false;
            }
        }
    },
    computed: {
        rows() {
            return this.employees.length
        },
        ...mapGetters(['user'])
    },
    created() {
            axios.get('company/'+this.company_id, {
                company_id: this.company_id
            }).then((response) => {
                const result    = response.data.data;
                
                this.employees  = result.employees;
                this.company    = result;
                this.isBusy = false;
            }).catch((error) => {});
    },
    mounted() {
        if (!this.user){
            this.$router.push('/login');
        }

        if (this.user.account_type == "Manager"){
            if (this.company_id != this.user.company_id){
                this.$router.push('/');
            }
            this.company_id = this.user.company_id;
        }

        if (this.user.account_type == "Employee"){
            this.$router.push('/');
        }
    }
}
</script>
