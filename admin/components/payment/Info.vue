<template>
    <div>
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
                    readonly
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
                    v-model="form.or_number"
                    label="OR Number"
                    required
                    dense
                    outlined
                    hide-details="auto"
                    :error-messages="error.or_number"
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
                                v-if="selectedPayment.file_name"
                                v-model="selectedPayment.file_name"
                                accept="image/*"
                                class="pt-0"
                                prepend-icon=""
                                label="Select file"
                                hide-details="auto"
                                :error-messages="error.image"
                                @change="selectFile($event, selectedPayment)"
                            ></v-file-input>
                            <v-file-input
                                v-else
                                v-model="form.image"
                                accept="image/*"
                                class="pt-0"
                                prepend-icon=""
                                label="Select file"
                                hide-details="auto"
                                :error-messages="error.image"
                                @change="selectFile($event, selectedPayment)"
                            ></v-file-input>
                            <v-img
                                v-if="selectedPayment.file_url"
                                contain
                                max-height="400"
                                max-width="500"
                                :src="url(selectedPayment.file_url)"
                            />
                        </div>
                    </div>
                </v-radio-group>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import { Reservations } from '../../services/reservations'
import ReservationMixin from "~/mixins/ReservationMixin.js"

export default {
    name: "PaymentInfoEdit",
    mixins: [ReservationMixin],
    props: {
        payment: {
            type: Object,
            default: () => {}
        },
        buyerSlug: {
            type: String,
            default: ''
        },
        errors: {
            type: Object,
            default: () => {}
        }
    },
    data: vm => ({
        dateFormatted: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        date: false,
        selectedPayment: {
            image_key: null,
            file_name: null
        },
        local: [
            {
                label: 'Reservation Fee'
            },
            {
                label: 'Monthly Amortization'
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
            allowLeadingZeroes: false,
        }),
        error: {},
        form: {
            buyer_id: null,
            reservation_id: null,
            ar_number: null,
            or_number: null,
            amount: null,
            type_of_payment: null,
            mode_of_payment: 'Cash',
            paid_at: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
            image: null
        },

        buyer: '',
        buyerData: {},
        buyers: [],
        mapLocations: [],
    }),

    watch: {
        payment (val) {
            this.getProperty()
        }, 

        'form.paid_at'(val) {
            this.dateFormatted = this.formatDate(val)
        },

        'form.mode_of_payment'(val) {
            if (!this.payment) {
                this.form.image = null
            }
        },

        form: {
            handler(val){
                this.clear()
                this.$emit('paymentInfo', val)
            },
            deep: true
        }
    },

    created () {
        if (this.payment) {
            this.selectedPayment = this.payment
            if (this.payment.file_name) {
                this.selectedPayment.file_name = new File([this.payment.file_url], this.payment.file_name, {
                    type: "image/jpeg",
                })
            }
            
            // this.form.image = this.selectedPayment.file_name
        }
    },

    mounted () {
        this.getProperty()
    },

    methods: {
        selectFile (file, selectedPayment) {
            if (!file) {
                selectedPayment.value = false
            }
            this.form.image = file
            selectedPayment.file_url = file
            this.$emit('paymentInfo', this.form)
        },

        url (url) {
            if (!url) return;

            if (typeof url === 'object') {
                return URL.createObjectURL(url);
            } else {
                return url
            }
        },

        getProperty () {
            if (this.$route.params?.id) {
                this.getBuyer(this.$route.params?.id)
            } else {
                this.getBuyer(this.buyerSlug)
            }

            if (this.payment) {
                for (const i in this.payment) {
                    if (i === 'amount') {  
                        this.currencyMask = null
                        this.form.amount = this.payment.amount
                    }
                    else if (i === 'paid_at') {
                        this.form.paid_at = this.payment.original_paid_at
                    }
                    else if (i === 'image') {
                        // console.log('ss')
                        // console.log(this.payment.image)
                        this.form.image = this.payment.image
                    }
                    else {
                        this.form[i] = this.payment[i]
                    }
                }
                
            }
        },

        showUploadFile (val) {
            return (this.form.mode_of_payment !== 'Cash') && this.form.mode_of_payment === val.label
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

            if (this.payment.reservation_id) {
                this.form.reservation_id = parseInt(this.payment.reservation_id)
            } else {
                this.form.reservation_id = this.mapLocations[0].value
            }
        },
    },
}
</script>