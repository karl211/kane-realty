<template>
    <v-row>
        <v-col cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col cols="8">
            <v-row>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.post_dated_cheque"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.post_dated_cheque"
                            accept="image/*"
                            prepend-icon=""
                            label="Post Dated Cheque"
                            @change="selectFile"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.post_dated_cheque"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('post_dated_cheque')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.birth_or_marriage_certificate"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.birth_or_marriage_certificate"
                            accept="image/*"
                            prepend-icon=""
                            label="Photocopy of Marriage Certificate/Birth Certificate"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.birth_or_marriage_certificate"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('birth_or_marriage_certificate')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.picture_by_2"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.picture_by_2"
                            accept="image/*"
                            prepend-icon=""
                            label="2 pcs 2x2 picture"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.picture_by_2"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('picture_by_2')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.tax_certificate"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.tax_certificate"
                            accept="image/*"
                            prepend-icon=""
                            label="Community Tax Certificate"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.tax_certificate"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('tax_certificate')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.proof_of_billing"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.proof_of_billing"
                            accept="image/*"
                            prepend-icon=""
                            label="Proof of Billing"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.proof_of_billing"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('proof_of_billing')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.valid_id"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.valid_id"
                            accept="image/*"
                            prepend-icon=""
                            label="2 Valid ID's (Company and Government)"
                            class="required"
                            hide-details="auto"
                            :error-messages="error.valid_id"
                        ></v-file-input>
                        
                    </div>
                    <br>
                    <v-img
                        v-if="form.valid_id"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('valid_id')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.tin"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.tin"
                            accept="image/*"
                            prepend-icon=""
                            label="Tax Identification Number"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.tin"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('tin')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.house_sketch"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.house_sketch"
                            accept="image/*"
                            prepend-icon=""
                            label="House Sketch"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.house_sketch"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('house_sketch')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.picture_by_1"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.picture_by_1"
                            accept="image/*"
                            prepend-icon=""
                            label="3 pcs 1x1 picture"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.picture_by_1"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('picture_by_1')"
                    />
                </v-col>
                <v-col cols="6">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="form.spa"
                            readonly
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-model="form.spa"
                            accept="image/*"
                            prepend-icon=""
                            label="SPA (with Consular Seal if notarized abroad)"
                        ></v-file-input>
                    </div>
                    <br>
                    <v-img
                        v-if="form.spa"
                        contain
                        max-height="250"
                        max-width="500"
                        :src="url('spa')"
                    />
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
        componentName: 'documents',
        error: {},
        form: {
            valid_id: null
        }
    }),

    watch: {
        form: {
            handler(val){
                this.clear()
                this.$emit('documents', val)
            },
            deep: true
        }
    },

    methods: {
        selectFile (file) {
            console.log(file)
        },

        
    },
}
</script>