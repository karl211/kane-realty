<template>
    <section>
        <br>
        <div class="d-flex justify-space-between">
            <h1 class="title ml-2 text-h4">{{ location }} <small>Properties</small></h1>
            <v-btn
                class="ml-2"
                elevation="0"
                color="info"
                @click="$router.push('/locations/properties/create?id=' + $route.query.id + '&location=' + location)"
            >
                <v-icon>mdi-cash-clock</v-icon> &nbsp; New Property
            </v-btn>
        </div>
        <br>
        <v-row>
            <v-col>
                
                <v-select
                    v-if="statuses.length"
                    v-model="filter_property.status"
                    :items="statuses"
                    label="Filter Property"
                    dense
                    outlined
                    class="mx-1 w-10"
                    @change="selectFilter"
                />
            </v-col>
            <v-col sm="3">
                <section class="d-flex">
                    <v-select
                        v-model="filter_property.block"
                        :items="blocks"
                        label="Block"
                        dense
                        outlined
                        class="mx-1"
                        @change="selectBlock"
                    />
                    <v-select
                        v-model="filter_property.lot"
                        :items="lots"
                        label="Lot"
                        dense
                        outlined
                        class="mx-1"
                        @change="selectLot"
                    />
                </section>
            </v-col>
        </v-row>

        <v-data-table
            hide-default-footer
            :loading="loading"
            :items="properties"
            :headers="headers"
            :items-per-page="5"
            :server-items-length="properties.length"
        >
            <template #item="{ item }">
            <tr>
                <td>
                    <v-img
                        class="white--text align-end"
                        height="100px"
                        width="100px"
                        :src="item.photo"
                    />
                </td>
                <td>Block {{ item.block }}, Lot {{ item.lot }} <span v-if="item.phase">, Phase {{ item.phase }}</span></td>
                <td>{{ item.reservation_owner }}</td>
                <td>{{ item.lot_size }}</td>
                <td>{{ '₱' + Number(item.contract_price).toLocaleString() }}</td>
                <td>{{ '₱' + Number(item.default_monthly_amortization).toLocaleString() }}</td>
                <td>{{ item.term }}</td>
                <td class="w-status">
                    <template v-if="!item.edit_status">
                        <span :style="{ color: item.active_color }">{{ item.status }}</span>
                        <v-icon class="pointer" @click="showEditStatus(item)">mdi-pencil-circle-outline</v-icon>
                    </template>
                    <template v-else>
                        <div class="w-status d-flex">
                            <v-select
                                v-model="item.status"
                                :items="toUpdateStatuses"
                                label="Select status"
                                dense
                                outlined
                                hide-details="auto"
                                class="mx-1"
                                @change="selectStatus(item)"
                            >
                                <template v-slot:selection >
                                    <span class="font-weight-medium"  :style="{ color: item.active_color }">{{ item.status }}</span>
                                </template>
                            </v-select>
                            <v-icon class="pointer" @click="saveStatus(item)">mdi-check</v-icon>
                            <v-icon class="pointer" @click="closeStatus(item)">mdi-close</v-icon>
                        </div>
                    </template>
                    
                </td>
                <td>
                    <div class="d-flex justify-content">
                        <v-btn
                            elevation="0"
                            depressed
                            color="warning"
                            small
                            icon
                            @click="showUpdateProperty(item)"
                        >
                            <v-icon>mdi-file-edit-outline</v-icon>
                        </v-btn>
                        <v-btn
                            class="ml-2"
                            elevation="0"
                            color="danger"
                            small
                            icon
                            @click="deleteProperty(item)"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </div>
                </td>
            </tr>
            </template>
        </v-data-table>
        <v-row justify="space-between">
            <v-col></v-col>
            <v-col v-if="properties.length && paginateData" class="text-right">
                <TablePagination
                    :paginate-data="paginateData"
                    @paginate="paginate"
                />
            </v-col>
        </v-row>
        <PropertyEdit :value="showEditProperty" :property="selectedProperty" :statuses="statuses" @refresh="getProperties()" @close="showEditProperty = false"/>
    </section>
    
</template>

