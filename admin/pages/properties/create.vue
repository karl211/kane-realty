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

// import _ from 'lodash'
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
export default {
    name: "ReservationCreate",
    data: vm => ({
        currencyMask: createNumberMask({
            prefix: '',
            allowDecimal: false,
            includeThousandsSeparator: true,
            allowNegative: false,
            allowLeadingZeroes: false
        }),
        error: {},
        form: {
            // buyer_id: null,
            // paid_at: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
            // mode_of_payment: 'Cash',
            // image: null
        },

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
      
    },

    methods: {
        cancel () {
            
        },

        submit () {
            
        }
        
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