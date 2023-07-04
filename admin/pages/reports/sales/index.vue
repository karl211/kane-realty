<template>
    <div>
    <section>
        <!-- <v-select
            v-model="filter_invoice"
            :items="years"
            label="Filter Year"
            dense
            outlined
            width="100"
            class="mx-1"
        /> -->
        <div class="container text-center sales-header">
            <h1>SALES</h1>
            <div class="d-flex justify-center">
                <h3 class="w-100">FOR THE YEAR  </h3>
                <v-select
                    v-model="year"
                    :items="years"
                    dense
                    hide-details
                    class="ml-2 year-opt"
                    @change="selectYear"
                ></v-select>
            </div>
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
                    <td class="particular">
                        <h3 class="mt-2">{{item.particular}}</h3>
                        <!-- <p class="mb-1 ml-10" v-for="(data, i) in item.data" :key="i">{{ i }}</p> -->
                        <p class="mb-1 ml-10">Fully Paid</p>
                        <p class="mb-1 ml-10">Monthly Amortization</p>
                        <p class="mb-1 ml-10">Reservation Fee</p>
                        <p class="mb-1 ml-0"><strong>TOTAL</strong></p>
                    </td>

                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Jan || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Jan || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Jan || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Jan') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Feb || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Feb || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Feb || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Feb') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Mar || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Mar || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Mar || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Mar') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Apr || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Apr || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Apr || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Apr') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.May || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.May || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.May || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'May') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Jun || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Jun || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Jun || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Jun') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Jul || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Jul || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Jul || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Jul') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Aug || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Aug || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Aug || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Aug') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Sep || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Sep || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Sep || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Sep') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Oct || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Oct || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Oct || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Oct') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Nov || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Nov || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Nov || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Nov') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Dec || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Dec || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Dec || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Dec') }}</p>
                    </td>
                    <td class="text-center">
                        <h3 class="mt-2">&nbsp;</h3>
                        <p class="mb-1">{{formatCurrency(item.data['Fully Paid']?.Total || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Monthly Amortization']?.Total || '-')}}</p>
                        <p class="mb-1">{{formatCurrency(item.data['Reservation Fee']?.Total || '-')}}</p>
                        <p class="mb-1 font-weight-bold">{{ calculateTotal(item.data, 'Total') }}</p>
                    </td>
                </tr>
            </template>
            <template slot="body.append">
                    <td class="font-weight-bold pl-4">GRAND TOTAL</td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Jan') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Feb') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Mar') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Apr') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('May') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Jun') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Jul') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Aug') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Sep') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Oct') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Nov') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Dec') }}</p></td>
                    <td class="text-center"><p class="font-weight-bold my-2">{{ grandTotal('Total') }}</p></td>
            </template>
        </v-data-table>
    </section>
    </div>
</template>

<script>
// import _ from "lodash";
import Swal from 'sweetalert2'
import moment from 'moment';
import { Report } from '../../../services/reports'
export default {
    name: "PaymentsIndex",
    data () {
        return {
            loading: false,
            loaded: false,
        
            sales: [],
            years: [],
            year: moment().year(),
        }
    },
    
    watch: {
        loaded(value) {
            this.loaded = value
        }
    },
    created() {
        this.getSales()
    },
    mounted() {
    
    },
    methods: {
        getSales() {
            this.loading = true
            
            Report.sales({
                year: this.year
            }).then((response) => {
                const data = []
                for (const key in response.data.sales) {
                    data.push({
                        particular: key,
                        data: response.data.sales[key]
                    })
                }

                this.sales = data
                this.years = response.data.years
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

        calculateTotal (item, month) {
            let total = 0
            for (const key in item) {
                if (item[key][month]) {
                    total += item[key][month]
                }
            }
            return this.formatCurrency(total)
        },

        grandTotal (month) {
            let total = 0
            this.sales.forEach(sale => {
                for (const key in sale.data) {
                    if (sale.data[key][month]) {
                        total += sale.data[key][month]
                    }
                }
            });
            return this.formatCurrency(total)
        },

        selectYear (year) {
            this.year = year
            this.getSales()
        }
    }
}
</script>
<style>
.w-21 {
    font-size: 14px !important;
}
.year-opt {
    display: block;
    font-size: 1.17em;
    /* margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px; */
    font-weight: bold;
    position: relative;
    bottom: 4px;
    max-width: 80px;
}
.sales-header {
    width: 300px;
}
.particular {
    min-width: 210px;
}
</style>
