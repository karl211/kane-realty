<template>
    <div>
        <section v-if="loaded">
        <h1 class="title">Receipts</h1>
        <br>
        <v-row>
            <v-col>
                <v-btn
                    class="ml-2"
                    elevation="0"
                    color="info"
                    @click="$router.push('/receipts/create')"
                >
                    <v-icon>mdi-cash-clock</v-icon> &nbsp; New Payment
                </v-btn>
            </v-col>
            <v-col sm="5">
                <section class="d-flex">
                    <v-text-field
                        label="Name, Email, Address, User Type"
                        dense
                        outlined
                        class="mx-1"
                        @input="searchPayment"
                    ></v-text-field>
                    <v-select
                        v-model="prof_title_id"
                        item-text="title"
                        item-value="id"
                        label="Account Title"
                        placeholder="Select Account Title"
                        dense
                        outlined
                        class="mx-1"
                    />
                </section>
            </v-col>
        </v-row>

        <v-data-table
            hide-default-footer
            disable-sort
            :loading="loading"
            :items="payments"
            :headers="headers"
            :items-per-page="5"
            :server-items-length="payments.length"
        >
            <template #item="{ item }">
            <tr>
                <td class="w-10">{{ item.paid_at }}</td>
                <td>{{ item.ar_number }}</td>
                <td>{{ item.or_number }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.property }}</td>
                <td>{{ formatCurrency(item.contract_price) }}</td>
                <td>{{ formatCurrency(item.amount) }}</td>
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
                            @click="deletePayment(item)"
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
import Swal from 'sweetalert2'
import { Auth } from '../../services/auth'
import { Payment } from '../../services/payments'
export default {
    name: "PaymentsIndex",
    data () {
        return {
            loading: false,
            loaded: false,
            prof_title_id: "",
            headers: [
                { text: "Date Paid" },
                { text: "AR No." },
                { text: "OR No." },
                { text: "Name" },
                { text: "Property" },
                { text: "Contract Price" },
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
            }).catch(error => {
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        error.response.data.message,
                        'warning'
                    )
                }
            })
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
        deletePayment(item) {
            Swal.fire({
                title: 'Do you want to delete this payment?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    Payment.remove({id: item.payment_id}).then((response) => {
                        if (response.data) {
                            Swal.fire({
                                title: 'Done!',
                                text: 'Successfully deleted',
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
                            Swal.fire(
                                'Ops.',
                                error.response.data.message,
                                'warning'
                            )
                            this.errors = error.response.data.errors
                        }
                    })
                }
            })
        }
    }
}
</script>