<script>
import _ from "lodash";
import Swal from 'sweetalert2'
import { Property } from '../../../services/properties'
export default {
    name: "PropertiesIndex",
    data () {
        return {
            loading: false,
            location: null,
            locationId: null,
            headers: [
                { text: "Image" , align: "left" },
                { text: "Property" , align: "left" },
                { text: "Buyer" , align: "left" },
                { text: "Lot size" , align: "left" },
                // { text: "Floor Area" , align: "left" },
                { text: "Contract Price" , align: "left" },
                { text: "Default Amortization" , align: "left" },
                { text: "Term" , align: "left" },
                { text: "Status " , align: "left" },
                { text: "Actions", align: "left" },
            ],
            blocks: [],
            lots: [],
            statuses: [],
            toUpdateStatuses: [],
            properties: [],
            filter_property: {
                block: null,
                lot: null,
                status: 'Reserved',
                page: 1,
                search: ''
            },
            paginateData: null,
            showEditProperty: false,
            selectedProperty: {},

            activeColor: 'orange',
            editStatus: false,
        }
    },

    created() {
        this.getStatuses()
        
        if (this.$route.query.id) {
            this.getProperties()
            
            this.searchProperty = _.debounce(this.searchProperty, 400);
        }
    },

    methods: {
        selectStatus (item) {
            switch (item.status) {
                case 'Available':
                    item.active_color = 'green'
                    break;
                case 'Reserved':
                    item.active_color = 'orange'
                    break;
                case 'Cancelled':
                    item.active_color = 'red'
                    break;
                case 'For Assume':
                    item.active_color = 'blue'
                    break;
            }
        },

        pluck(array, key) {
            return array.map(function(obj) {
                return obj[key];
            });
        },
        
        getStatuses() {
            Property.statuses(this.search, this.$route.query.id).then((response) => {
                if (response.data.length) {
                    this.statuses = response.data

                    response.data.forEach(status => {
                        if (status !== 'Reserved') {
                            this.toUpdateStatuses.push(status)
                        }
                    });
                }
            });
        },

        getProperties() {
            if (!this.filter_property.status && this.selectedProperty) {
                this.filter_property.status = this.selectedProperty.status
            }

            Property.locationProperties(this.filter_property, this.$route.query.id).then((response) => {
                if (response.data.data.length) {
                    this.location = response.data.data[0].location.location
                    this.locationId = response.data.data[0].location.id
                    this.properties = response.data.data
                    this.blocks = response.data.data[0].blocks
                    this.loaded = true
                    this.loading = false

                    if (response.data?.links) {
                        this.paginateData = response.data
                    } else {
                        this.paginateData = null
                    }
                } else {
                    this.properties = []
                }
            });
        },

        getPropertiesLots() {
            Property.getLots({block: this.filter_property.block}, this.locationId).then((response) => {
                this.lots = response.data
            });
        },

        paginate(pageNumber) {
            this.filter_property.page = pageNumber
            this.getProperties();
        },

        searchProperty(value) {
            this.properties = []
            this.filter_property.page = 1
            this.filter_property.search = value

            this.getProperties()
        },

        selectBlock() {
            this.filter_property.lot = null
            this.filter_property.status = null
            this.getPropertiesLots()
        },

        selectLot() {
            this.getProperties()
        },

        selectFilter(data) {
            this.properties = []
            this.filter_property.block = null
            this.filter_property.lot = null
            this.filter_property.page = 1

            this.getProperties()
            this.selectStatus(data)
        },

        showUpdateProperty(item) {
            this.showEditProperty = true
            this.selectedProperty = item
        },

        showEditStatus(item) {
            item.edit_status = true;
            this.selectedProperty = item
        },

        closeStatus(item) {
            console.log(this.selectedProperty.status)
            item.status =  this.selectedProperty.status
            this.selectStatus(item)
            item.edit_status = false;
        },

        saveStatus(item) {
            Swal.fire({
                icon: 'warning',
                title: 'Would you like to change the status of this property?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    Property.updateStatus(item.id, {status:item.status}).then((response) => {
                        if (response.data) {
                            Swal.fire({
                                title: 'Done!',
                                text: 'Successfully updated',
                                confirmButtonText: 'Okay',
                                icon: 'success',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.getProperties()
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
                            this.errors = error.response.data.errors
                        }
                    })
                    
                } else if (result.dismiss === 'cancel') {
                    item.status =  this.filter_property.status
                    this.selectStatus(item)
                    item.edit_status = false;
                }
            })
        },

        deleteProperty(item) {
            Swal.fire({
                icon: 'warning',
                title: 'Would you like to delete this property?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.selectedProperty = item

                    Property.delete(item.id).then((response) => {
                        if (response.data) {
                            Swal.fire({
                                title: 'Done!',
                                text: 'Successfully deleted',
                                confirmButtonText: 'Okay',
                                icon: 'success',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.getProperties()
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
                            this.errors = error.response.data.errors
                        }
                    })
                    
                } else if (result.dismiss === 'cancel') {
                    item.status =  this.filter_property.status
                    this.selectStatus(item)
                    item.edit_status = false;
                }
            })
        }
    },
}
</script>
<style>
    .w-status {
        width: 200px;
    }
</style>
