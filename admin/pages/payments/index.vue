<template>
  <div>
    <section v-if="loaded">
      <h1 class="title">Manage Payments</h1>
      <br>
      <v-row>
        <v-col>
          <v-btn
                class="ml-2"
                elevation="0"
                color="info"
                @click="$router.push('/payments/create')"
            >
                <v-icon>mdi-cash-clock</v-icon> &nbsp; New Payment
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
        :items="payments"
        :headers="headers"
        :items-per-page="5"
        :server-items-length="payments.length"
      >
        <template #item="{ item }">
          <tr>
            <td>{{ item.ar_number }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.property }}</td>
            <td>{{ item.contract_price }}</td>
            <td>{{ item.amount_paid }}</td>
            <td>{{ item.balance }}</td>
            <td>{{ item.type_of_payment }}</td>
            <td>{{ item.mode_of_payment }}</td>
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
            v-if="payments.length"
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
import { Auth } from '../../services/auth'
export default {
  name: "PaymentsIndex",
  data () {
    return {
      loading: false,
      loaded: false,
      prof_title_id: "",
      headers: [
        { text: "AR No." },
        { text: "Name" },
        { text: "Property" },
        { text: "Contract Price" },
        { text: "Amount paid" },
        { text: "Balance" },
        { text: "Type" },
        { text: "Mode" },
        { text: "Actions", align: "center" },
      ],
     
      paginateData: null,
      payments: [],
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
    this.getPayments()
    this.searchPayment = _.debounce(this.searchPayment, 400);
  },
  mounted() {
    
  },
  methods: {
     getPayments() {
      this.loading = true
      
       Auth.payments(this.search).then((response) => {
        this.paginateData = response.data
        this.payments = response.data.data
        this.loaded = true
        this.loading = false
      });
    },
    paginate(pageNumber) {
      this.search.page = pageNumber
      this.getPayments(this.search);
    },
    searchPayment(value) {
      this.payments = []
      this.search.page = 1
      this.search.search = value

      this.getPayments(this.search)
    },
  }
}
</script>
