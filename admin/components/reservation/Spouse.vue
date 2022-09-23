<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="6">
                    <v-text-field
                        label="Last name"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6"></v-col>
                <v-col cols="6">
                    <v-text-field
                        label="First name"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6"></v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Middle name"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6"></v-col>
                <v-col cols="6">
                    <v-text-field
                        label="Suffix"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6"></v-col>
                <v-col cols="3">
                    <v-text-field
                        label="Date of Birth"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-select
                        :items="[]"
                        label="Gender"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        label="TIN"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        label="Contact Number"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
    export default {
      name: "SpouseCreate",
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