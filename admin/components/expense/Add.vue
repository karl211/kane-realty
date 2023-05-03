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
                        <v-autocomplete
                            v-model="form.network_id"
                            :items="particulars"
                            label="Particular"
                            required
                            dense
                            outlined
                            hide-details
                            @change="selectNetwork"
                        ></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6" class="pb-0">
                        <v-text-field
                            v-model="form.term"
                            label="Receipt No."
                            class="required"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.term"
                        ></v-text-field>
                    </v-col>
                </v-row>
                
                <v-row>
                    <v-col cols="6" class="pb-0">
                        <v-select
                            v-model="form.sales_agent_id"
                            :items="expenses"
                            label="Select Expense"
                            required
                            dense
                            outlined
                            hide-details
                            @change="selectAgent"
                        ></v-select>
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <v-text-field
                            v-model="form.contract_price"
                            prepend-inner-icon="mdi-currency-php"
                            label="Amount"
                            class="required"
                            required
                            dense
                            outlined
                            hide-details="auto"
                            :error-messages="error.contract_price"
                            readonly
                        ></v-text-field>
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
        expenses: [
            "AGENTS COMMISSION SAN VICENTE",
            "AGENTS COMMISSION TINIWISAN",
            "SALARY",
            "OFFICE RENTAL EXPENSE",
            "UTILITY EXPENSE",
            "FUEL & GASOLINE",
            "OFFICE/MATERIALS & SUPPLIES",
            "REPAIR & MAINTENANCE",
            "REPRESENTATION EXPENSE",
            "RETAINER'S FEE",
            "LOT CANCELLATION",
            "WEB SYSTEM DEVELOPMENT",
            "OTHERS" ,
        ],
        particulars: [
            "JOEL AMPIT 2ND COMMISION TINIWISAN 2 LOTS",
            "MARIA CORAZON DONOSO COMMISSION SAN VICENTE",
            "GLOBE INTERNET PAYMENT DECEMBER 2021 (SEVEN ELEVEN)",
            "DC TECH INTERNET (SHANGRILA) JAN. 2022",
            "PRINTER REPAIR",
            "RODELIE MAE ESTORCO COMMISION TINIWISAN 1 LOT",
            "GARBAGE DISPOSAL",
            "JESSIE MURILLO CASH ASSISTANCE FOR CANCER TREATMENT",
            "OFFICE/BUILDING RENTAL ",
            "RENEROSE AUTOR SALARY CASH ADVANCE",
            "C/O ARNEL LIMANAG PAYMENT FOR USANA",
            "JESSIE MURILLO COMMISSION-TINIWISAN 2 LOTS C/O VIVIAN BAGASBAS",
            "GLOBE INTERNET PAYMENT JANUARY 2022 (SEVEN ELEVEN)",
            "ANECO & BCWD PAYMENT",
            "JESSIE MURILLO COMMISSION-TINIWISAN 8 LOTS C/O VIVIAN BAGASBAS",
            "ANTONIA ESTORCO COMMISSION-TINIWISAN 4 LOTS C/O EDWARD ESTORCO",
            "JENNETTE ATIENZA COMMISSION-TINIWISAN 2 LOTS",
            "SALARY JANUARY 1-31, 2022",
            "HONEYBEB TRILLO DAILY FARE",
            "HONEYBEB TRILLO TRAVEL ALLOWANCE SAN FRANCISCO, ADS",
            "SHOPEE ITEMS (CALENDAR, NOTEBOOK, BALLPEN)",
            "DC TECH INTERNET (SHANGRILA) FEB. 2022",
            "PALAWAN EXPRESS KAREN JOY BALDICANTOS",
            "CENDYLLE OCCIDA PAYMENT FOR CULINARY/FUEL/ALLOWANCE",
            "BROKERAGE SEMINAR-FEE C/O DARYLLE OCCIDA",
            "SALARY FEBRUARY 1-15, 2022",
            "BOOKKEEPER RETAINER'S FEE (JANUARY 2022)",
            "MAYOR'S PERMIT C/O JEHED BOOKKEEPING & SERVICES",
            "HONEYBEB TRILLO CASH ADVANCE (BARISTA)",
            "CASH DONATION JESSIE MURILLO",
            "HONEYBEB TRILLO FARE (FEB. 24-MAR 2, 2022)",
            "CASH OUT C/O CENDYLLE CHIRL OCCIDA (CULINARY EXPENSE)",
            "OFFICE RENTAL CDO C/O ANTE GAGA",
            "JRS EXPRESS DELIVERY CHARGE - TRANSPORT OF RECEIPTS TO ARNIE VALENCIA",
            "MEDICINE FOR MR. & MRS. MONCHITO OCCIDA C/O KUYA JO",
            "SNACKS C/O DARYLLE OCCIDA",
            "SALARY FEBRUARY 16-28, 2022",
            "MR. & MRS MONCHITO OCCIDA 2D ECHO",
            "GROCERY C/O DARYLLE OCCIDA",
            "BCWD PAYMENT ",
            "ANECO PAYMENT FEBRUARY 2022",
            "RENEROSE AUTOR SALARY CASH ADVANCE MAR.1-15, 2022",
            "HONEYBEB TRILLO CASH ADVANCE MAR.1-15, 2022",
            "HONEYBEB TRILLO FARE EXPENSE",
            "DC TECH INTERNET (SHANGRILA) MARCH 2022",
            "SALARY MARCH 1-15, 2022",
            "STAFF UNIFORM (YORKSHOP TAILORING)",
            "FARE",
            "ANTONIA ESTORCO COMMISSION-TINIWISAN 1 LOT C/O RODELIE ESTORCO",
            "RENEROSE AUTOR CASH ADVANCE MAR.16-31, 2022",
            "CENDYLLE OCCIDA PAYMENT FOR BAKING/FUEL/ALLOWANCE/ETC.",
            "VIVIAN BAGASBAS COMMISSION TINIWISAN 4 LOTS-PROMO",
            "DARYLLE OCCIDA VARIOUS EXPENSE (THRU HONEYBEB TRILLO)",
            "RENEROSE AUTOR CASH ADVANCE APRIL 2022",
            "GLOBE INTERNET PAYMENT FEBRUARY 2022 (SEVEN ELEVEN)",
            "CASH OUT C/O CENDYLLE CHIRL OCCIDA (BAKING EXPENSE)",
            "BCWD PAYMENT MARCH 2022",
            "ANECO PAYMENT MARCH 2022",
            "SWIMMING LESSON PAYMENT (SABINA, ANDREI, KYLER)",
            "SALARY MARCH 1-31, 2022",
            "CASH OUT C/O MARLIE OCCIDA",
            "FAUCET REPLACEMENT",
            "CASH OUT CENDYLLE OCCIDA CDO TRIP (BAKING)",
            "HONEYBEB TRILLO CASH ADVANCE APRIL 1-15, 2022",
            "MARIZA HERNANDEZ COMMISSION TINIWISAN 1 LOT",
            "FOOD PANDA DELIVERY-MC DO",
            "STEEL RACK PAYMENT C/O DARYLLE OCCIDA VIA GCASH",
            "OFFICE RENTAL CDO VIA PALAWAN EXPRESS C/O DARLENE CAMILLE PABITO",
            "HONEYBEB TRILLO CASH ADVANCE APRIL 2022 - MAY 2022",
            "MONCHITO OCCIDA PLANE TICKET BXU-MANILA",
            "SALARY APRIL 1-15, 2022",
            "RENEROSE AUTOR CASH ADVANCE MAY 2022",
            "DARLENE CAMILLE PABITO CASH PADALA VIA PALAWAN & FARE ",
            "RENEROSE AUTOR COMMISSION TINIWISAN 1 LOT",
            "RENEROSE AUTOR CASH ADVANCE JUNE 2022",
            "AIRCON CLEANING (KOPPEL)",
            "ANECO PAYMENT APRIL 2022",
            "GLOBE INTERNET PAYMENT APRIL 2022 (7ELEVEN)",
            "FARE EXPENSE C/O RENEROSE AUTOR",
            "SALARY APRIL 16-30, 2022",
            "RACHEL AGUIRRE LOT CANCELLATION TINIWISAN (2 LOTS)",
            "DC TECH INTERNET (SHANGRILA) APRIL-MAY 2022",
            "FARE EXPENSE C/O HONEYBEB TRILLO",
            "PASSPORT FEE MARLIE & MONCHITO OCCIDA",
            "RACHEL BURNEA (SV COMMISSION)",
            "RENEROSE AUTOR CASH ADVANCE MAY 1-15, 2022",
            "SALARY MAY 1-15, 2022",
            "RENEROSE AUTOR CASH ADVANCE",
            "ANECO PAYMENT MAY 2022",
            "BCWD PAYMENT APRIL-MAY 2022",
            "GLOBE INTERNET PAYMENT MAY 2022 VIA GCASH (RENEROSE AUTOR)",
            "FARE EXPENSE HONEYBEB TRILLO",
            "SALARY FOR THE PERIOD MAY 16-31, 2022",
            "DARYLLE OCCIDA PAYMENT FOR FWD INSURANCE EXAM VIA GCASH",
            "AIRCON REPAIR",
            "HONEYBEB TRILLO CASH ADVANCE JUNE 16-31, 2022",
            "MONCHITO OCCIDA PARCEL VIA AP CARGO",
            "MARLIE OCCIDA MEDICINE",
            "HONEYBEB TRILLO CASH ADVANCE",
            "RENEROSE AUTOR FARE EXPENSE",
            "OFFICE/MATERIALS & SUPPLIES",
            "TATAY BERTO (SV COMMISSION)",
            "SALARY FOR THE PERIOD JUNE 1-15, 2022",
            "DARIUS DEL ROSARIO LOT CANCELLATION TINIWISAN (1 LOT)",
            "BONDPAPER FOR SHANGRILA RESIDENCE",
            "ERLINDA LABATA LOT CANCELLATION REFUND TINIWISAN 1 LOT",
            "DC TECH INTERNET (SHANGRILA) JUNE 2022",
            "GLOBE INTERNET PAYMENT JUNE 2022 THRU 7 ELEVEN",
            "ANECO PAYMENT JUNE  2022",
            "SALARY FOR THE PERIOD JUNE 16-30, 2022",
            "BCWD PAYMENT JUNE 2022",
            "ZEPPY PACTURAN LOT CANCELLATION REFUND (SAN VICENTE BLOCK 8 LOT 6,7)",
            "SALARY FOR THE PERIOD JULY 1-15, 2022",
            "DC TECH INTERNET (SHANGRILA) JULY 2022",
            "HOUSE RENTAL AT CEBU CITY (4 DAYS RENT) PAYMENT VIA GCASH 7/11",
            "SIGNAGE PRINTING PARTIAL PAYMENT",
            "BCWD PAYMENT JULY 2022",
            "GLOBE INTERNET PAYMENT JULY 2022 THRU 7 ELEVEN",
            "PAYMENT FOR LAUNDRY (CURTAINS)",
            "SALARY FOR THE PERIOD JULY 16-31, 2022",
            "ELLYN CANTAROS RETAINERS FEE JUNE-JULY 2022",
            "SIGNAGE FULL PAYMENT",
            "LOREN QUIJADA CANCELLATION REFUND/TINIWISAN (2 LOTS)",
            "SALARY FOR THE PERIOD AUGUST 1-15, 2022",
            "GLOBE INTERNET PAYMENT AUGUST 2022 THRU 7 ELEVEN",
            "JOVANNE MALANA LOT CANCELLATION REFUND (SAN VICENTE/2 LOTS)",
            "ANECO PAYMENT AUGUST  2022",
            "SALARY FOR THE PERIOD AUGUST 16-31, 2022",
            "DC TECH INTERNET (SHANGRILA) AUG.-SEPT. 2022",
            "KARL IRVIN MONTEADORA-WEB SYSTEM DEVELOPMENT 1ST PAYMENT",
            "HONEYBEB TRILLO TRANSPORTATION EXPENSE",
            "ENNIS CALIWAN LOT CANCELLATION REFUND (SAN VICENTE 2 LOTS)",
            "SALARY FOR THE PERIOD SEPTEMBER 1-15, 2022",
            "KARL IRVIN MONTEADORA-WEB SYSTEM DEVELOPMENT 2ND PAYMENT",
            "SALARY FOR THE PERIOD SEPTEMBER 16-30, 2022",
            "GLOBE INTERNET PAYMENT SEPTEMBER 2022 THRU 7 ELEVEN",
            "BCWD PAYMENT JULY-AUGUST 2022",
            "LUZMINDA MONTEMAYOR AGENT COMMISSION TINIWISAN 3 LOTS 1ST RELEASED",
            "LUZMINDA MONTEMAYOR AGENT COMMISSION TINIWISAN 5 LOTS 1ST RELEASED",
            "SALARY FOR THE PERIOD OCTOBER 1-15, 2022",
            "blank",
            "KARL IRVIN MONTEADORA-WEB SYSTEM DEVELOPMENT 3RD PAYMENT",
            "SALARY FOR THE PERIOD OCTOBER 16-31, 2022",
            "JACKIE CALO PAYMENT (TINIWISAN)",
            "BCWD PAYMENT SEPTEMBER 2022",
            "ANECO PAYMENT OCTOBER 2022",
            "SALARY FOR THE PERIOD NOVEMBER 1-15, 2022",
            "PURCHASE FLASH DRIVE FOR PAG-IBIG USE",
            "BIR WITHOLDING TAX PAYMENT (RENTAL)FORM 0619E VIA GCASH",
            "PHILHEALTH REMITTANCE FROM JANUARY 2020-NOVEMBER 2022 EXCLUDING PENALTIES",
            "PAG-IBIG FUND REMITTANCE JANUARY 2022-DECEMBER 2022 WITH PENALTIES",
            "LAND HOLDING PAYMENT C/O RACHEL BURNEA",
            "SALARY FOR THE PERIOD NOVEMBER 16-30, 2022",
            "ROBERTO ELLOREN LOT CANCELLATION REFUND SAN VICENTE ",
        ],
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