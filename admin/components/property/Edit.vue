<template>
    <v-dialog
        v-model="show"
        width="600px"
    >
        <!-- <v-btn @click="close">
        Close
        </v-btn> -->
        <v-card>
                <v-toolbar-title class="pa-10 pt-10 pb-5">
                    <h2><v-icon large>mdi-cash-clock</v-icon> Edit Property</h2>
                </v-toolbar-title>
                <v-divider></v-divider>
                <v-form>
                    <v-container class="pa-10">
                        <v-row>
                            <v-col cols="12">
                                <v-card
                                    class="m-auto"
                                >
                                    <v-card-text class="text-left">
                                        <v-row>
                                            <v-col cols="12">
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
                                            <v-col cols="4">
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
                                            <v-col cols="4">
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
                                            <v-col cols="4">
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
                                            <v-col cols="12">
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
                                            <v-col cols="6">
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
                                                    v-mask="currencyMask"
                                                    label="Term"
                                                    required
                                                    class="required"
                                                    dense
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="error.term"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="3">
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
                                        </v-row>
                                        <!-- <v-row>
                                            <v-col cols="12">
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
                                        </v-row> -->
                                        <v-row>
                                            
                                            <!-- <v-col cols="4">
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
                                            <v-col cols="4">
                                                <v-text-field
                                                    v-model="form.model"
                                                    label="Model"
                                                    required
                                                    dense
                                                    outlined
                                                    hide-details="auto"
                                                    :error-messages="error.model"
                                                ></v-text-field>
                                            </v-col> -->
                                        </v-row>
                                        <!-- <v-row>
                                            <v-col cols="12">
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
                                        </v-row> -->
                                        <v-row>
                                        <v-col cols="12">
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
                <div class="d-flex justify-end mr-10">
                    <v-btn
                        class="ml-2"
                        elevation="0"
                        color="warning"
                        @click="close"
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
                
            </v-card>
           
            
    </v-dialog>
</template>
<script>
import Swal from 'sweetalert2'
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import { Property } from '../../services/properties';
export default {
    name: "EditProperty",
    props: {
        value: {
            type: Boolean,
            default: false
        },

        property: {
            type: Object,
            default: () => {}
        },

        statuses: {
            type: Array,
            default: () => []
        },
    },

    data: vm => ({
        currencyMask: createNumberMask({
            prefix: '',
            allowDecimal: false,
            includeThousandsSeparator: true,
            allowNegative: false,
            allowLeadingZeroes: false,
        }),

        activeColor: 'red',

        error: {},
        form: {
            location_id: null,
            location: null,
            lot: null,
            block: null,
            phase: null,
            term: null,
            lot_size: null,
            default_monthly_amortization: null,
            contract_price: null,
            discount: null,
            is_edit_block_lot: false,
            
            status: 'active',
        },
    }),

    computed: {
        show: {
            get() {
                return this.value
            },
            set(value) {
                this.$emit('close');
            }
        }
    },

    watch: {
        value(data) {
            this.dialog = data

      
        },
        property(data) {
            this.form.location = data.location.location
            this.form.block = data.block
            this.form.lot = data.lot
            this.form.phase = data.phase
            this.form.term = data.term
            this.form.lot_size = data.lot_size
            
            this.currencyMask = null
            this.form.default_monthly_amortization = data.default_monthly_amortization
            this.form.contract_price = data.contract_price
            this.form.discount = data.discount
            this.form.status = data.status

            this.selectStatus(data.status)

            this.$nextTick(() => {
                this.currencyMask = createNumberMask({
                    prefix: '',
                    allowDecimal: false,
                    includeThousandsSeparator: true,
                    allowNegative: false,
                    allowLeadingZeroes: false,
                })
            })

            
         
        },
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

    created() {
        
    },

    methods: {
        close() {
            this.$emit('close');
        },

        selectStatus (data) {
            switch (data) {
                case 'Available':
                    this.activeColor = 'green'
                    break;
                case 'Reserved':
                    this.activeColor = 'orange'
                    break;
                case 'Cancelled':
                    this.activeColor = 'red'
                    break;
                case 'For Assume':
                    this.activeColor = 'blue'
                    break;
            }
        },

        submit () {
            const formData = new FormData()

            this.form.default_monthly_amortization = this.formatAmount(this.form.default_monthly_amortization)
            this.form.contract_price = this.formatAmount(this.form.contract_price)
            
            if (parseInt(this.form.block) !== this.property.block || parseInt(this.form.lot) !== this.property.lot) {
                this.form.is_edit_block_lot = true
            } else {
                this.form.is_edit_block_lot = false
            }

            Object.entries(this.form).forEach(([key, obj]) => {
                if (obj) {
                    if (key === 'image') {
                        formData.append(key, obj);
                    } else {
                        formData.append(key, JSON.stringify(obj));
                    }
                }
            })

            Property.update(this.property.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully updated',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.close()

                            this.$emit('refresh');
                        } 
                    })
                }
            }).catch(error => {
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        error.response.data.message,
                        'warning'
                    )
                    this.errors = error.response.data.errors
                }
            })
        },
    },

}
</script>