<template>
    <v-container>
        <v-card>
            <v-toolbar-title class="pa-10 pt-10 pb-5">
                <h2><v-icon large>mdi-cash-clock</v-icon> Add Property</h2>
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
                                            <v-text-field
                                                v-model="form.location"
                                                label="Location"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                readonly
                                                hide-details="auto"
                                                :error-messages="error.location"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="2">
                                            <v-text-field
                                                v-model="form.block"
                                                v-mask="'####'"
                                                label="Block"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.block"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-text-field
                                                v-model="form.lot"
                                                v-mask="'####'"
                                                label="Lot"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.lot"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-text-field
                                                v-model="form.phase"
                                                v-mask="'####'"
                                                label="Phase"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.phase"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.contract_price"
                                                v-mask="currencyMask"
                                                prepend-inner-icon="mdi-currency-php"
                                                label="Contract Price"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.contract_price"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="3">
                                            <v-text-field
                                                v-model="form.default_monthly_amortization"
                                                v-mask="currencyMask"
                                                prepend-inner-icon="mdi-currency-php"
                                                label="Default monthly amortization"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.default_monthly_amortization"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="3">
                                            <v-text-field
                                                v-model="form.term"
                                                label="Term"
                                                v-mask="'####'"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.term"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.discount"
                                                v-mask="currencyMask"
                                                prepend-inner-icon="mdi-currency-php"
                                                label="Discount"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.discount"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="2">
                                            <v-text-field
                                                v-model="form.lot_size"
                                                label="Lot size"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.lot_size"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-text-field
                                                v-model="form.floor_area"
                                                label="Floor area"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.floor_area"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-text-field
                                                v-model="form.model"
                                                label="Model"
                                                required
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.model"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-textarea
                                                v-model="form.description"
                                                label="Description"
                                                class="required"
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
import Swal from 'sweetalert2'
// import _ from 'lodash'
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import { Property } from '../../../services/properties';
export default {
    name: "ReservationCreate",
    data: vm => ({
        error: {},
        form: {
            location_id: null,
            location: null,
            status: 'active',
        },

    }),

    watch: {
        'form.contract_price'(val) {
            this.clear()
        },
        'form.default_monthly_amortization'(val) {
            this.clear()
        },
        'form.discount'(val) {
            this.clear()
        },
    },

    created () {
        if (this.$route.query.location) {
            this.form.location_id = this.$route.query.id
            this.form.location = this.$route.query.location
        }
    },

    methods: {
        cancel () {
            
        },

        submit () {
            this.currencyMask = createNumberMask({
                prefix: '',
                allowDecimal: false,
                includeThousandsSeparator: true,
                allowNegative: false,
                allowLeadingZeroes: false
            })
            const formData = new FormData()

            this.form.contract_price = this.formatAmount(this.form.contract_price)
            this.form.default_monthly_amortization = this.formatAmount(this.form.default_monthly_amortization)
            this.form.discount = this.formatAmount(this.form.discount)

            Object.entries(this.form).forEach(([key, obj]) => {
                if (obj) {
                    if (key === 'photo') {
                        formData.append(key, obj);
                    } else {
                        formData.append(key, JSON.stringify(obj));
                    }
                }
            })

            Property.create(formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully added',
                        confirmButtonText: 'Okay',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$router.push({path: `/locations/properties?id=${this.form.location_id}`});
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