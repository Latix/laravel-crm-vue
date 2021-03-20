<template>
    <div>
        <div id="heading" >
            <h1>Employees</h1>
        </div>
        <section id="main" class="wrapper">
            <div class="inner">
                <div class="content">
                    <h3 class="login__btn">Employees</h3>
                    <div class="overflow-auto">
            <b-table
            id="my-table"
            :busy="isBusy"
            :items="companies.employees"
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
                <template #cell(CompanyName)="">
                    <p>{{ companies.name }}</p>
                </template>
                <template #cell(actions)="row">
                    <b-icon-trash class="ml-2 cr-pointer" title="Delete" @click="deleteEmployee(row)"></b-icon-trash>&nbsp;<span @click="deleteEmployee(row)" class="cr-pointer">Delete</span>
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
                'CompanyName',
                'actions'
            ],
            companies: [],
            perPage: 5,
            currentPage: 1
        }
    },
    methods: {
        // async deleteEmployee (employee) {
        //     try {
        //         const response = await axios.delete('company/'+company.item.id);
        //         Vue.$toast.open({
        //             message: company.item.name + ' has been deleted!',
        //             type: 'success'
        //         });
        //         this.employees = response.data[2].companies;
        //     } catch(error) {
        //         Vue.$toast.open({
        //             message: 'An error occured!',
        //             type: 'error'
        //         });
        //     }
        // }
    },
    computed: {
        rows() {
            return this.companies.length
        }
    },
    async created() {
        try {
            const response = await axios.get('company/'+this.company_id);
            this.companies = response.data.data;
            this.isBusy = false;
        } catch (e) {}
    },
}
</script>
