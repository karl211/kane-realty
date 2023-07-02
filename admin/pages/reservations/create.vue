<template>
    <v-container>
        <v-card>
            <v-toolbar-title class="pa-10 pt-10 pb-5">
                <h2><v-icon large>mdi-home-plus</v-icon> Add Reservation</h2>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-form>
                <v-container class="pa-10">
                    <ReservationChooseProperty :errors="errors" @chooseProperty="updateForm($event, 'chooseProperty')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>

                    <ReservationPersonalInformation title="Personal Information" :errors="errors" @inputPersonalInformation="updateForm($event, 'personalInformation')" @onChangeCivilStatus="handleCivilStatus"/>

                    <v-expand-transition>
                        <div v-if="isShowSpouseInformation">
                            <br>
                            <v-divider></v-divider>
                            <br>
                            
                            <ReservationCommonInformation  title="Spouse' Information" emit-key="spouseInformation" :is-reset-spouse="resetSpouse" :errors="errors" @spouseInformation="updateForm($event, 'spouseInformation')"/>
                        </div>
                    </v-expand-transition>
                    
                    <br>
                    <v-divider></v-divider>
                    <br>

                    <ReservationEmploymentStatus title="Employment Status" :errors="errors" @employmentStatus="updateForm($event, 'employmentStatus')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation title="Co-Borrower's Information" emit-key="coBorrowerInformation" :errors="errors" @coBorrowerInformation="updateForm($event, 'coBorrowerInformation')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation title="Attorney In-Fact's Information" emit-key="attorneyInformation" :errors="errors" @attorneyInformation="updateForm($event, 'attorneyInformation')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationDocument title="Documents" :errors="errors" @documents="updateForm($event, 'documents')"/>
                    <br>
                </v-container>
            </v-form>
        </v-card>
        <div class="d-flex justify-end">
            <v-btn
                class="ml-2"
                elevation="0"
                color="warning"
            >
                Cancel
            </v-btn>
            <v-btn
                class="ml-2"
                elevation="0"
                color="primary"
                @click="submit"
            >
                Submit
            </v-btn>
        </div>
        <br>
    </v-container>
</template>
<script>
import Swal from 'sweetalert2'
import { Reservations } from '../../services/reservations'
export default {
    name: "ReservationCreate",
    data: vm => ({
        resetSpouse: false,
        isShowSpouseInformation: false,
        errors: {},
        form: {
            branch_id: null,
            chooseProperty: {},
            personalInformation: {},
            spouseInformation: {},
            coBorrowerInformation: {},
            attorneyInformation: {},
            employmentStatus: {},
            documents: {}
        }
    }),

    methods: {
        handleCivilStatus (data) {
            if (data !== 'Single') {
                this.isShowSpouseInformation = true
            } else {
                this.isShowSpouseInformation = false
            }
            this.resetSpouse = !this.resetSpouse
        },

        updateForm (form, key) {
            this.form[key] = form
        },

        submit () {
            const formData = new FormData()

            this.form.chooseProperty.contract_price = this.formatAmount(this.form.chooseProperty.contract_price)
            this.form.chooseProperty.monthly_amortization = this.formatAmount(this.form.chooseProperty.monthly_amortization)

            this.form.branch_id = localStorage.getItem('branch')
            Object.entries(this.form).forEach(([key, obj]) => {
                if (obj) {
                    if (key === 'documents') {
                        Object.entries(obj).forEach(([fileKey, fileVal]) => {
                            formData.append(fileKey, fileVal);
                        })
                    } else {
                        formData.append(key, JSON.stringify(obj));
                    }
                }
            })

            Reservations.create(formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {

                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully reserved',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$router.push({path: `/reservations`});
                        } 
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        error.response.data.message,
                        'warning'
                    )
                    // const self = this
                    // setTimeout(() => {
                        
                    // }, 1000);
                    this.errors = error.response.data.errors
                }
            })
            
        }
    },
}
</script>
<style>
    .w-75 {
        width: 75%;
    }
    .w-50 {
        width: 50%;
    }
    .swal2-container {
        font-family: 'Roboto' !important;
    }
</style>