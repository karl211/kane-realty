<template>
    <v-form ref="form" class="mx-2" lazy-validation>
        <v-row>
            <v-col v-if="size !== 'sm'" cols="4">
                <h3>Choose Property</h3>
            </v-col>

            <v-col :cols="colSize">
                <v-row>
                    <v-col cols="6" class="pb-0">
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
                                label="Date of Transaction"
                                class="required"
                                persistent-hint
                                v-bind="attrs"
                                v-on="on"
                                dense
                                outlined
                                hide-details
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="form.transaction_at"
                                no-title
                                @input="date = false"
                            ></v-date-picker>
                        </v-menu>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6" class="pb-0">
                        <v-select
                            :items="mapLocations"
                            label="Location"
                            class="required"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.selectedLocation.location_id"
                            @change="selectLocation($event, 'location_id')"
                        ></v-select>
                    </v-col>
                    <v-col cols="2" class="pb-0">
                        <v-select
                            :items="blocks"
                            label="Block"
                            class="required"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.selectedLocation.block"
                            @change="selectLocation($event, 'block')"
                        ></v-select>
                    </v-col>
                    <v-col cols="2" class="pb-0">
                        <v-select
                            :items="lots"
                            label="Lot"
                            class="required"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.selectedLocation.lot"
                            @change="selectLocation($event, 'lot')"
                        ></v-select>
                    </v-col>
                    <v-col cols="2" class="pb-0">
                        <v-select
                            :items="phases"
                            label="Phase"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.selectedLocation.phase"
                            @change="selectLocation($event, 'phase')"
                        ></v-select>
                    </v-col>
                    <v-col cols="4" class="pb-0">
                        <v-text-field
                            v-model="form.contract_price"
                            prepend-inner-icon="mdi-currency-php"
                            label="Contract Price"
                            class="required"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.contract_price"
                            readonly
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" class="pb-0">
                        <v-text-field
                            v-model="form.monthly_amortization"
                            prepend-inner-icon="mdi-currency-php"
                            label="Monthly Amortization"
                            class="required"
                            required
                            readonly
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.monthly_amortization"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" class="pb-0">
                        <v-text-field
                            v-model="form.term"
                            label="Term"
                            class="required"
                            required
                            readonly
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.term"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <v-autocomplete
                            v-model="form.network_id"
                            :items="mapNetworks"
                            label="Network"
                            required
                            dense
                            outlined
                            hide-details
                            @change="selectNetwork"
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="6" class="pb-0"></v-col>
                    <v-col cols="6" class="pb-0">
                        <v-select
                            v-model="form.sales_manager_id"
                            :items="salesManagers"
                            label="Sales Manager"
                            required
                            dense
                            outlined
                            hide-details
                            @change="selectManager"
                        ></v-select>
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <v-select
                            v-model="form.sales_agent_id"
                            :items="salesAgents"
                            label="Sales Agent"
                            required
                            dense
                            outlined
                            hide-details
                            @change="selectAgent"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
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

    mounted() {
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