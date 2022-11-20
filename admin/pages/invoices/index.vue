<template>
    <div>
        <section v-if="loaded">
            <h1 class="title">Invoices</h1>
            <br>
            <v-row>
                <v-col>
                </v-col>
                <v-col sm="5">
                <section class="d-flex">
                    <v-text-field
                        label="Search Name or Email"
                        dense
                        outlined
                        class="mx-1"
                        @input="searchInvoice"
                    ></v-text-field>
                    <v-select
                        v-model="filter_invoice"
                        :items="filters"
                        label="Filter Invoice"
                        placeholder="Select Account Title"
                        dense
                        outlined
                        class="mx-1"
                        @change="selectFilter"
                    />
                    <v-select
                        v-if="filter_invoice === 'Past Due'"
                        v-model="filter_month"
                        :items="pastDueFilters"
                        label="Filter Past Dues"
                        placeholder="Select Account Title"
                        dense
                        outlined
                        class="mx-1"
                        @change="selectFilter"
                    />
                </section>
                </v-col>
            </v-row>

            <v-data-table
                :headers="headers"
                :items="invoices"
                :single-expand="singleExpand"
                :expanded.sync="expanded"
                item-key="index"
                show-expand
                class="elevation-1 pointer"
                @click:row="clickRow"
            >
                <template v-slot:expanded-item="{ item }">
                        <td :colspan="headers.length" class="pa-0">
                            <v-card
                            class="mx-auto px-10"
                            outlined
                            >
                                <v-simple-table class="simple-table-expand">
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-left pl-10" width="33%">
                                                    <span v-if="filter_invoice !== 'Paid'">Due date</span>
                                                    <span v-else>Date of payment</span>
                                                </th>
                                                <th class="text-left" width="33%">
                                                    <span v-if="filter_invoice !== 'Paid'">Monthly amortization</span>
                                                    <span v-else>Amount</span>
                                                </th>
                                                <th class="text-left">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="source in item.upcoming_invoices"
                                                :key="source.name"
                                            >
                                                <td class="pl-10">{{ source.due_date }}</td>
                                                <td>{{ formatCurrency(source.monthly_amortization) }}</td>
                                                <td class="warning--text">{{ source.status }}</td>
                                            </tr>
                                            <tr
                                                    
                                                v-for="source in item.past_dues"
                                                :key="source.name"
                                            >
                                                <td class="pl-10">{{ source.due_date }}</td>
                                                <td>{{ formatCurrency(source.monthly_amortization) }}</td>
                                                <td class="danger--text">{{ source.status }}</td>
                                            </tr>
                                            <!-- <tr
                                                v-for="source in item.paids"
                                                :key="source.name"
                                            >
                                                <td class="pl-10">{{ source.paid_at }}</td>
                                                <td>{{ source.amount }}</td>
                                                <td>{{ source.status }}</td>
                                            </tr> -->
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-card>
                        </td>
                        <br>
                </template>
            </v-data-table>
        </section>
    </div>
</template>

<script>
import _ from "lodash";
import { Invoice } from '../../services/invoices'
export default {
    name: "PaymentsIndex",
    data () {
        return {
            loading: false,
            loaded: false,
            prof_title_id: "",
            headers: [
                { text: 'Property', value: 'property' },
                { text: 'Name', value: 'name' },
                { text: 'Date of reservation', value: 'date_of_transaction' },
                { text: 'Contract Price', value: 'contract_price' },
                { text: 'Term', value: 'term' },
                { text: 'Balance', value: 'balance' },
                { text: '', value: 'data-table-expand' },
            ],
            filters: ['Upcoming Invoice', 'Past Due'],
            pastDueFilters: ['All', 'This month', 'Last 3 months', 'Last 6 months', 'Last 12 months'],
            paginateData: null,
            invoices: [],
            search: '',

            filter_month: 'All',
            filter_invoice: 'Upcoming Invoice',

            expanded: [],
            singleExpand: true,
        }
    },
    watch: {
        loaded(value) {
            this.loaded = value
        }
    },
    created() {
        this.getInvoices()
        this.searchInvoice = _.debounce(this.searchInvoice, 400);
    },
    mounted() {
        
    },
    methods: {
        getInvoices() {
            this.loading = true
        
            Invoice.all({
                type: this.filter_invoice,
                filter_month: this.filter_month,
                search: this.search
            }).then((response) => {
                this.paginateData = response.data
                this.loaded = true
                this.loading = false

                const self = this

                this.invoices = response.data.data.filter(function(reservation, index) {
                    let total = 0
                    const payments = reservation.payments

                    payments.forEach(payment => {
                        total += payment.amount
                    });

                    self.$set(reservation, 'index', index)

                    self.$set(reservation, 'total_payment', total)

                    self.$set(reservation, 'balance', self.getBalance(reservation))

                    reservation.contract_price = '₱' + Number(reservation.contract_price).toLocaleString()

                    if (self.filter_invoice === 'Upcoming Invoice' && reservation.upcoming_invoices.length) {
                        return reservation
                    }
                    else if (self.filter_invoice === 'Past Due' && reservation.past_dues.length) {
                        return reservation
                    }
                    else if (self.filter_invoice === 'Paid' && reservation.paids.length) {
                        return reservation
                    }
                    return false
                })
            });
        },

        selectFilter () {
            this.invoices= []
            this.getInvoices();
        },

        getBalance (item) {
            const total = parseInt(item.contract_price) - parseInt(item.total_payment)

            if (total <= 0) {
                return '₱' + Number(0).toLocaleString()
            }
            return '₱' + Number(total).toLocaleString()
        },
        searchInvoice(value) {
            this.invoices = []
            this.search = value
            console.log(this.search)
            this.getInvoices()
        },

        clickRow(item, event) {
            if(event.isExpanded) {
                const index = this.expanded.findIndex(i => i === item);
                this.expanded.splice(index, 1)
            } else {
                this.expanded.push(item);
            }
        }
    }
}
</script>
<style>
    .simple-table-expand th, .simple-table-expand td {
        border: 0 !important;
    }
</style>