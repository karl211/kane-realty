<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="6">
                    <v-file-input
                        accept="image/*"
                        label="Post Dated Cheque"
                    ></v-file-input>
                    <v-checkbox
                    label="Post Dated Cheque"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="Photocopy of Marriage Certificate/Birth Certificate"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="2 pcs 2x2 picture"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="Community Tax Certificate"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="Proof of Billing"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="2 Valid ID's (Company and Government)"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="Tax Identification Number"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="House Sketch"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="3 pcs 1x1 picture"
                    hide-details
                    ></v-checkbox>
                </v-col>
                <v-col cols="6">
                    <v-checkbox
                    label="SPA (with Consular Seal if notarized abroad)"
                    hide-details
                    ></v-checkbox>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
    export default {
      name: "ReservationCreate",
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