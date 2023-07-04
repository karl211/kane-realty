<template>
    <div>
      <section v-if="loaded">
        <h1 class="title">Reservations</h1>
        <br>
        <v-row>
          <v-col>
            <v-btn
                class="ml-2"
                elevation="0"
                color="info"
                @click="$router.push('/reservations/create')"
            >
                <v-icon>mdi-home-plus</v-icon> Add Reservation
            </v-btn>
          </v-col>
          <v-col sm="5">
            <section class="d-flex">
                
                <v-text-field
                    label="Search Name or Email"
                    dense
                    outlined
                    class="mx-1"
                    @input="searchReservation"
                ></v-text-field>
                <v-select
                    v-model="prof_title_id"
                    :items="filters"
                    label="Filter Status"
                    placeholder="Select Status"
                    dense
                    outlined
                    class="mx-1"
                    @change="searchReservation"
                />
            </section>
          </v-col>
        </v-row>
  
        <v-data-table
          hide-default-footer
          disable-sort
          :loading="loading"
          :items="reservations"
          :headers="headers"
          :items-per-page="5"
          :server-items-length="reservations.length"
        >
          <template #item="{ item }">
            <tr>
                <td>{{ item.date_of_transaction }}</td>
                <td @click="show(item.slug)">
                    <span class="blue--text pointer">{{ item.name }}</span>
                </td>
                <td>{{ item.property.full_property }}</td>
                <td>{{ formatCurrency(item.contract_price) }}</td>
                <td>{{ formatCurrency(item.balance) }}</td>
                
                <td class="d-flex justify-center mt-3">
                    <div class="d-flex justify-content">
                        <v-btn
                            elevation="0"
                            depressed
                            color="primary"
                            small
                            icon
                            @click="show(item.slug)"
                        >
                            <v-icon>mdi-eye-arrow-right</v-icon>
                        </v-btn>
                        <v-btn
                            elevation="0"
                            color="danger"
                            small
                            icon
                            @click="deleteReservation(item)"
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
              v-if="reservations.length"
              :paginate-data="paginateData"
              @paginate="paginate"
            />
          </v-col>
        </v-row>
      </section>
    </div>
  </template>
  
<script>
import _ from "lodash";
import Swal from 'sweetalert2'
import { mapGetters } from 'vuex'
import { Reservations } from '../../services/reservations'

export default {
    name: "ReservationIndex",
    data () {
        return {
            loading: false,
            loaded: false,
            prof_title_id: "",
            headers: [
                { text: "Date Of Transaction" },
                { text: "Name" },
                { text: "Property" },
                { text: "Contract Price" },
                { text: "Balance" },
                { text: "Actions", align: "center" },
            ],
            
            paginateData: null,
            filters: ['Reserved', 'Fully Paid'],
            reservations: [],
            search: {
                page: 1,
                search: '',
            }
        }
    },
    
    watch: {
        loaded(value) {
            this.loaded = value
        }
    },

    computed: {
        ...mapGetters({
            getBranch: 'account/getBranch',
        })
    },

    created() {
        this.getReservations()
        this.searchReservation = _.debounce(this.searchReservation, 400);
    },

    methods: {
        getReservations() {
            this.loading = true

            Reservations.allReservations(this.search).then((response) => {
                this.paginateData = response.data
                this.reservations = response.data.data
                this.loaded = true
                this.loading = false
            }).catch(error => {
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        error.response.data.message,
                        'warning'
                    )
                }
            })
        },

        paginate(pageNumber) {
            this.search.page = pageNumber
            this.getReservations(this.search);
        },

        searchReservation(value) {
            this.reservations = []
            this.search.page = 1
            this.search.search = value
            this.getReservations(this.search)
        },

        show(id) {
            this.$router.push({path: `/reservations/${id}`});
        },

        deleteReservation(item) {
            Swal.fire({
                title: 'Do you want to delete this reservation?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    Reservations.removeReservation({id: item.id}).then((response) => {
                        if (response.data) {
                            Swal.fire({
                                title: 'Done!',
                                text: 'Successfully deleted',
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
                                error.response.data.message,
                                'warning'
                            )
                            this.errors = error.response.data.errors
                        }
                    })
                }
            })
        },
        // edit(id) {
        //     this.$router.push({path: `/reservations/${id}/update`});
        // }
    }
}
</script>
  