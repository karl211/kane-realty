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
                                min-height="400px"
                            >
                                <v-card-text class="text-left">
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select
                                                v-model="form.branch_id"
                                                :items="branches"
                                                label="Branch"
                                                required
                                                class="required"
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
                                                class="required"
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
                                            <v-select
                                                v-model="form.type"
                                                :items="['Lot only', 'House & Lot']"
                                                label="Type"
                                                required
                                                class="required"
                                                dense
                                                outlined
                                                hide-details="auto"
                                                :error-messages="error.type"
                                            ></v-select>
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
import { Location } from '../../services/locations'
// import { Auth } from '../../../services/auth'
export default {
    name: "LocationCreate",
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
           
        },
        branches: [],
    }),

    watch: {
        form() {
            this.clear()
        }
    },

    created () {
        this.getBranches()
    },

    methods: {
        getBranches() {
            Location.branches().then((response) => {
                if (response.data) {
                    this.branches = response.data.data.map(function(data) {
                        return {
                            text: data.branch,
                            value: data.id
                        }
                    })
                }
            });
        },

        cancel () {
            
        },

        submit () {
            Location.create(this.form).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully saved',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$router.push({path: `/locations`});
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