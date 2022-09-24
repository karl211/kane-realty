<template>
    <v-container>
        <v-card>
            <v-toolbar-title class="pa-10 pt-10 pb-5">
                <h2><v-icon large>mdi-home-plus</v-icon> Add Reservation</h2>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-form>
                <v-container class="pa-10">
                    <ReservationChooseProperty @chooseProperty="chooseProperty"/>

                    <br>
                    <v-divider></v-divider>
                    <br>

                    <ReservationPersonalInformation @inputPersonalInformation="inputPersonalInformation" title="Personal Information"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation @spouseInformation="spouseInformation" emitKey="spouseInformation" title="Spouse' Information"/>
                    
                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation @coBorrowerInformation="coBorrowerInformation" emitKey="coBorrowerInformation" title="Co-Borrower's Information"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation @attorneyInformation="attorneyInformation" emitKey="attorneyInformation" title="Attorney In-Fact's Information"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationEmploymentStatus title="Employment Status"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationDocument title="Documents"/>

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
            >
                Submit
            </v-btn>
        </div>
        <br>
    </v-container>
</template>
<script>

export default {
    name: "ReservationCreate",
    data: vm => ({
        form: {
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
        chooseProperty (form) {
            this.form.chooseProperty = form
        },

        inputPersonalInformation (form) {
            this.form.personalInformation = form
        },

        spouseInformation (form) {
            this.form.spouseInformation = form
        },

        coBorrowerInformation (form) {
            this.form.coBorrowerInformation = form
        },

        attorneyInformation (form) {
            this.form.attorneyInformation = form
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
</style>