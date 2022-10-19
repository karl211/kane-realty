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
                <v-col cols="3">
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
                <v-col cols="3">
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
                <v-col cols="3">
                    <v-text-field
                        v-model="form.tin"
                        label="TIN"
                        required
                        dense
                        outlined
                        hide-details="auto"
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        v-model="form.contact_number"
                        label="Contact Number"
                        required
                        dense
                        outlined
                        hide-details="auto"
                        :error-messages="error.contact_number"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
import ReservationMixin from "~/mixins/ReservationMixin.js"
export default {
    name: "CommonInformationCreate",
    mixins: [ReservationMixin],
    props: {
        title: {
            type: String,
            default: ''
        },
        emitKey: {
            type: String,
            default: ''
        },
        isResetSpouse: {
            type: Boolean,
            default: false
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
        resetSpouse: false,
        componentName: '',
        error: {},
        form: {
            last_name: null,
            first_name: null,
            middle_name: null,
            date_of_birth: null,
            gender: null,
            tin: null,
            contact_number: null,
        }
    }),

    watch: {
        isResetSpouse (data) {
            this.componentName = 'spouseInformation'
            this.clear()
        },

        form: {
            handler(val){
                this.clear()
                this.$emit(this.emitKey, val)
            },
            deep: true
        },

        menu (val) {
            val && setTimeout(() => (this.activePicker = 'YEAR'))
        },
    },

    created () {
        this.resetSpouse = this.isResetSpouse
        this.componentName = this.emitKey
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
            this.form.date_of_birth = date
            this.$refs.menu.save(date)
        },
    },
}
</script>