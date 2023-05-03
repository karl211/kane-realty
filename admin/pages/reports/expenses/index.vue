<template>
    <div>
    <section v-if="loaded">
        <div class="container text-center expense-header">
            <h1>EXPENSES</h1>
            <div class="d-flex justify-center">
                <h3 class="w-100">FOR THE YEAR  </h3>
                <v-select
                    v-model="year"
                    :items="years"
                    dense
                    hide-details
                    class="ml-2 year-opt"
                    @change="selectYear(year)"
                ></v-select>
            </div>
        </div>
        <br>
        <v-data-table
            hide-default-footer
            :loading="loading"
            :items="expenses"
            :headers="headers"
            :items-per-page="5"
            :server-items-length="expenses.length"
        >
            <template #item="{ item }">
                <tr>
                    <td class="text-center">
                        <div style="width: 100px;">
                            {{ item.date }}
                        </div>
                    </td>
                    <td>{{ item.particular }}</td>
                    <td class="text-center">{{ item.receipt_no }}</td>
                    <td class="text-center">{{ formatCurrency(item.amount) }}</td>
                    <td>{{ formatCurrency(item.agents_commission_san_vicente) }}</td>
                    <td>{{ formatCurrency(item.agents_commission_tiniwisan) }}</td>
                    <td>{{ formatCurrency(item.salary) }}</td>
                    <td>{{ formatCurrency(item.office_rental_expense) }}</td>
                    <td>{{ formatCurrency(item.utility_expense) }}</td>
                    <td>{{ formatCurrency(item.fuel_gasoline) }}</td>
                    <td>{{ formatCurrency(item.office_materials) }}</td>
                    <td>{{ formatCurrency(item.repair_maintenance) }}</td>
                    <td>{{ formatCurrency(item.representation_expense) }}</td>
                    <td>{{ formatCurrency(item.transportation) }}</td>
                    <td>{{ formatCurrency(item.retainers) }}</td>
                    <td>{{ formatCurrency(item.lot_cancellation) }}</td>
                    <td>{{ formatCurrency(item.web_system_development) }}</td>
                    <td>{{ formatCurrency(item.others) }}</td>
                </tr>
            </template>
            <template slot="body.append">
                    <td class="font-weight-bold pl-4">TOTAL</td>
                    <td></td>
                    <td class="text-center">
                        {{ getTotal('amount') }}
                        <!-- <p class="font-weight-bold my-2">
                            
                        </p> -->
                        
                    </td>
            </template>
        </v-data-table>
        <v-row justify="space-between">
        <v-col></v-col>
        <!-- <v-col class="text-right">
            <TablePagination
            v-if="payments.length"
            :paginate-data="paginateData"
            @paginate="paginate"
            />
        </v-col> -->
        </v-row>
    </section>
    </div>
</template>

<script>
import _ from "lodash";
import { Expense } from '../../../services/expenses'
export default {
    name: "ExpensesIndex",
    data () {
        return {
            dateFormatted: this.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
            date: false,
            loading: false,
            loaded: false,
            prof_title_id: "",
            headers: [
            { align: 'center', text: "Date", width: '10%' },
            { align: 'center', text: "PARTICULAR" },
            { align: 'center', text: "RECEIPT NO." },
            { align: 'center', text: "AMOUNT" },
            { align: 'center', text: "AGENTS COMMISSION SAN VICENTE" },
            { align: 'center', text: "AGENTS COMMISSION TINIWISAN" },
            { align: 'center', text: "SALARY" },
            { align: 'center', text: "OFFICE RENTAL EXPENSE" },
            { align: 'center', text: "UTILITY EXPENSE" },
            { align: 'center', text: "FUEL & GASOLINE" },
            { align: 'center', text: "OFFICE/MATERIALS & SUPPLIES" },
            { align: 'center', text: "REPAIR & MAINTENANCE" },
            { align: 'center', text: "REPRESENTATION EXPENSE" },
            { align: 'center', text: "RETAINER'S FEE" },
            { align: 'center', text: "LOT CANCELLATION" },
            { align: 'center', text: "WEB SYSTEM DEVELOPMENT" },
            { align: 'center', text: "OTHERS" },
            // { align: 'center', text: "Actions"},
            ],
            paginateData: null,
            expenses: [],
            years: ['2022'],
            year: '2022',
            total: 0,
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
        this.getExpenses()
        this.searchPayment = _.debounce(this.searchPayment, 400);
    },
   
    mounted() {
    
    },
    methods: {
        getTotal(item) {
            console.log(item)
            return this.formatCurrency(123123)
            // return orderby(item.entities, ['entity', 'value'], ['asc', 'asc'])
        },
        getExpenses() {
            this.loading = true
            
            Expense.all(this.search).then((response) => {
                console.log()
                this.expenses = response.data.data
                // this.paginateData = response.data
                // this.payments = response.data.data
                this.loaded = true
                this.loading = false
            });
        },
        paginate(pageNumber) {
            this.search.page = pageNumber
            this.getExpenses(this.search);
        },
        searchPayment(value) {
            // this.payments = []
            // this.search.page = 1
            // this.search.search = value

            this.getExpenses(this.search)
        },
        formatDate (date) {
            if (!date) return null
                const [year, month, day] = date.split('-')
                return `${month}/${day}/${year}`
            },
        },
        fullName(salut) {
            return `${salut}`
        },
        // getTotal () {
        //     this.total =
        //     return 123123
        // },
        selectYear (year) {
            this.year = year
            this.getExpenses()
        },

        // grandTotals () {
        //     // const total = month
        //     // this.expenses.forEach(expense => {
        //     //     console.log(expense)
        //     // })
        //     return ''
        //     // return this.formatCurrency(total)
        // },
    }
</script>
<style>
    .expense-header {
        width: 300px;
    }
    .expense-header h3{
        width: 400px;
    }
</style>
