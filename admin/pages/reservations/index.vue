<template>
    <div>
      <section v-if="loaded">
        <h1 class="title">Manage Reservations</h1>
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
                    label="Name, Email, Address, User Type"
                    dense
                    outlined
                    class="mx-1"
                    @input="searchPayment"
                ></v-text-field>
                <v-select
                    v-model="prof_title_id"
                    item-text="title"
                    item-value="id"
                    label="Account Title"
                    placeholder="Select Account Title"
                    dense
                    outlined
                    class="mx-1"
                />
            </section>
          </v-col>
        </v-row>
  
        <v-data-table
          hide-default-footer
          :loading="loading"
          :items="reservations"
          :headers="headers"
          :items-per-page="5"
          :server-items-length="reservations.length"
        >
          <template #item="{ item }">
            <tr>
              <td @click="show(item.slug)">
                <span class="blue--text pointer">{{ item.name }}</span>
              </td>
              <td>{{ item.property.full_property }}</td>
              <td>{{ item.contract_price }}</td>
              <td>{{ item.balance }}</td>
              <td>{{ item.date_of_transaction }}</td>
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
                          depressed
                          color="warning"
                          small
                          icon
                      >
                          <v-icon>mdi-file-edit-outline</v-icon>
                      </v-btn>
                      <v-btn
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
import { Reservations } from '../../services/reservations'
export default {
    name: "ReservationIndex",
    data () {
        return {
            loading: false,
            loaded: false,
            prof_title_id: "",
            headers: [
                { text: "Name" },
                { text: "Property" },
                { text: "Contract Price" },
                { text: "Balance" },
                { text: "Date Of Transaction" },
                { text: "Actions", align: "center" },
            ],
            
            paginateData: null,
            reservations: [],
            search: {
                page: 1,
                search: ''
            }
        }
    },
    
    watch: {
        loaded(value) {
            this.loaded = value
        }
    },

    created() {
        this.getReservations()
        this.searchPayment = _.debounce(this.searchPayment, 400);
    },

    methods: {
        getReservations() {
            this.loading = true
            
            Reservations.allReservations(this.search).then((response) => {
                this.paginateData = response.data
                this.reservations = response.data.data
                this.loaded = true
                this.loading = false
            });
        },
        paginate(pageNumber) {
            this.search.page = pageNumber
            this.getReservations(this.search);
        },
        searchPayment(value) {
            this.reservations = []
            this.search.page = 1
            this.search.search = value

            this.getReservations(this.search)
        },
        show(id) {
            this.$router.push({path: `/reservations/${id}`});
        }
    }
}
</script>
  