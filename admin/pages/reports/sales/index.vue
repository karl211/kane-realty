<template>
    <div>
    <section>
        <div class="container text-center">
            <h1>SALES</h1>
            <h3>FOR THE YEAR 2022</h3>
        </div>

        <v-data-table 
            hide-default-footer
            :items="sales">
            <template v-slot:header >
                <thead>
                    <tr>
                        <th colspan="14" class="text-center font-weight-black"><h3>Months</h3></th>
                    </tr>
                    <tr>
                        <th class="text-center font-weight-black"><h3>Particular</h3></th>
                        <th class="text-center font-weight-black"><h3>JANUARY</h3></th>
                        <th class="text-center font-weight-black"><h3>FEBRUARY</h3></th>
                        <th class="text-center font-weight-black"><h3>MARCH</h3></th>
                        <th class="text-center font-weight-black"><h3>APRIL</h3></th>
                        <th class="text-center font-weight-black"><h3>MAY</h3></th>
                        <th class="text-center font-weight-black"><h3>JUNE</h3></th>
                        <th class="text-center font-weight-black"><h3>JULY</h3></th>
                        <th class="text-center font-weight-black"><h3>AUGUST</h3></th>
                        <th class="text-center font-weight-black"><h3>SEPTEMBER</h3></th>
                        <th class="text-center font-weight-black"><h3>OCTOBER</h3></th>
                        <th class="text-center font-weight-black"><h3>NOVEMBER</h3></th>
                        <th class="text-center font-weight-black"><h3>DECEMBER</h3></th>
                        <th class="text-center font-weight-black"><h3>TOTAL</h3></th>
                    </tr>
                </thead>
            </template>
            <template #item="{ item }">
                <tr>
                    <td>
                        <h3 class="mt-2">{{item.particular}}</h3>
                        <p class="mb-1 ml-10">RESERVATION FEE</p>
                        <p class="mb-1 ml-10">AMORTIZATION</p>
                        <p class="mb-1 ml-0"><strong>TOTAL</strong></p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.jan)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.jan)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.feb)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.feb)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.mar)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.mar)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.apr)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.apr)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.may)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.may)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.june)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.june)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.july)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.july)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.aug)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.aug)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.sept)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.sept)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.oct)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.oct)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.nov)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.nov)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.dec)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.dec)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1" v-if="item.reservation">{{formatCurrency(item.reservation.total)}}</p>
                        <p class="mb-1" v-if="item.amortization">{{formatCurrency(item.amortization.total)}}</p>
                        <p class="mb-1 font-weight-bold">{{formatCurrency(250000)}}</p>
                    </td>
                </tr>
            </template>
            <template slot="body.append">
                    <td class="font-weight-bold pl-4">GRAND TOTAL</td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{formatCurrency(500000)}}</p></td>
            </template>
        </v-data-table>
    </section>
    </div>
</template>

<script>
// import _ from "lodash";
import { Report } from '../../../services/reports'
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
            { text: "Particular" },
            { text: "Months" },
            { text: "Property" },
            { text: "Contract Price" },
            { text: "Balance" },
            { text: "Amount paid" },
            { text: "Type" },
            { text: "Mode" },
            { text: "Actions", align: "center" },
            ],
            total: 0,
        
            paginateData: null,
            sales: [
                {
                    particular: "San Vicente",
                    reservation: {
                        jan: 100000,
                        feb: 100000,
                        mar: 100000,
                        apr: 100000,
                        may: 100000,
                        june: 100000,
                        july: 100000,
                        aug: 150000,
                        sept: 100000,
                        oct: 100000,
                        nov: 100000,
                        dec: 100000,
                        total: 0
                    },
                    amortization: {
                        jan: 150000,
                        feb: 100000,
                        mar: 100000,
                        apr: 100000,
                        may: 100000,
                        june: 100000,
                        july: 100000,
                        aug: 100000,
                        sept: 100000,
                        oct: 100000,
                        nov: 100000,
                        dec: 100000,
                        total: 0
                    }
                },
                {
                    particular: "Tiniwisan",
                    reservation: {
                        jan: 100000,
                        feb: 100000,
                        mar: 100000,
                        apr: 100000,
                        may: 100000,
                        june: 100000,
                        july: 100000,
                        aug: 150000,
                        sept: 1003000,
                        oct: 100000,
                        nov: 100000,
                        dec: 100000,
                        total: 0
                    },
                    amortization: {
                        jan: 150000,
                        feb: 100000,
                        mar: 100000,
                        apr: 100000,
                        may: 1001000,
                        june: 100000,
                        july: 100000,
                        aug: 1050000,
                        sept: 100000,
                        oct: 100000,
                        nov: 100000,
                        dec: 100000,
                        total: 0
                    }
                },
            ],
            payments: [],
            search: {
            page: 1,
            search: ''
            }
        }
    },
    // computed: {
    //     totals() {
    //         return this.sales.map((sale) => {
    //             let total = 0
                
    //             for (const key in sale) {
    //                 if (!isNaN(sale[key])) {
    //                     total += sale[key]
    //                 }
    //             }

    //             sale.res_total = total

    //             return sale
    //         });
            
    //         // totals.fat = totals.fat.toFixed(1)
    //     }
    // },
    watch: {
        loaded(value) {
            this.loaded = value
        }
    },
    created() {
        this.getSales()

        // this.sales.map((sale) => {
        //     let total = 0
            
        //     for (const key in sale) {
        //         if (!isNaN(sale[key])) {
        //             total += sale[key]
        //         }
        //     }

        //     sale.res_total = this.formatCurrency(total)

        //     return sale
        // });
    },
    mounted() {
    
    },
    methods: {
        getSales() {
            this.loading = true
            
            Report.sales(this.search).then((response) => {
                // this.paginateData = response.data
                // this.payments = response.data.data
                // this.loaded = true
                // this.loading = false
            });
        },
        // paginate(pageNumber) {
        //     this.search.page = pageNumber
        //     this.getSales(this.search);
        // },
        // searchPayment(value) {
        //     this.payments = []
        //     this.search.page = 1
        //     this.search.search = value

        //     this.getSales(this.search)
        // },
        // formatDate (date) {
        //     if (!date) return null

        //     const [year, month, day] = date.split('-')
        //     return `${month}/${day}/${year}`
        // },
    }
}
</script>
<style>
.w-21 {
    font-size: 14px !important;
}
</style>
