<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.last_name"
                        label="Last name"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.last_name"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0"></v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.first_name"
                        label="First name"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.first_name"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0"></v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.middle_name"
                        label="Middle name"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.middle_name"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0"></v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.suffix"
                        label="Suffix"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0"></v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.email"
                        label="Email"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.email"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0"></v-col>
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
                            hide-details="auto"
                            :error-messages="error.date_of_birth"
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
                        hide-details="auto"
                        :error-messages="error.gender"
                    ></v-select>
                </v-col>
                <v-col cols="4">
                    <v-select
                        v-model="form.civil_status"
                        :items="civil_statuses"
                        label="Civil Status"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.civil_status"
                        @change="selectCivilStatus"
                    ></v-select>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.religion"
                        label="Religion"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.religion"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.tin"
                        label="TIN"
                        required
                        dense
                        outlined
                        hide-details="auto"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="form.address"
                        label="Address"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.address"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.zip_code"
                        label="Zip code"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.zip_code"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.contact_number"
                        label="Contact no."
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.contact_number"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.facebook_url"
                        label="Facebook URL Profile"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0">
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
import ReservationMixin from "~/mixins/ReservationMixin.js"

export default {
    name: "ReservationCreate",
    mixins: [ReservationMixin],
    props: {
        title: {
            type: String,
            default: ''
        },
        errors: {
            type: Object,
            default: () => {}
        }
    },
    data: vm => ({
        activePicker: null,
        date: null,
        menu: false,
        componentName: 'personalInformation',
        civil_statuses: ['Single', 'Married', 'Widow', 'Annulled', 'Separated with pending case', 'Separated with case not yet filed', 'Separated with final court order'],
        error: {},
        form: {
            last_name: null,
            first_name: null,
            middle_name: null,
            email: null,
            date_of_birth: null,
            gender: null,
            civil_status: null,
            religion: null,
            tin: null,
            address: null,
            zip_code: null,
            contact_number: null,
            facebook_url: null,
            instagram_url: null,
        }
    }),

    watch: {
        form: {
            handler(val){
                this.clear()
                this.$emit('inputPersonalInformation', this.form)
            },
            deep: true
        },

        menu (val) {
            val && setTimeout(() => (this.activePicker = 'YEAR'))
        },
    },

    methods: {
        selectDate (val) {
            this.form.date_of_birth = this.formatDate(val)
        },

        save (date) {
            this.form.date_of_birth = this.formatDate(date)
            this.$refs.menu.save(this.formatDate(date))
        },

        selectCivilStatus (data) {
            this.$emit('onChangeCivilStatus', data)
        }
    },
}
</script>