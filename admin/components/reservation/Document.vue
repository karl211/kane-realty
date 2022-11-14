<template>
    <v-row>
        <v-col v-if="!isModal" cols="4">
            <h3>{{ title }}</h3>
        </v-col>

        <v-col :cols="colSize">
            <v-row>
                <v-col cols="6" v-for="(document, key) in files" :key="key">
                    <div class="d-flex">
                        <v-checkbox
                            v-model="document.value"
                            readonly
                            color="success"
                            hide-details
                        ></v-checkbox>
                        <v-file-input
                            v-if="document.file_name"
                            v-model="document.file_name"
                            accept="image/*"
                            prepend-icon=""
                            :label="document.label"
                            hide-details="auto"
                            :error-messages="error['valid_id']"
                            @change="selectFile($event, document)"
                        ></v-file-input>
                        <v-file-input
                            v-else
                            v-model="form[document.key]"
                            accept="image/*"
                            prepend-icon=""
                            :label="document.label"
                            hide-details="auto"
                            :error-messages="error[document.key]"
                            @change="selectFile($event, document)"
                        ></v-file-input>
                        <v-btn 
                            v-if="document.file_url"
                            :href="url(document.file_url)"
                            class="mt-4"
                            plain
                            target="_blank"
                            download>
                            <v-icon class="pointer download-wrap">
                                mdi-download-box
                            </v-icon>
                        </v-btn>
                    </div>
                    <br>
                    <v-img
                        v-if="document.file_url"
                        contain
                        max-height="200"
                        max-width="400"
                        :src="url(document.file_url)"
                    />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
import Swal from 'sweetalert2'
import { Reservations } from '../../services/reservations'
import ReservationMixin from "~/mixins/ReservationMixin.js"

export default {
    name: "ReservationCreate",
    mixins: [ReservationMixin],
    props: {
        title: {
            type: String,
            default: ''
        },

        isModal: {
            type: Boolean,
            default: false
        },

        documents: {
            type: Array,
            default: () => []
        },

        errors: {
            type: Object,
            default: () => {}
        }
    },
    data: vm => ({
        componentName: 'documents',
        colSize: "8",
        error: {},
        form: {
            post_dated_cheque: null,
            birth_or_marriage_certificate: null,
            picture_by_2: null,
            tax_certificate: null,
            proof_of_billing: null,
            valid_id: null,
            tin: null,
            house_sketch: null,
            picture_by_1: null,
            spa: null,
        },
        // checkbox: {
        //     post_dated_cheque: false,
        //     birth_or_marriage_certificate: false,
        //     picture_by_2: false,
        //     tax_certificate: false,
        //     proof_of_billing: false,
        //     valid_id: false,
        //     tin: false,
        //     house_sketch: false,
        //     picture_by_1: false,
        //     spa: false,
        // },
        files: []
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

    mounted () {
        if (this.isModal) {
            this.colSize = "12"
        }

        if (this.documents.length) {
            this.files = this.documents 

            if (this.files.length) {
                this.files.forEach(document => {
                    for (const i in this.form) {
                        if (document.key === i && document.value) {
                            this.form[i] = document.value
                        }
                    }
                })
            }
        } else {
            this.fetchDocument()
        }
    },

    methods: {
        selectFile (file, document) {
            if (!file) {
                document.value = false
            }
            this.form[document.key] = file
            document.file_url = file
            this.$emit('documents', this.form)
        },

        url (url) {
            if (!url) return;

            if (typeof url === 'object') {
                return URL.createObjectURL(url);
            } else {
                return url
            }
        },

        mapDocuments (documents) {
            return  documents.map(function(data) {
                return {
                    value: false,
                    label: data.desc,
                    key: data.title,
                    file_name: null,
                    file_url: null,
                }
            })
        },

        fetchDocument () {
            Reservations.getDocuments().then((response) => {
                if (response.data) {
                    this.files = this.mapDocuments(response.data)
                }
            }).catch(error => {
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        'Something went wrong',
                        'warning'
                    )
                }
            })
        }
    },
}
</script>
<style>
    .download-wrap {
        font-size: 35px;
    }
</style>