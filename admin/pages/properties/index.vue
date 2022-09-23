<template>
  <div>
    <!-- <v-data-table
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1"
      ></v-data-table> -->
    <section>
      <h1 class="title">Properties</h1>
      <v-row>
        <v-col></v-col>
        <v-col sm="5">
          <section class="d-flex">
            <v-text-field
              v-model="search"
              label="Name, Email, Address, User Type"
              dense
              outlined
              class="mx-1"
            ></v-text-field>
            <v-select
              v-model="prof_title_id"
              :items="mapProfessionalTitles"
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
        :items="desserts"
        :headers="headers"
        :items-per-page="5"
        :server-items-length="desserts.length"
      >
        <template v-slot:item="{ item }">
          <tr>
            <td>
                {{ item.name }}
            </td>
            <td>{{ item.property }}</td>
            <td>
              <div class="d-flex">
                <!-- <v-btn
                  elevation="0"
                  outlined
                  class="mx-1"
                  color="primary"
                  @click="onImpersonate(item)"
                  small
                  >Login</v-btn
                >
                <v-btn
                  elevation="0"
                  outlined
                  color="primary"
                  small
                  @click.stop="getDetails(item)"
                  >More</v-btn
                > -->
              </div>
            </td>
          </tr>
        </template>
      </v-data-table>
      <v-row justify="space-between">
        <v-col></v-col>
        <v-col class="text-right">
          <TablePagination
            store="manageaccount"
            collection="accounts"
          />
        </v-col>
      </v-row>
    </section>
  </div>
</template>

<script>
import { Auth } from '../../services/auth'
  export default {
    name: "PropertiesIndex",
    data () {
      return {
        loading: false,
        loaded: false,
        search: "",
        prof_title_id: "",
        headers: [
          {
            text: 'Location',
            align: 'start',
          },
          { text: 'Property', value: 'property' },
          
        ],
        mapProfessionalTitles: [
          'Location'
        ],
        desserts: [
          {
            name: 'Tiniwisan',
            property: 'Block 30, Lot 1',
          },
          {
            name: 'Tiniwisan2',
            property: 'Block 30, Lot 12',
          },
          {
            name: 'Tiniwisan',
            property: 'Block 30, Lot 1',
          },
          {
            name: 'Tiniwisan2',
            property: 'Block 30, Lot 12',
          },{
            name: 'Tiniwisan',
            property: 'Block 30, Lot 1',
          },
          {
            name: 'Tiniwisan2',
            property: 'Block 30, Lot 12',
          },{
            name: 'Tiniwisan',
            property: 'Block 30, Lot 1',
          },
          {
            name: 'Tiniwisan2',
            property: 'Block 30, Lot 12',
          },{
            name: 'Tiniwisan',
            property: 'Block 30, Lot 1',
          },
          {
            name: 'Tiniwisan2',
            property: 'Block 30, Lot 12',
          },
        ],
      }
    },
    methods: {
      getPayments() {
        Auth.payments().then((res) => {
            console.log(res)
        });
      }
    },
    mounted() {
      // this.getPayments()
    }
  }
</script>
