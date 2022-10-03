<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.last_name"
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
                        v-model="form.first_name"
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
                        v-model="form.middle_name"
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
                        v-model="form.suffix"
                        label="Suffix"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6"></v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.email"
                        label="Email"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6"></v-col>
                <v-col cols="4">
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                            v-model="form.date_of_birth"
                            label="Date of Birth"
                            persistent-hint
                            v-bind="attrs"
                            v-on="on"
                            dense
                            outlined
                            hide-details
                            
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            v-model="date"
                            :active-picker.sync="activePicker"
                            :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                            min="1950-01-01"
                            @change="save"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="4">
                    <v-select
                        v-model="form.gender"
                        :items="['Male', 'Female']"
                        label="Gender"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="4">
                    <v-text-field
                        v-model="form.civil_status"
                        label="Civil Status"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.religion"
                        label="Religion"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.tin"
                        label="TIN"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="form.address"
                        label="Address"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.zip_code"
                        label="Zip code"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.contact_number"
                        label="Contact no."
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.facebook_url"
                        label="Facebook URL Profile"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.instagram_url"
                        label="Instagram URL Profile"
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
    name: "ReservationCreate",
    props: {
        title: {
            type: String,
            default: ''
        }
    },
    data: vm => ({
        activePicker: null,
        date: null,
        menu: false,
        form: {
            date_of_birth: null
        }
    }),

    watch: {
        form: {
            handler(val){
                this.$emit('inputPersonalInformation', val)
            },
            deep: true
        },

        menu (val) {
            val && setTimeout(() => (this.activePicker = 'YEAR'))
        },
    },

    methods: {
        formatDate (date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${month}/${day}/${year}`
        },

        selectDate (val) {
            this.form.date_of_birth = this.formatDate(val)
        },

        save (date) {
            this.form.date_of_birth = this.formatDate(date)
            this.$refs.menu.save(this.formatDate(date))
        },
    },
}
</script>