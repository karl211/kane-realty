<template>
    <v-container>
        <v-card>
            <v-toolbar-title class="pa-10 pt-10 pb-5">
                <h2><v-icon large>mdi-cash-clock</v-icon> Add Payment</h2>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-form>
                <v-container class="pa-10">
                    <v-row>
                        <v-col cols="6">
                            <h3 class="mb-2">Search buyer</h3>
                            <v-autocomplete
                                v-model="form.buyer_id"
                                :items="buyers"
                                filled
                                chips
                                color="blue-grey lighten-2"
                                label="Name / Email"
                                :item-text="getItemText"
                                item-value="id"
                                solo
                                flat
                                hide-no-data
                                outlined
                                class="mt-1"
                                hide-details="auto"
                                :error-messages="error.buyer_id"
                                @update:search-input="searchBuyer"
                            >
                                <template v-slot:selection="data">
                                    <v-chip
                                        v-bind="data.attrs"
                                        :input-value="data.selected"
                                        close
                                        @click:close="remove(data.item)"
                                    >
                                        {{ data.item.last_name }}, {{ data.item.first_name }} {{ data.item.middle_name }}
                                    </v-chip>
                                </template>
                                <template v-slot:item="data">
                                    <template v-if="typeof data.item !== 'object'">
                                        <v-list-item-content v-text="data.item"></v-list-item-content>
                                    </template>
                                    <template v-else>
                                        <v-list-item-content @click="selectBuyer(data)">
                                            <v-list-item-title>{{ data.item.last_name }}, {{ data.item.first_name }} {{ data.item.middle_name }}</v-list-item-title>
                                            <v-list-item-subtitle>
                                                <small class="text-md-caption">{{ data.item.email }}</small>
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </template>
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="3">
                            <BuyerInfo class="min-h-830" :buyer="buyerData"/>
                        </v-col>
                        <v-col cols="9">
                            <v-card
                                class="mx-auto"
                                min-height="830px"
                            >
                                <v-card-text class="text-left">
                                    <v-row>
                                        <v-col cols="6">
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
                                                    label="Date of Payment"
                                                    persistent-hint
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    dense
                                                    outlined
                                                    hide-details
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="form.paid_at"
                                                    no-title
                                                    @input="date = false"
                                                ></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select
                                                v-model="form.reservation_id"
                                                :items="mapLocations"
                                                label="Location"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.reservation_id"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.ar_number"
                                                label="AR Number"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.ar_number"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.amount"
                                                label="Amount"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                prepend-inner-icon="mdi-currency-php"
                                                size="25"
                                                v-mask="currencyMask"
                                                :error-messages="error.amount"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-radio-group 
                                                v-model="form.type_of_payment"
                                                class="mt-0 d-flex"
                                                hide-details="auto"
                                                :error-messages="error.type_of_payment"
                                            >
                                                <h5 class="pb-2">Type of Payment</h5>
                                                <v-radio
                                                    v-for="(val, key) in local"
                                                    :key="key"
                                                    :label="`${val.label}`"
                                                    :value="val.label"
                                                ></v-radio>
                                            </v-radio-group>
                                            <!-- <br>
                                            <v-text-field
                                                v-model="form.type_of_payment"
                                                label="Other Type of Payment"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-text-field> -->
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-radio-group 
                                                v-model="form.mode_of_payment"
                                                class="mt-0 "
                                                hide-details="auto"
                                                :error-messages="error.mode_of_payment"
                                            >
                                                <h5 class="pb-2">Mode of Payment</h5>
                                                <div v-for="(val, key) in modeOfPayments" :key="key">
                                                    <v-radio
                                                        :label="`${val.label}`"
                                                        :value="val.label"
                                                        class="mb-2"
                                                    ></v-radio>
                                                    <div v-if="showUploadFile(val)" class="ml-8">
                                                        <v-file-input
                                                            v-model="form.image"
                                                            accept="image/*"
                                                            prepend-icon=""
                                                            label="Select file"
                                                        ></v-file-input>
                                                        <v-img
                                                            v-if="form.image"
                                                            contain
                                                            max-height="400"
                                                            max-width="500"
                                                            :src="url('image')"
                                                        />
                                                    </div>
                                                </div>
                                            </v-radio-group>
                                            
                                            <!-- <br>
                                            
                                            <v-text-field
                                                v-model="form.mode_of_payment"
                                                label="Mode of Payment"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-text-field> -->
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
import { Reservations } from '../../services/reservations'
import { Payment } from '../../services/payments'
import { Auth } from '../../services/auth'
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