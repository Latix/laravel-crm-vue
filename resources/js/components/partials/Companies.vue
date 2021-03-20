<template>
    <div>
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
                <template #cell(Employees)="data">
                    <b>{{ data.item.employees.length }}</b>
                </template>
                <template #table-busy>
                    <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                    </div>
                </template>
                <template #cell(actions)="row">
                    <b-icon-pencil-square class="cr-pointer" title="Edit" @click="editCompany(row)"></b-icon-pencil-square>&nbsp;<span class="cr-pointer" @click="editCompany(row)">Edit</span>&nbsp;&nbsp;
                    <b-icon-file-earmark-text-fill class="cr-pointer" title="Edit"></b-icon-file-earmark-text-fill>&nbsp;<span class="cr-pointer">Employees</span>&nbsp;&nbsp;
                    <b-icon-trash class="ml-2 cr-pointer" title="Delete" @click="deleteCompany(row)"></b-icon-trash>&nbsp;<span @click="deleteCompany(row)" class="cr-pointer">Delete</span>
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
</template>

<script>
export default {
    name: 'Companies',
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
        },
        editCompany (company) {
            this.$router.push('company/edit/'+company.item.id);
        }
    },
    async created() {
        try {
            const response = await axios.get('company');
            this.companies = response.data.data;
            this.isBusy = false;
        } catch (e) {}
    },
}
</script>

<style>
    .justify__content
    {
        justify-content: flex-end;
    }
</style>