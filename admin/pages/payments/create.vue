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
                            <v-text-field
                                v-model="form.last_name"
                                label="Name / Email"
                                required
                                dense
                                outlined
                                hide-details
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="3">
                            <v-card
                                class="mx-auto"
                                height="830px"
                            >
                                <br>
                                <v-img
                                    class="rounded-circle mx-auto"
                                    width="150"
                                    height="150"
                                    :src="require('@/assets/images/user.png')"
                                ></v-img>
                                
                                <v-card-text class="text-center">
                                    <h3>Marcus</h3>
                                    <p>Buyer</p>
                                </v-card-text>

                                <v-divider class="mx-4"></v-divider>

                                <v-card-text class="text-left">
                                    <div>
                                        <h3>Name:</h3>
                                        <p>Sample user</p>
                                    </div>

                                    <div>
                                        <h3>Contact no:</h3>
                                        <p>012-234-5678</p>
                                    </div>

                                    <div>
                                        <h3>E-mail:</h3>
                                        <p>marcus@minible.com</p>
                                    </div>

                                    <div>
                                        <h3>Gender:</h3>
                                        <p>Male</p>
                                    </div>

                                    <div>
                                        <h3>TIN:</h3>
                                        <p>15467034</p>
                                    </div>

                                    <div>
                                        <h3>Civil status:</h3>
                                        <p>Single</p>
                                    </div>

                                    <div>
                                        <h3>Date of Birth:</h3>
                                        <p>2017-02-19</p>
                                    </div>

                                    <div>
                                        <h3>Address:</h3>
                                        <p>172 Howe Flats Murazikville, AK 25715-8391</p>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="9">
                            <v-card
                                class="mx-auto"
                                height="830px"
                            >
                                <v-card-text class="text-left">
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.last_name"
                                                label="Date of Payment"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select
                                                :items="[]"
                                                label="Location"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="2">
                                            <v-select
                                                :items="[]"
                                                label="Block"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-select
                                                :items="[]"
                                                label="Lot"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-select
                                                :items="[]"
                                                label="Phase"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.first_name"
                                                label="AR Number"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="form.first_name"
                                                label="Amount"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-radio-group 
                                                v-model="form.type"
                                                class="mt-0 d-flex"
                                                hide-details
                                            >
                                                <h5 class="pb-2">Type of Payment</h5>
                                                <v-radio
                                                    v-for="(val, key) in local"
                                                    :key="key"
                                                    :label="`${val.label}`"
                                                    :value="val.label"
                                                ></v-radio>
                                            </v-radio-group>
                                            <br>
                                            <v-text-field
                                                v-model="form.first_name"
                                                label="Type of Payment"
                                                required
                                                dense
                                                outlined
                                                hide-details
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-radio-group 
                                                v-model="form.mode"
                                                class="mt-0 "
                                                hide-details
                                            >
                                                <h5 class="pb-2">Mode of Payment</h5>
                                                <v-radio
                                                    v-for="(val, key) in modeOfPayments"
                                                    :key="key"
                                                    :label="`${val.label}`"
                                                    :value="val.label"
                                                ></v-radio>
                                            </v-radio-group>
                                            <br>
                                            <v-text-field
                                                v-model="form.first_name"
                                                label="Mode of Payment"
                                                required
                                                dense
                                                outlined
                                                hide-details
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
// import { Reservations } from '../../services/reservations'
export default {
    name: "ReservationCreate",
    data: vm => ({
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
        form: {
            
        }
    }),

    methods: {
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
</style>