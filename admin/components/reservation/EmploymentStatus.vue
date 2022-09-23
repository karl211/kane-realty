<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="6">
                    <v-radio-group 
                        class="mt-0"
                        hide-details
                    >
                        <h5 class="pb-2">Locally Employed</h5>
                        <v-radio
                            v-for="(val, key) in local"
                            :key="key"
                            :label="`${val.label}`"
                            :value="key"
                        ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="6">
                    <v-radio-group 
                        class="mt-0"
                        hide-details
                    >
                        <h5 class="pb-2">OFW</h5>
                        <v-radio
                            v-for="(val, key) in ofw"
                            :key="key"
                            :label="`${val.label}`"
                            :value="key"
                            hide-details
                        ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Company Name"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Location of Work"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        label="Industry/Type of Work"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        label="Date Employed"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        label="Profession"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        label="Position/Level"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-divider></v-divider>
                    <v-checkbox
                        label="FOR BUSINESS OWNERS: (Please Check if applicable)"
                        hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Business Name"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Business Location"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Industry"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Date of Establishment"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-radio-group 
                        class="mt-0" 
                        hide-details
                    >
                        <h5 class="pb-2">Business Type</h5>
                        <div class="d-flex">
                            <v-radio
                                v-for="(val, key) in businessTypes"
                                class="ma-2"
                                :key="key"
                                :label="`${val.label}`"
                                :value="key"
                                hide-details
                            ></v-radio>
                        </div>
                    </v-radio-group>
                </v-col>
            </v-row>
            
         
        </v-col>
    </v-row>
</template>
<script>
    export default {
      name: "EmploymentStatusCreate",
      props: {
            title: {
                type: String,
                default: ''
            }
        },
      data: vm => ({
            date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            dateFormatted: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
            menu1: false,
            local: [
                {
                    label: 'Private'
                },
                {
                    label: 'Government'
                },
                {
                    label: 'Self-Employed'
                },
            ],
            ofw: [
                {
                    label: 'Sea Based'
                },
                {
                    label: 'Land Based'
                },
            ],
            businessTypes: [
                {
                    label: 'Single Proprietorship'
                },
                {
                    label: 'Partnership'
                },
                {
                    label: 'Corporation'
                },
            ],
        }),

        watch: {
            date (val) {
                this.dateFormatted = this.formatDate(this.date)
            },
        },

        methods: {
            formatDate (date) {
                if (!date) return null

                const [year, month, day] = date.split('-')
                return `${month}/${day}/${year}`
            },
        },
    }
</script>