<template>
    <section>
        <br>
        <!-- <div class="d-flex justify-space-between mx-6">
            <h1 class="title ml-2 text-h4">{{ location }} <small>Properties</small></h1>
            <v-btn
                class="ml-2"
                elevation="0"
                color="info"
                @click="$router.push('/locations/properties/create?id=' + $route.query.id + '&location=' + location)"
            >
                <v-icon>mdi-home-plus</v-icon> Add Property
            </v-btn>
        </div> -->
        <h1 class="title ml-2 text-h4">{{ location }} <small>Properties</small></h1>
        <br>
        <v-row>
            <v-col>
                <v-btn
                    class="ml-2"
                    elevation="0"
                    color="info"
                    @click="$router.push('/locations/properties/create?id=' + $route.query.id + '&location=' + location)"
                >
                    <v-icon>mdi-cash-clock</v-icon> &nbsp; New Property
                </v-btn>
            </v-col>
            <v-col sm="2">
                <section class="d-flex">
                    <!-- <v-text-field
                        label="Search status"
                        dense
                        outlined
                        class="mx-1"
                        @input="searchProperty"
                    ></v-text-field> -->
                    <v-select
                        v-model="filter_status"
                        :items="['Reserved', 'Available']"
                        label="Filter Property"
                        dense
                        outlined
                        class="mx-1"
                        @change="selectFilter"
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
                <td>{{ item.lot_size }}</td>
                <td>{{ item.floor_area }}</td>
                <td>{{ '₱' + Number(item.contract_price).toLocaleString() }}</td>
                <td>{{ '₱' + Number(item.default_monthly_amortization).toLocaleString() }}</td>
                <td>{{ item.term }}</td>
                <td>{{ item.status }}</td>
                <td>
                    <div class="d-flex justify-content">
                        <v-btn
                            elevation="0"
                            depressed
                            color="warning"
                            small
                            icon
                        >
                            <v-icon>mdi-file-edit-outline</v-icon>
                        </v-btn>
                        <v-btn
                            class="ml-2"
                            elevation="0"
                            color="danger"
                            small
                            icon
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
            <v-col class="text-right">
            <TablePagination
                v-if="properties.length"
                :paginate-data="paginateData"
                @paginate="paginate"
            />
            </v-col>
        </v-row>
        <div class="container-wrap">
            
            <!-- <v-card
                class="mx-auto mb-10"
                max-width="350"
                v-for="(property, i) in properties" :key="i"
            >
                <v-img
                    class="white--text align-end"
                    height="200px"
                    :src="property.photo"
                >
                <v-card-title>{{ property.model }}</v-card-title>
                </v-img>

                <v-card-text class="text--primary">
                    <div>Status: <span class="green--text font-weight-medium">{{ property.status }}</span></div>
                    <div>Block {{ property.block }}, Lot {{ property.lot }} <span v-if="property.phase">, Phase {{ property.phase }}</span></div>
                    <div>Lot Size: {{ property.lot_size }}</div>
                    <div>Floor Area: {{ property.floor_area }}</div>
                    <div>Contract Price: {{ '₱' + Number(property.contract_price).toLocaleString() }}</div>
                    <div>Default Amortization: {{ '₱' + Number(property.default_monthly_amortization).toLocaleString() }}</div>
                    <div>Term: {{ property.term }}</div>
                </v-card-text>
            </v-card>
            <div class="filling-empty-space-childs"></div>
            <div class="filling-empty-space-childs"></div>
            <div class="filling-empty-space-childs"></div> -->
        </div>
    </section>
</template>

<script>
import _ from "lodash";
import { Property } from '../../../services/properties'
export default {
    name: "PropertiesIndex",
    data () {
        return {
            filter_status: 'Reserved',
            loading: false,
            location: null,
            headers: [
                { text: "Image" , align: "left" },
                { text: "Property" , align: "left" },
                { text: "Lot size" , align: "left" },
                { text: "Floor Area" , align: "left" },
                { text: "Contract Price" , align: "left" },
                { text: "Default Amortization" , align: "left" },
                { text: "Term" , align: "left" },
                { text: "Status " , align: "left" },
                { text: "Actions", align: "left" },
            ],
            properties: [],
            search: {
                page: 1,
                search: ''
            },
            paginateData: null,
        }
    },

    created() {
        if (this.$route.query.id) {
            this.getProperties()
            this.searchProperty = _.debounce(this.searchProperty, 400);
        }
    },

    methods: {
        getProperties() {
            Property.locationProperties(this.search, this.$route.query.id).then((response) => {
                if (response.data.data.length) {
                    // console.log(response.data.data)
                    // this.properties = response.data
                    this.location = response.data.data[0].location.location

                    this.paginateData = response.data
                    this.properties = response.data.data
                    this.loaded = true
                    this.loading = false
                }
            });
        },

        paginate(pageNumber) {
            this.search.page = pageNumber
            this.getProperties();
        },

        searchProperty(value) {
            this.properties = []
            this.search.page = 1
            this.search.search = value

            this.getProperties()
        },

        selectFilter(value) {
            this.properties = []
            this.search.page = 1
            this.search.search = value
            this.getProperties()
        }
    },
}
</script>
<style>
    .card-text-wrap {
        min-height: 100px;
    }
 
    .container-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around
    }

    .filling-empty-space-childs {
        width: 25%;
        height:0; 
    }
</style>
