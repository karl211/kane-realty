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
                            v-model="document.file_name"
                            accept="image/*"
                            prepend-icon=""
                            :label="document.label"
                            @change="selectFile($event, document)"
                        ></v-file-input>
                        
                        <v-btn 
                            v-if="document.file_url"
                            :href="document.file_url"
                            class="mt-4"
                            plain
                            target="_blank"
                            download>
                            <v-icon class="pointer download-wrap">
                                mdi-download-box
                            </v-icon>
                        </v-btn>
                        
                        <!-- <a v-if="document.file_url" download="custom-filename.jpg" :href="document.file_url" title="ImageName">
                            <v-icon class="pointer download-wrap">
                                mdi-download-box
                            </v-icon>
                        </a> -->
                        
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
        this.files = this.documents 
        if (this.isModal) {
            this.colSize = "12"
        }

        if (this.files.length) {
            this.files.forEach(document => {
                for (const i in this.form) {
                    console.log(document)
                    if (document.key === i && document.value) {
                        this.form[i] = document.value
                    }
                }
            })
        }

    },

    methods: {
        selectFile (file, document) {
            console.log(file)
            if (!file) {
                document.value = false
            }
            this.form[document.key] = file
            document.file_url = file
            this.$emit('documents', this.form)
        },

        download (document) {
            console.log(document)
        },

        url(url) {
            if (!url) return;

            if (typeof url === 'object') {
                return URL.createObjectURL(url);
            } else {
                return url
            }
        }
        
    },
}
</script>
<style>
    .download-wrap {
        font-size: 35px;
    }
</style>