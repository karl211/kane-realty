<template>
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
                                <v-col cols="9">
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
                                <v-col cols="3">
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
                                <v-col cols="3">
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
                                <v-col cols="3">
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
                                <v-col cols="9">
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
                                <v-col cols="5">
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
                                <v-col cols="4">
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
                                <v-col cols="9">
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
                                <v-col cols="3">
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
                                <v-col cols="3">
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
                                <v-col cols="9">
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
                                <v-col cols="9">
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
</template>
<script>
import { Reservations } from '../../services/reservations'
import ReservationMixin from "~/mixins/ReservationMixin.js"

export default {
    name: "ReservationCreate",
    mixins: [ReservationMixin],
    props: {
        size: {
            type: String,
            default: 'lg'
        },

        property: {
            type: Object,
            default: () => {}
        },
        
        errors: {
            type: Object,
            default: () => {}
        }
    },
    data: vm => ({
        dateFormatted: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        date: false,
        locations: [],
        networks: [],
        mapLocations: [],
        mapNetworks: [],
        blocks: [],
        lots: [],
        phases: [],
        salesManagers: [],
        salesAgents: [],
        componentName: 'chooseProperty',
        colSize: "8",
        error: {},
        form: {
            transaction_at: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            selectedLocation: {
                location_id: null,
                block: null,
                lot: null,
                phase: null
            },
            contract_price: null,
            monthly_amortization: null,
            term: null,
            network_id: null,
            sales_manager_id: null,
            sales_agent_id: null,
        }
        
    }),

    watch: {
        // size (val) {
        //     console.log(val)
        //     if (val === 'sm') {
        //         this.colSize = "12"
        //     }
        // },

        form: {
            handler(val){
                this.clear()
                this.$emit('chooseProperty', val)
            },
            deep: true
        },
        'form.transaction_at'(val) {
            this.dateFormatted = this.formatDate(val)
        },
    },

    created () {
        console.log(this.property)
    },

    mounted () {
        if (this.size === 'sm') {
            this.colSize = "12"
        }

        this.getLocations()
        this.getNetworks()
    },

    methods: {

        getLocations () {
            Reservations.locations().then((response) => {
                this.locations = response.data.data
                this.mapLocations = this.locations.map(function(data) {
                    return {
                        text: data.location,
                        value: data.id
                    }
                })
            });
        },

        getNetworks () {
            Reservations.networks().then((response) => {
                this.networks = response.data.data
                this.mapNetworks = this.mapArray(this.networks, 'name', 'id')
            });
        },

        mapArray(arr, text, value) {
            return [...new Set(arr.map(function(data) {
                return {
                    text: data[text],
                    value: data[value]
                }
            }))]
        },

        getBlocks (properties) {
            return [...new Set(properties.map(item => item.block))]
        },

        getLots (properties) {
            const self = this

            return [...new Set(properties.filter(function(item) {
                return item.block === self.form.selectedLocation.block
            }).map(item => item.lot))]
        },

        getPhases (properties) {
            const self = this

            return [...new Set(properties.filter(function(item) {
                    return item.block === self.form.selectedLocation.block && item.lot === self.form.selectedLocation.lot
            }).map(item => item.phase))]
        },

        selectLocation(value, type) {
            this.form.selectedLocation[type] = value
            
            const self = this
            const location = this.locations.find(function(data) {
                return data.id === self.form.selectedLocation.location_id
            })

            this.blocks = this.mapArray(location.properties, 'block', 'block')

            this.lots = this.getLots(location.properties)

            this.phases = this.getPhases(location.properties)

            if (type === 'lot') {
                const propery = location.properties.find(function(data) {
                    return data.block === self.form.selectedLocation.block && data.lot === self.form.selectedLocation.lot
                })

                if (propery) {
                    this.form.contract_price = Number(propery.contract_price).toLocaleString()
                    this.form.monthly_amortization = Number(propery.default_monthly_amortization).toLocaleString()
                    this.form.term = propery.term
                }
            }
        },

        selectNetwork(value) {
            this.form.sales_manager_id =  null
            this.form.sales_agent_id =  null
            this.salesManagers = []

            this.form.network_id = value

            if (value) {
                const network = this.networks.find(function(data) {
                    return data.id === value
                })

                this.salesManagers = this.mapArray(network.sales_managers, 'name', 'id')
            }
        },

        selectManager(value) {
            this.form.sales_agent_id =  null
            this.salesAgents = []
            this.form.sales_manager_id = value

            if (value) {
                const self = this
                const network = this.networks.find(function(data) {
                    return data.id === self.form.network_id
                })
                
                const manager = network.sales_managers.find(function(item) {
                    return item.id === self.form.sales_manager_id
                })

                if (manager.sales_manager_agents.length) {
                    this.salesAgents = this.mapArray(manager.sales_manager_agents, 'name', 'id')
                }
            }
        },

        selectAgent(value) {
            this.form.sales_agent_id = value
        },
    },
}
</script>
<style>
    /* .v-input__icon .v-input__icon--prepend-inner i {
        font-size: 20px !important;
    } */
    .mdi-currency-php {
        font-size: 20px !important;
    }
</style>