<template>
    <v-container>
        <v-row>
            <v-col cols="3">
                <BuyerInfo :buyer="buyer"/>
            </v-col>
            <v-col cols="7">
                <v-card
                    v-if="buyer"
                    class="mx-auto max-card-h"
                >
                    <v-card-title>
                        <div class="container pb-0">
                            <div class="d-flex justify-space-between">
                                <h3 class="ml-1">Properties</h3>
                                <v-dialog
                                    v-model="dialog"
                                    width="800px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            class="ml-auto"
                                            elevation="0"
                                            color="info"
                                            v-bind="attrs"
                                        v-on="on"
                                        >
                                            <v-icon>mdi-home-plus</v-icon> Add Property
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title class="pb-0 ml-6">
                                            <h3>Add Property</h3>
                                        </v-card-title>
                                        <v-form>
                                            <v-container class="px-10">
                                                <ReservationChooseProperty size="sm" :errors="errors" @chooseProperty="updateForm($event, 'chooseProperty')"/>
                                                <br>
                                                <v-divider></v-divider>
                                                <br>
                                                <div class="d-flex justify-end">
                                                    <v-btn
                                                        class="ml-2"
                                                        elevation="0"
                                                        color="warning"
                                                        @click="dialog = false"
                                                    >
                                                        Cancel
                                                    </v-btn>
                                                    <v-btn
                                                        class="ml-2"
                                                        elevation="0"
                                                        color="primary"
                                                        @click="updateOrCreateProperty"
                                                    >
                                                        Submit
                                                    </v-btn>
                                                </div>
                                            </v-container>
                                        </v-form>
                                    </v-card>
                                </v-dialog>
                            </div>
                        </div>
                    </v-card-title>

                    <v-card-text class="text-left max-overflow-h-2 overflow-y-auto">
                        <v-row justify="center" class="ma-0">
                            <!-- <v-expansion-panels accordion v-model="panel" multiple> -->
                            <v-expansion-panels accordion multiple>
                                <div class="">
                                    <v-expansion-panel v-for="(item,i) in buyerReservations" :key="i" class="mt-1">
                                        <v-expansion-panel-header>
                                            <div class="d-flex">
                                                <v-img
                                                    class=" "
                                                    width="100"
                                                    height="100"
                                                    max-width="100"
                                                    :src="item.property.photo"
                                                ></v-img>

                                                <v-card-text class="text-left pt-0">
                                                    <div class="w-200">
                                                        <h2 class="mb-1">{{ item.property.location.location }}</h2>
                                                        <p class="ma-0">Block {{ item.property.block }}</p>
                                                        <p class="ma-0">Lot {{ item.property.lot }}</p>
                                                        <p v-if="item.property.phase" class="ma-0">Phase {{ item.property.phase }}</p>
                                                        <p v-if="item.property.term" class="ma-0">Term {{ item.property.term }}</p>
                                                        <p v-if="item.property.lot_size" class="ma-0">{{ item.property.lot_size }}</p>
                                                    </div>
                                                </v-card-text>

                                                <v-card-text class="text-left pt-0">
                                                    <div class="w-200">
                                                        <h3 class="mb-1">Sales Manager</h3>
                                                        <p class="ma-0">{{ item.sales_manager?.profile?.full_name || 'NONE' }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <h3 class="mb-1">Sales Agent</h3>
                                                        <p class="ma-0">{{ item.sales_agent?.profile?.full_name || 'NONE' }}</p>
                                                    </div>
                                                </v-card-text>

                                                <v-card-text class="text-left pt-0">
                                                    <div>
                                                        <h3 class="mb-1">Status</h3>
                                                        <h3 class="ma-0 green--text">{{ getStatus(item) }}</h3>
                                                    </div>
                                                </v-card-text>

                                                <v-card-text class="text-left pt-0">
                                                    <div class="w-150">
                                                        <h3 class="mb-1">Contract Price</h3>
                                                        <h3 class="mb-3 orange--text">{{ '₱' + Number(item.contract_price).toLocaleString() }}</h3>
                                                        <h3 class="mb-1">Balance</h3>
                                                        <h3 class="mb-0 orange--text">{{ getBalance(item) }}</h3>
                                                    </div>
                                                    
                                                </v-card-text>
                                                
                                            </div>
                                            <div class="pencil" @click="editProperty(item)">
                                                <v-icon >mdi-pencil-plus-outline</v-icon>
                                            </div>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content class="">
                                            <v-divider></v-divider>
                                            <br>
                                            <h3>Payments</h3>
                                            <div class="max-overflow-h overflow-y-auto">
                                                <v-simple-table>
                                                    <template v-slot:default>
                                                        <thead>
                                                            <tr>
                                                                <th class="text-left">
                                                                    Date
                                                                </th>
                                                                
                                                                <th class="text-left">
                                                                    Type
                                                                </th>
                                                                <th class="text-left">
                                                                    Mode
                                                                </th>
                                                                <th class="text-left">
                                                                    Image
                                                                </th>
                                                                <th class="text-left">
                                                                    Amount
                                                                </th>
                                                                <th class="text-left">
                                                                    
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                v-for="(payment, index) in item.payments" :key="index"
                                                            >
                                                                <td width="250">{{ payment.paid_at }}</td>
                                                                <td width="250">{{ payment.type_of_payment }}</td>
                                                                <td width="150">{{ payment.mode_of_payment }}</td>
                                                                <td width="150">{{ payment.original_image || 'NONE' }}</td>
                                                                <td width="150">{{ '₱' + Number(payment.amount).toLocaleString() }}</td>
                                                                <td width="150"><v-icon @click="showUpdatePayment(payment)">mdi-pencil-plus-outline</v-icon></td>
                                                            </tr>
                                                        </tbody>
                                                    </template>
                                                </v-simple-table>
                                                <v-divider></v-divider>
                                                <v-simple-table>
                                                    <template v-slot:default>
                                                        <tbody>
                                                            <tr>
                                                                <td width="250"><h4>TOTAL:</h4></td>
                                                                <td width="250"></td>
                                                                <td width="150"></td>
                                                                
                                                                <td width="150" class="text-left">
                                                                    <h3>{{ '₱' + Number(item.total_payment).toLocaleString() }}</h3>
                                                                </td>
                                                                <td width="100"></td>
                                                            </tr>
                                                        </tbody>
                                                    </template>
                                                </v-simple-table>
                                            </div>
                                            <v-btn
                                                class="ml-auto mt-3"
                                                elevation="0"
                                                color="info"
                                                :disabled="isPaymentDisabled"
                                                @click="addPayment(item)"
                                            >
                                                <v-icon>mdi-cash-clock</v-icon> &nbsp; Add Payment
                                            </v-btn>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </div>
                            </v-expansion-panels>
                        </v-row>
                    </v-card-text>
                </v-card>
                <div v-else class="center-loading">
                    <v-progress-circular
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </div>
            </v-col>
            <v-col cols="2" v-if="buyerDocuments.length">
                <v-card
                    class="mx-auto"
                >
                    <v-card-title class="pb-0">
                        <div class="d-flex">
                        <h3>Documents</h3>
                        <v-btn
                            class="ml-2 p-0"
                            elevation="1"
                            color="orange"
                            dark
                            small
                            @click="manage"
                        >
                            Edit <v-icon small class="ml-1">mdi-pencil-plus-outline</v-icon>
                        </v-btn>
                    </div>
                    </v-card-title>
                    <v-card-text  class="text-left">
                        <div class="d-flex" v-for="(document,i) in buyerDocuments" :key="i">
                            <v-checkbox
                                :label="document.label"
                                :input-value="document.value"
                                readonly
                                hide-details
                                color="success"
                            ></v-checkbox>
                        </div>
                    </v-card-text>
                </v-card>
                
            </v-col>
        </v-row>

        <v-dialog
            v-model="manageDocuments"
            width="800px"
        >
            <v-card>
                <v-card-title class="pb-0 ml-6">
                    <h3>Update Document</h3>
                </v-card-title>
                <v-form>
                    <v-container class="px-10">
                        <ReservationDocument title="Documents" :is-modal="true" :errors="errors" :documents="buyerDocuments" @documents="updateForm($event, 'documents')"/>
                        <br>
                        <div class="d-flex justify-end">
                            <v-btn
                                class="ml-2"
                                elevation="0"
                                color="warning"
                                @click="manageDocuments = false"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                class="ml-2"
                                elevation="0"
                                color="primary"
                                @click="updateDocument"
                            >
                                Submit
                            </v-btn>
                        </div>
                    </v-container>
                </v-form>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="showEditReservation"
            width="800px"
        >
            <v-form>
                <v-container class="pa-0">
                    <v-card>
                        <v-card-title class="pb-0 ml-6">
                            <h3>Update Property</h3>
                        </v-card-title>
                        <v-form>
                            <v-container class="px-10">
                                <ReservationChooseProperty size="sm" :errors="errors" :property="selectedProperty" @chooseProperty="updateForm($event, 'chooseProperty')"/>
                                <br>
                                <v-divider></v-divider>
                                <br>
                                <div class="d-flex justify-end">
                                    <v-btn
                                        class="ml-2"
                                        elevation="0"
                                        color="warning"
                                        @click="showEditReservation = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        class="ml-2"
                                        elevation="0"
                                        color="primary"
                                        @click="updateProperty"
                                    >
                                        Submit
                                    </v-btn>
                                </div>
                            </v-container>
                        </v-form>
                    </v-card>
                </v-container>
            </v-form>
        </v-dialog>
        <v-dialog
            v-model="showEditPayment"
            width="800px"
        >
            <v-form>
                <v-container class="pa-0">
                    <v-card>
                        <v-card-title class="pb-0 ml-6">
                            <h3>Update Payment</h3>
                        </v-card-title>
                        <v-form>
                            <v-container class="px-10">
                                <PaymentInfo :errors="errors" :payment="selectedPayment" @paymentInfo="updateForm($event, 'payment')"/>
                                <br>
                                <v-divider></v-divider>
                                <br>
                                <div class="d-flex justify-end">
                                    <v-btn
                                        class="ml-2"
                                        elevation="0"
                                        color="warning"
                                        @click="showEditPayment = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        class="ml-2"
                                        elevation="0"
                                        color="primary"
                                        @click="updatePayment"
                                    >
                                        Submit
                                    </v-btn>
                                </div>
                            </v-container>
                        </v-form>
                    </v-card>
                </v-container>
            </v-form>
        </v-dialog>
    </v-container>
</template>
<script>
import Swal from 'sweetalert2'
import { Reservations } from '../../../services/reservations'
export default {
    name: "ReservationIndex",
    data () {
        return {
            dialog: false,
            manageDocuments: false,
            showEditReservation: false,
            showEditPayment: false,
            isPaymentDisabled: false,
            panel: [0],
            totalPayment: 0,
            buyer: null,
            documents: [],
            selectedProperty: {},
            selectedPayment: {},
            buyerDocuments: [],
            buyerReservations: [],

            errors: {},
            form: {
                selected_property: null,
                chooseProperty: {},
            }
        }
    },

    watch:{
        $route (to, from){
            this.getDocuments()
            this.getBuyer()
        }
    },
    
    created () {
        this.getDocuments()
        this.getBuyer()
    },

    methods: {
        getDocuments () {
            Reservations.getDocuments().then((response) => {
                if (response.data) {
                    this.documents = response.data
                }
            });
        },

        getBuyer () {
            Reservations.getBuyer(this.$route.params.id).then((response) => {
                if (response.data.data) {
                    this.buyer = response.data.data
                    
                    this.buyerDocuments = this.mapDocuments(response.data.data.documents)

                    setTimeout(() => {
                        this.mapReservations(this.buyer.reservations)
                    }, 600);
                }
            });
        },

        mapDocuments (documents) {
            return  this.documents.map(function(data) {
                const obj = {
                    value: false,
                    label: data.desc,
                    key: data.title,
                    file_name: null,
                    file_url: null,
                }
                if (documents) {
                    documents.forEach(document => {
                        if (document.title === data.title) {
                            obj.value = true
                            obj.file_name = new File([document.file_url], document.file_name, {
                                type: "image/jpeg",
                            })
                            obj.file_url = document.file_url
                        }
                    });
                }
                return obj
            })
        },

        mapReservations (reservations) {
            if (reservations.length) {
                const self = this
                const buyerReservations = reservations.map(function(reservation) {
                    let total = 0
                    const payments = reservation.payments

                    payments.forEach(payment => {
                        total += payment.amount
                    });

                    self.$set(reservation, 'total_payment', total)

                    return reservation
                })

                this.buyerReservations = buyerReservations
            }
        },
        
        getBalance (item) {
            const total = parseInt(item.contract_price) - parseInt(item.total_payment)

            if (total <= 0) {
                return '₱' + Number(0).toLocaleString()
            }
            return '₱' + Number(total).toLocaleString()
        },

        getStatus (item) {
            if (this.getBalance(item) === "₱0") {
                this.isPaymentDisabled = true
                return 'Fully Paid'
            }

            return item.status
        },

        addPayment (item) {
            this.$router.push({path: `/receipts/create?buyer=${this.buyer.slug}&reservation=${item.id}`});
        },

        updateForm (form, key) {
            this.form[key] = form
            // console.log(this.form)
        },

        manage () {
            this.manageDocuments = true
        },

        updateOrCreateProperty () {
            Reservations.updateOrCreateProperty(this.buyer.slug, this.form).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully added',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        } 
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        'Something went wrong',
                        'warning'
                    )
                    this.errors = error.response.data.errors
                }
            })
        },

        editProperty (item) {
            this.selectedProperty = item.property
            this.showEditReservation = true
            this.form.selected_property = item.property.id
        },

        updateDocument () {
            const formData = new FormData()
            
            Object.entries(this.form).forEach(([key, obj]) => {
                if (obj) {
                    if (key === 'documents') {
                        Object.entries(obj).forEach(([fileKey, fileVal]) => {
                            formData.append(fileKey, fileVal);
                        })
                    } 
                }
            })

            Reservations.updateDocument(this.buyer.slug, formData).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully updated',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        }
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        'Something went wrong',
                        'warning'
                    )
                    this.errors = error.response.data.errors
                }
            })
        },

        updateProperty () {
            Reservations.updateOrCreateProperty(this.buyer.slug, this.form).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully added',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        } 
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        'Something went wrong',
                        'warning'
                    )
                    this.errors = error.response.data.errors
                }
            })
        },

        showUpdatePayment (payment) {
            this.showEditPayment = true
            this.selectedPayment = payment
            // Reservations.updateOrCreateProperty(this.buyer.slug, this.form).then((response) => {
            //     if (response.data) {
            //         Swal.fire({
            //             title: 'Done!',
            //             text: 'Successfully added',
            //             confirmButtonText: 'Okay',
            //         }).then((result) => {
            //             if (result.isConfirmed) {
            //                 location.reload()
            //             } 
            //         })
            //     }
            // }).catch(error => {
            //     // Handle error
            //     if (error.response) {
            //         Swal.fire(
            //             'Ops.',
            //             'Something went wrong',
            //             'warning'
            //         )
            //         this.errors = error.response.data.errors
            //     }
            // })
        },

        updatePayment () {
            const formData = new FormData()

            this.form.payment.amount = this.formatAmount(this.form.payment.amount)
            
            Object.entries(this.form.payment).forEach(([key, obj]) => {
                if (obj) {
                    if (key === 'image') {
                        formData.append(key, obj);
                    } else {
                        formData.append(key, JSON.stringify(obj));
                    }
                }
            })

            Reservations.updatePayment(this.buyer.slug, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully updated',
                        confirmButtonText: 'Okay',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        } 
                    })
                }
            }).catch(error => {
                // Handle error
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        'Something went wrong',
                        'warning'
                    )
                    this.errors = error.response.data.errors
                }
            })
        }
    }
}
</script>
<style>
    .user-img {
        border-radius: 100%;
        height: 200px;
        width: 200px;
    }
    .w-200 {
        width: 200px;
    }
    .w-150 {
        width: 110px;
    }
    .center-loading {
        margin-left: 50%;
        margin-top: 300px;
    }
    .max-card-h {
        max-height: 830px;
        height: 830px;
    }

    .max-overflow-h {
        max-height: 480px;
    }
    .max-overflow-h-2 {
        max-height: 740px;
    }
    .pencil {
        position: absolute;
        right: 10px;
        top: 10px;
    }
</style>