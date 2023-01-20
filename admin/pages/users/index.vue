<template>
  <div>
    <!-- <v-data-table
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1"
      ></v-data-table> -->
    <section>
        <h1 class="title">Users</h1>
        <br>
        <v-row>
            <v-col md="3" sm="6" xs="12" v-for="(property, i) in desserts" :key="i">
                <v-card
                    class="mx-auto mb-5"
                    max-width="350"
                    
                >
                    <v-card-text class="pa-0">
                        <div class="container text-center pt-10">
                            <v-img
                                class="avatar-lg rounded-circle m-auto"
                                src="http://minible-v-light.nuxt-vuejs.themesbrand.com/_nuxt/img/avatar-2.02aea0c.jpg"
                            >
                            </v-img>
                            <h1 class="mt-5">Simon Ryles</h1>
                            <h4 class="my-2">Full Stack Developer</h4> 
                        </div>
                        <div class="d-flex mt-3">
                            <v-btn color="link" class="w-50 rounded-0 warning--text">
                                <v-icon small>
                                    mdi-pencil
                                </v-icon> 
                                Edit
                            </v-btn>
                            <v-btn color="link" class="w-50 rounded-0 danger--text">
                                <v-icon small>
                                    mdi-delete-forever
                                </v-icon> 
                                Delete
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        
      <!-- <v-row>
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
      </v-row> -->

      <!-- <v-data-table
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
            <td>{{ item.name }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.name }}</td>
            <td>
              <div class="d-flex">
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
      </v-row> -->
    </section>
  </div>
</template>

<script>
import { Auth } from '../../services/auth'
  export default {
    name: "UsersIndex",
    data () {
      return {
        loading: false,
        loaded: false,
        search: "",
        prof_title_id: "",
        headers: [
          {
            text: 'Dessert (100g serving)',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'Calories', value: 'calories' },
          { text: 'Fat (g)', value: 'fat' },
          { text: 'Carbs (g)', value: 'carbs' },
          { text: 'Protein (g)', value: 'protein' },
          { text: 'Iron (%)', value: 'iron' },
        ],
        mapProfessionalTitles: [
          'Frozen Yogurt'
        ],
        desserts: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
            iron: '1%',
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
            iron: '1%',
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
            iron: '7%',
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
            iron: '8%',
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
            iron: '16%',
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
            iron: '0%',
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
            iron: '2%',
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
            iron: '45%',
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
            iron: '22%',
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7,
            iron: '6%',
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
<style lang="scss">
    .m-auto {
        margin: auto;
        text-align: center;
    }

    .card-text-wrap {
        min-height: 100px;
    }

    .filling-empty-space-childs {
        width: 25%;
        height:0; 
    }

    .container-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around
    }
</style>