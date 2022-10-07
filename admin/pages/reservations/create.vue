<template>
    <v-container>
        <v-card>
            <v-toolbar-title class="pa-10 pt-10 pb-5">
                <h2><v-icon large>mdi-home-plus</v-icon> Add Reservation</h2>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-form>
                <v-container class="pa-10">
                    <ReservationChooseProperty @chooseProperty="updateForm($event, 'chooseProperty')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>

                    <ReservationPersonalInformation title="Personal Information" @inputPersonalInformation="updateForm($event, 'personalInformation')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation title="Spouse' Information" emit-key="spouseInformation" @spouseInformation="updateForm($event, 'spouseInformation')"/>
                    
                    <br>
                    <v-divider></v-divider>
                    <br>

                    <ReservationEmploymentStatus title="Employment Status" @employmentStatus="updateForm($event, 'employmentStatus')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation title="Co-Borrower's Information" emit-key="coBorrowerInformation" @coBorrowerInformation="updateForm($event, 'coBorrowerInformation')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationCommonInformation title="Attorney In-Fact's Information" emit-key="attorneyInformation" @attorneyInformation="updateForm($event, 'attorneyInformation')"/>

                    <br>
                    <v-divider></v-divider>
                    <br>
                    
                    <ReservationDocument title="Documents" @documents="updateForm($event, 'documents')"/>
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
import { Reservations } from '../../services/reservations'
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
        updateForm (form, key) {
            

            // formData.append(key, JSON.stringify(form))

            // if (key === 'documents') {
                
            // }

            // Object.entries(form).forEach(([objkey, val]) => {
            //     if (val) {
            //         // const obj = {}
            //         // obj[objkey] = val
            //         // formData.append(`${key}_${objkey}`, obj);

            //         formData.append(objkey, val);
            //     }
            // })

            // formData.append(key, JSON.stringify(form));

            // if (key === 'spouseInformation') {
            //     const newForm = {}

            //     for (const key in form) {
            //        console.log(key)
            //        newForm[`spouse_${key}`] = form[key]
            //     }

            //     form = newForm
            // }

            // this.form = formData
            this.form[key] = form
        },

        submit () {
            const formData = new FormData()

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
                console.log(response.data)
                // this.locations = response.data.data
                // this.mapLocations = this.locations.map(function(data) {
                //     return {
                //         text: data.location,
                //         value: data.id
                //     }
                // })
            });
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