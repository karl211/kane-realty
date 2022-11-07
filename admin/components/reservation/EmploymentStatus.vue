<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="12" class="pb-0">
                    <v-radio-group 
                        v-model="form.employment"
                        class="mt-0"
                        hide-details="auto"
                        :error-messages="error.employment"
                    >
                        <h5 class="pb-2">Employed</h5>
                        <v-radio
                            v-for="(val, key) in local"
                            :key="key"
                            :label="`${val.label}`"
                            :value="val.label"
                        ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.company_name"
                        label="Company Name"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="pb-0">
                    <v-text-field
                        v-model="form.location_of_work"
                        label="Location of Work"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3" class="pb-0">
                    <v-text-field
                        v-model="form.type_of_work"
                        label="Industry/Type of Work"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3" class="pb-0">
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
                            label="Date Employed"
                            persistent-hint
                            v-bind="attrs"
                            v-on="on"
                            dense
                            outlined
                            hide-details
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="form.date_employed"
                            no-title
                            @input="date = false"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="3" class="pb-0">
                    <v-text-field
                        v-model="form.profession"
                        label="Profession"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="3" class="pb-0">
                    <v-text-field
                        v-model="form.position"
                        label="Position/Level"
                        required
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" class="pb-0">
                    <v-divider></v-divider>
                    <v-checkbox
                        v-model="isBusinessOwner"
                        label="FOR BUSINESS OWNERS: (Please Check if applicable)"
                        hide-details
                    ></v-checkbox>
                </v-col>
                <template v-if="isBusinessOwner">
                    <v-col cols="6" class="pb-0">
                        <v-text-field
                            v-model="form.business_name"
                            label="Business Name"
                            required
                            dense
                            outlined
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <v-text-field
                            v-model="form.business_location"
                            label="Business Location"
                            required
                            dense
                            outlined
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <v-text-field
                            v-model="form.business_industry"
                            label="Industry"
                            required
                            dense
                            outlined
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <v-text-field
                            v-model="form.business_date_establish"
                            label="Date of Establishment"
                            required
                            dense
                            outlined
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="pb-0">
                        <v-radio-group
                            v-model="form.business_type"
                            class="mt-0" 
                            hide-details
                        >
                            <h5 class="pb-2">Business Type</h5>
                            <div class="d-flex">
                                <v-radio
                                    v-for="(val, key) in businessTypes"
                                    :key="key"
                                    :label="`${val.label}`"
                                    :value="val.label"
                                    class="ma-2"
                                    hide-details
                                ></v-radio>
                            </div>
                        </v-radio-group>
                    </v-col>
                </template>
            </v-row>
            
         
        </v-col>
    </v-row>
</template>
<script>
import ReservationMixin from "~/mixins/ReservationMixin.js"
export default {
    name: "EmploymentStatusCreate",
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
        dateFormatted: '',
        date: false,
        local: [
            {
                label: 'Private'
            },
            {
                label: 'Government'
            },
            {
                label: 'OWF Sea Based'
            },
            {
                label: 'OWF Land Based'
            },
            {
                label: 'Self-Employed'
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
        isBusinessOwner: false,
        componentName: 'employmentStatus',
        error: {},
        form: {
            employment: null,
            company_name: null,
            location_of_work: null,
            type_of_work: null,
            date_employed: null,
            profession: null,
            position: null,
            isBusinessOwner: null,
            business_name: null,
            business_location: null,
            business_industry: null,
            business_date_establish: null,
            business_type: null,
        }
    }),

    watch: {
        'form.date_employed'(val) {
            console.log(val)
            this.dateFormatted = this.formatDate(val)
        },

        form: {
            handler(val){
                this.clear()
                this.$emit('employmentStatus', val)
            },
            deep: true
        }
    },

    methods: {
 
    },
}
</script>