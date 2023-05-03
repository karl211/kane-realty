<template>
    <div>
    <section v-if="loaded">
        <h1 class="title">Report</h1>
        <v-row>
        <v-col></v-col>
        <v-col sm="5">
            <section class="d-flex">
                <v-menu
                    ref="date"
                    v-model="date"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    max-width="290px"
                    min-width="auto"
                    
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        v-model="dateFormatted"
                        label="Date From"
                        persistent-hint
                        v-bind="attrs"
                        v-on="on"
                        dense
                        outlined
                        hide-details
                        class="pr-2"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                        @input="date = false"
                    ></v-date-picker>
                </v-menu>
                
                <v-menu
                    ref="date"
                    v-model="date"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    max-width="290px"
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        v-model="dateFormatted"
                        label="Date To"
                        persistent-hint
                        v-bind="attrs"
                        v-on="on"
                        dense
                        outlined
                        hide-details
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                        @input="date = false"
                    ></v-date-picker>
                </v-menu>
            </section>
        </v-col>
        </v-row>

        <v-data-table
        hide-default-footer
        :loading="loading"
        :items="payments"
        :headers="headers"
        :items-per-page="5"
        :server-items-length="payments.length"
        >
        <template #item="{ item }">
            <tr>
                <td>{{ item.ar_number }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.property }}</td>
                <td>{{ item.contract_price }}</td>
                <td>{{ item.balance }}</td>
                <td>{{ item.amount_paid }}</td>
                <td>{{ item.type_of_payment }}</td>
                <td>{{ item.mode_of_payment }}</td>
                <td>
                    <div class="d-flex justify-content">
                        <v-btn
                            elevation="0"
                            depressed
                            color="warning"
                            small
                            icon
                        >
                            <v-icon>mdi-file-edit-outline</v-icon>
                        </v-btn>
                        <v-btn
                            class="ml-2"
                            elevation="0"
                            color="danger"
                            small
                            icon
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </div>
                </td>
            </tr>
        </template>
        </v-data-table>
        <v-row justify="space-between">
        <v-col></v-col>
        <v-col class="text-right">
            <TablePagination
            v-if="payments.length"
            :paginate-data="paginateData"
            @paginate="paginate"
            />
        </v-col>
        </v-row>
    </section>
    </div>
</template>

<script>
import _ from "lodash";
import { Auth } from '../../services/auth'
export default {
    name: "PaymentsIndex",
    data () {
    return {
        dateFormatted: this.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        date: false,
        loading: false,
        loaded: false,
        prof_title_id: "",
        headers: [
        { text: "AR No." },
        { text: "Name" },
        { text: "Property" },
        { text: "Contract Price" },
        { text: "Balance" },
        { text: "Amount paid" },
        { text: "Type" },
        { text: "Mode" },
        { text: "Actions", align: "center" },
        ],
    
        paginateData: null,
        payments: [],
        search: {
        page: 1,
        search: ''
        }
    }
    },
    watch: {
    loaded(value) {
        this.loaded = value
    }
    },
    created() {
    this.getPayments()
    this.searchPayment = _.debounce(this.searchPayment, 400);
    },
    mounted() {
    
    },
    methods: {
    getPayments() {
        this.loading = true
        
        Auth.payments(this.search).then((response) => {
        this.paginateData = response.data
        this.payments = response.data.data
        this.loaded = true
        this.loading = false
        });
    },
    paginate(pageNumber) {
        this.search.page = pageNumber
        this.getPayments(this.search);
    },
    searchPayment(value) {
        this.payments = []
        this.search.page = 1
        this.search.search = value

        this.getPayments(this.search)
    },
    formatDate (date) {
        if (!date) return null

            const [year, month, day] = date.split('-')
            return `${month}/${day}/${year}`
        },
    }
}
</script>
