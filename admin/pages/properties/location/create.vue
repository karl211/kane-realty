<template>
    <v-container>
        <v-card>
            <v-toolbar-title class="pa-10 pt-10 pb-5">
                <h2><v-icon large>mdi-cash-clock</v-icon> Add Location</h2>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-form>
                <v-container class="pa-10">
                    <v-row>
                        <v-col cols="12">
                            <v-card
                                class="mx-auto"
                                min-height="830px"
                            >
                                <v-card-text class="text-left">
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select
                                                v-model="form.branch_id"
                                                :items="['Butuan', 'San Franz']"
                                                label="Branch"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.branch_id"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.location"
                                                label="Location"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.location"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-textarea
                                                v-model="form.description"
                                                label="Description"
                                                dense
                                                outlined
                                                name="input-7-4"
                                                hide-details="auto"
                                                :error-messages="error.description"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select
                                                v-model="form.type"
                                                :items="['Lot only', 'House & Lot']"
                                                label="Type"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.type"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                   <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.map"
                                                label="Map Url"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.map"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                       <v-col cols="6">
                                            <v-file-input
                                                v-model="form.photo"
                                                accept="image/*"
                                                prepend-icon=""
                                                label="Photo"
                                                hide-details="auto"
                                                :error-messages="error.photo"
                                            ></v-file-input>

                                            <br>
                                            <v-img
                                                v-if="form.photo"
                                                contain
                                                max-height="400"
                                                max-width="500"
                                                :src="url('photo')"
                                            />
                                       </v-col>
                                   </v-row>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card>
        <div class="d-flex justify-end">
            <v-btn
                class="ml-2"
                elevation="0"
                color="warning"
                @click="cancel"
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
        <br>
    </v-container>
</template>
<script>
// import Swal from 'sweetalert2'

import _ from 'lodash'
import Swal from 'sweetalert2'
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import { Reservations } from '../../../services/reservations'
import { Payment } from '../../../services/payments'
import { Auth } from '../../../services/auth'
export default {
    name: "ReservationCreate",
    data: vm => ({
        dateFormatted: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        date: false,
        local: [
            {
                label: 'Reservation'
            },
            {
                label: 'Amortization'
            },
        ],
        modeOfPayments: [
        {
                label: 'Cash'
            },
            {
                label: 'Cheque'
            },
            {
                label: 'Gcash'
            },
            {
                label: 'Paymaya'
            },
            {
                label: 'Paypal'
            },
            {
                label: 'Online Banking'
            },
        ],

        currencyMask: createNumberMask({
            prefix: '',
            allowDecimal: false,
            includeThousandsSeparator: true,
            allowNegative: false,
            allowLeadingZeroes: false
        }),
        error: {},
        form: {
            buyer_id: null,
            paid_at: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
            mode_of_payment: 'Cash',
            image: null
        },

        buyer: '',
        buyerData: {},
        buyers: [],
        mapLocations: [],
    }),

    watch: {
        'form.paid_at'(val) {
            this.dateFormatted = this.formatDate(val)
        },

        'form.mode_of_payment'(val) {
            this.form.image = null
        },

        form() {
            this.clear()
        }
    },

    created () {
        this.buyers = []
        this.searchBuyer = _.debounce(this.searchBuyer, 360)

        if (this.$route.query?.buyer) {
            this.getBuyer(this.$route.query?.buyer)
        }
    },

    methods: {
        showUploadFile (val) {
            return (this.form.mode_of_payment !== 'Cash') && this.form.mode_of_payment === val.label
        },

        getItemText (item) {
            return `${item.last_name} ${item.first_name} ${item.middle_name} ${item.email}`;
        },

        formatDate (date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${year}-${month}-${day}`
        },

        formatAmount (amount) {
            if (!amount) return null

            return amount.replaceAll(',', '')
        },

        cancel () {
            this.$router.push({path: `/payments`});
        },

        submit () {
            const formData = new FormData()

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

            Payment.create(formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully paid',
                        confirmButtonText: 'Okay',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$router.push({path: `/reservations/${response.data.data.buyer.slug}`});
                        } 
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        'Something went wrong',
                        'warning'
                    )

                    this.error = error.response.data.errors
                }
            })
        },

        remove (item) {
            this.buyer = ''
            this.buyers = []
        },

        searchBuyer (keyword) {
            if (keyword) {
                this.clear()
                this.buyers = []

                Auth.searchBuyer({search: keyword}).then((res) => {
                    if (res.data.data.data.length) {
                        this.buyers = res.data.data.data
                    }
                });
            } else {
                this.buyers = []
            }
        },

        selectBuyer (data) {            
            this.getBuyer(data.item.slug)
        },

        getBuyer (slug) {
            Reservations.getBuyer(slug).then((response) => {
                if (response.data.data) {
                    this.form.buyer_id = response.data.data.buyer_id
                    this.buyerData = response.data.data

                    this.getLocations(response.data.data.reservations)
                }
            });
        },

        url(key) {
            if (!this.form[key]) return;
            return URL.createObjectURL(this.form[key]);
        },

        getLocations (reservations) {
            const properties = []

            reservations.forEach(reservation => {
                this.$set(reservation.property, 'reservation_id', reservation.id)
                properties.push(reservation.property)
            });

            this.mapLocations = properties.map(function(data) {
                let property = `${data.location.location} - Block ${data.block}, Lot ${data.lot}`

                if (data.phase) {
                    property += `, Phase ${data.phase}`
                }

                return {
                    text: property,
                    value: data.reservation_id
                }
            })

            if (this.$route.query?.reservation) {
                this.form.reservation_id = parseInt(this.$route.query?.reservation)
            } else {
                this.form.reservation_id = this.mapLocations[0].value
            }
        },

        clear () {
            for (const key in this.error) {
                if (
                    typeof this.error[key] === 'object' &&
                    !Array.isArray(this.error[key]) &&
                    this.error[key] !== null
                ) {
                    const nestedObj = this.error[key];

                    for (const key in nestedObj) {
                        nestedObj[key] = null
                    }
                } else {
                    this.error[key] = null
                }
            }
        },



        
    },
}
</script>
<style>
    .w-75 {
        width: 75%;
    }
    .w-50 {
        width: 50%;
    }
    .swal2-container {
        font-family: 'Roboto' !important;
    }
    .min-h-830 {
        min-height: 830px;
    }
    .mdi-currency-php {
        font-size: 20px !important;
    }
</style>