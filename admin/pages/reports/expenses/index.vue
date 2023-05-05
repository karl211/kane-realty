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
            <v-dialog
                v-model="dialog"
                width="700px"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        class="ml-auto"
                        elevation="0"
                        color="info"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-cash</v-icon> Add Expense
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title class="pb-0 ml-6">
                        <h3>Add Expense</h3>
                    </v-card-title>
                    <v-form>
                        <v-container class="px-10">
                            <ExpenseAdd size="sm" @addExpense="updateForm($event)"/>
                            <br>
                            <v-divider></v-divider>
                            <br>
                            <div class="d-flex justify-end">
                                <v-btn
                                    class="ml-2"
                                    elevation="0"
                                    color="warning"
                                    @click="dialog = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    class="ml-2"
                                    elevation="0"
                                    color="primary"
                                    @click="submit"
                                >
                                    Submit
                                </v-btn>
                            </div>
                        </v-container>
                    </v-form>
                </v-card>
            </v-dialog>
            <br>
            <v-data-table
                hide-default-footer
                :loading="loading"
                :items="expenses"
                :headers="headers"
                :server-items-length="expenses.length"
            >
                <template #item="{ item }">
                    <tr>
                        <td class="text-center">
                            <div style="width: 100px;">
                                {{ item.date }}
                            </div>
                        </td>
                        <td>
                            <v-img
                                contain
                                max-height="100"
                                max-width="100"
                                :src="item.file_url"
                            />
                        </td>
                        <td>{{ item.particular }}</td>
                        <td class="text-center">{{ item.receipt_no }}</td>
                        <td class="text-center">{{ formatCurrency(item.amount) }}</td>
                        <td class="text-center">{{ formatCurrency(item.agents_commission_san_vicente) }}</td>
                        <td class="text-center">{{ formatCurrency(item.agents_commission_tiniwisan) }}</td>
                        <td class="text-center">{{ formatCurrency(item.salary) }}</td>
                        <td class="text-center">{{ formatCurrency(item.office_rental_expense) }}</td>
                        <td class="text-center">{{ formatCurrency(item.utility_expense) }}</td>
                        <td class="text-center">{{ formatCurrency(item.fuel_gasoline) }}</td>
                        <td class="text-center">{{ formatCurrency(item.office_materials) }}</td>
                        <td class="text-center">{{ formatCurrency(item.repair_maintenance) }}</td>
                        <td class="text-center">{{ formatCurrency(item.representation_expense) }}</td>
                        <td class="text-center">{{ formatCurrency(item.transportation) }}</td>
                        <td class="text-center">{{ formatCurrency(item.retainers) }}</td>
                        <td class="text-center">{{ formatCurrency(item.lot_cancellation) }}</td>
                        <td class="text-center">{{ formatCurrency(item.web_system_development) }}</td>
                        <td class="text-center">{{ formatCurrency(item.professional_fee) }}</td>
                        <td class="text-center">{{ formatCurrency(item.processing_fee) }}</td>
                        <td class="text-center">{{ formatCurrency(item.equipment) }}</td>
                        <td class="text-center">{{ formatCurrency(item.others) }}</td>
                    </tr>
                </template>
                <template slot="body.append">
                        <td class="font-weight-bold pl-4">TOTAL</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            {{ getTotal('amount') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('agents_commission_san_vicente') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('agents_commission_tiniwisan') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('salary') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('office_rental_expense') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('utility_expense') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('fuel_gasoline') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('office_materials') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('repair_maintenance') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('representation_expense') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('transportation') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('retainers') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('lot_cancellation') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('web_system_development') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('professional_fee') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('processing_fee') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('equipment') }}
                        </td>
                        <td class="text-center">
                            {{ getTotal('others') }}
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
import Swal from 'sweetalert2'
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
            { align: 'center', text: "Image" },
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
            { align: 'center', text: "TRANSPORTATION EXPENSE" },
            { align: 'center', text: "RETAINER'S FEE" },
            { align: 'center', text: "LOT CANCELLATION" },
            { align: 'center', text: "WEB SYSTEM DEVELOPMENT" },
            { align: 'center', text: "PROFESSIONAL FEE" },
            { align: 'center', text: "PROCESSING FEE" },
            { align: 'center', text: "EQUIPMENT" },
            { align: 'center', text: "OTHERS" },
            // { align: 'center', text: "Actions"},
            ],
            paginateData: null,
            expenses: [],
            years: ['2022', '2023'],
            year: '2022',
            total: 0,
            dialog: false,
            form: {},
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
        updateForm (form) {
            this.form = form
        },

        submit () {
            const formData = new FormData()

            this.form.branch_id = localStorage.getItem('branch')
            this.form.amount = this.formatAmount(this.form.amount)
            
            Object.entries(this.form).forEach(([key, obj]) => {
                if (obj) {
                    if (key === 'image') {
                        formData.append(key, obj);
                    } else {
                        formData.append(key, JSON.stringify(obj));
                    }
                }
            })

            Expense.create(formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    this.dialog = false

                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully added',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        } 
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    if (error.response.data.message) {
                        Swal.fire(
                            'Ops.',
                            error.response.data.message,
                            'warning'
                        )
                    } else {
                        Swal.fire(
                            'Ops.',
                            'Something went wrong',
                            'warning'
                        )
                    }

                    this.error = error.response.data.errors
                }
            })
        },

        selectYear (year) {
            this.year = year
            this.getExpenses()
        },

        getTotal(itemKey) {
            let total = 0
            this.expenses.forEach(expense => {
                total += expense[itemKey]
            });

            return this.formatCurrency(total)
        },
        getExpenses() {
            this.loading = true
            
            Expense.all({year: this.year}).then((response) => {
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
        

        url (url) {
            if (!url) return;

            if (typeof url === 'object') {
                return URL.createObjectURL(url);
            } else {
                return url
            }
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
