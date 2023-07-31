<template>
    <div>
        <v-container class="print-container">
            <section class="text-center">
                <h1>KANE REALTY</h1>
                <h5>Brgy. San Vicente, Butuan City</h5>
            </section>
            <br>
            <br>
            <section class="m-auto">
                <div>
                    <v-row>
                        <v-col cols="12" class="pb-0 text-uppercase">
                            <h4>BUYER'S NAME: {{buyer?.profile?.first_name}} {{buyer?.profile?.last_name}}</h4>
                            <h4>PROJECT LOCATION: {{ locationName }}</h4>
                        </v-col>
                        <v-col cols="6" class="pt-0 text-uppercase">
                            <h4>BLOCK & LOT NO.: BLOCK {{selectedReservation.property.block}} LOT {{selectedReservation.property.lot}}</h4>
                            <h4>LOT AREA: {{selectedReservation.property.lot_size}}</h4>
                            <h4>CONTRACT PRICE/Lot: {{formatCurrency(selectedReservation.property.contract_price)}}</h4>
                            <h4>TERM: {{selectedReservation.property.term}} MONTHS</h4>
                        </v-col>
                        <v-col cols="6" class="pt-0 text-uppercase">
                            <h4>TOTAL NO. OF LOT: 1</h4>
                            <h4>TOTAL LOT AREA: {{selectedReservation.property.lot_size}}</h4>
                            <h4>TOTAL CONTRACT PRICE: {{formatCurrency(selectedReservation.property.contract_price)}}</h4>
                            <h4>MONTHLY AMORTIZATION: {{formatCurrency(selectedReservation.property.default_monthly_amortization)}}</h4>
                        </v-col>
                    </v-row>
                </div>
            </section>
            <br>
            <section class="print-table">
                <h2 class="text-center">ACCOUNT SUMMARY</h2>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th v-for="(header, index) in headers" :key="index" class="text-left">
                                    {{ header.text }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in selectedReservation.payments" :key="index">
                                <td width="250">{{ item.paid_at }}</td>
                                <td width="250">{{ item.ar_number }}</td>
                                <td width="250">{{formatCurrency(item.amount)}}</td>
                                <td width="250">{{formatCurrency(item.balance)}}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-divider></v-divider>
                <v-simple-table>
                    <template v-slot:default>
                        <tbody>
                            <tr>
                                <td width="50%"><h4>TOTAL PAYMENT --------------------------------------------------</h4></td>
                                <td width="250">{{ formatCurrency(total) }}</td>
                                <td width="250"></td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-container class="pt-0">
                    <section class="text-center">
                        <small >
                            xxxxxxxxxxxxxxxxxxxxxxxxxx NOTHING FOLLOWS xxxxxxxxxxxxxxxxxxxxxxxxxx
                        </small>
                    </section>
                    
                    <br>
                    <br>
                    <h3>Prepared By:</h3>
                    <h3 class="ml-7 text-decoration-underline text-uppercase">{{ $auth.user.profile.first_name }} {{ $auth.user.profile.last_name }}</h3>
                    <h5 class="title">Staff</h5>
                </v-container>
            </section>
        </v-container>
    </div>
</template>
<script>
// import _ from "lodash";
// import Swal from 'sweetalert2'
// import { mapGetters } from 'vuex'
import { Reservations } from '../../../../services/reservations'

export default {
    name: "PrintSoa",
    layout: 'print-layout',
    data () {
        return {
            headers: [
                { text: 'DATE OF PAYMENT', value: 'date', align: "center" },
                { text: 'RECEIPT NO.', value: 'receipt', align: "center" },
                { text: 'AMOUNT', value: 'amount', align: "center" },
                { text: 'OUTSTANDING BALANCE', value: 'balance', align: "center" }
            ],
            items: [
                { date: 'June 17, 2020', receipt: '0734', amount: '22,224.00', balance: '122,776.00' },
                { date: 'June 17, 2020', receipt: '0734', amount: '22,224.00', balance: '22,224.00' },
                { date: 'June 17, 2020', receipt: '0734', amount: '22,224.00', balance: '22,224.00' },
                { date: 'June 17, 2020', receipt: '0734', amount: '22,224.00', balance: '22,224.00' }
            ],

            buyer: null,
            locationName: '',
            selectedReservation: null,
            total: 0
        }
    },
    
    watch: {
        
    },


    created() {
        this.selectedReservation = JSON.parse(localStorage.getItem('selected_reservation'))
        this.outstandingBalance()
        this.getTotal()
        this.getBuyer()

        this.locationName = localStorage.getItem('location_name')
    },

    methods: {
        getBuyer () {
            Reservations.getBuyer(this.$route.params.id).then((response) => {
                if (response.data.data) {
                    this.buyer = response.data.data
                }
            });
        },

        outstandingBalance () {
            if (this.selectedReservation?.payments.length) {
                let balanceAmount = parseFloat(this.selectedReservation.property.contract_price)
                
                this.selectedReservation.payments.forEach(payment => {
                    balanceAmount -= parseFloat(payment.amount)
                 
                    payment.balance = balanceAmount
                });
            }
        },

        getTotal () {
            if (this.selectedReservation?.payments.length) {
                let total = 0

                this.selectedReservation.payments.forEach(payment => {
                    total += parseFloat(payment.amount)
                });

                this.total = total
            }
        }
    }
}
</script>
<style>
    .print-container {
        width: 100%;
        margin: auto;

        .title {
            text-indent: 5rem;
            font-size: 14px !important;
            line-height: 1;
        }
    }
    .print-table {
        width: 100%;
        margin: auto;
        /* min-width: 90%; */
    }

    .print-table thead th {
        padding: 10px;
        width: 25%;
    }
    
    .previewBodyUtilPrintBtn {
        font-size: 20px !important;
    }
</style>
  