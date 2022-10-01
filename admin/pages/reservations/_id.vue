<template>
    <v-container>
        <v-row>
            <v-col cols="3">
                <v-card
                    class="mx-auto"
                >
                    <br>
                    <v-img
                        class="rounded-circle mx-auto"
                        width="150"
                        height="150"
                        src="https://picsum.photos/id/11/500/300"
                    ></v-img>
                    
                    <v-card-text class="text-center">
                        <h3>Marcus</h3>
                        <p>Buyer</p>
                    </v-card-text>

                    <v-divider class="mx-4"></v-divider>

                    <v-card-text class="text-left">
                        <div>
                            <h3>Name:</h3>
                            <p>Sample user</p>
                        </div>

                        <div>
                            <h3>Contact no:</h3>
                            <p>012-234-5678</p>
                        </div>

                        <div>
                            <h3>E-mail:</h3>
                            <p>marcus@minible.com</p>
                        </div>

                        <div>
                            <h3>Gender:</h3>
                            <p>Male</p>
                        </div>

                        <div>
                            <h3>TIN:</h3>
                            <p>15467034</p>
                        </div>

                        <div>
                            <h3>Civil status:</h3>
                            <p>Single</p>
                        </div>

                        <div>
                            <h3>Date of Birth:</h3>
                            <p>2017-02-19</p>
                        </div>

                        <div>
                            <h3>Address:</h3>
                            <p>172 Howe Flats Murazikville, AK 25715-8391</p>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="9">
                <v-card
                    class="mx-auto"
                >
                
                    <v-card-title>
                        <h3>Properties</h3>
                    </v-card-title>

                    <v-card-text class="text-left">
                        

                        <v-row justify="center" class="ma-0">
                            <v-expansion-panels accordion>
                            <v-expansion-panel
                                v-for="(item,i) in 2"
                                :key="i"
                            >
                                <v-expansion-panel-header>
                                    <div class="d-flex">
                                        <v-img
                                            class=" "
                                            width="100"
                                            height="100"
                                            max-width="100"
                                            src="https://picsum.photos/id/11/500/300"
                                        ></v-img>

                                        <v-card-text class="text-left pt-0">
                                            <div>
                                                <!-- <h3>Location:</h3> -->
                                                <h3 class="mb-3">Braulio Ryan</h3>
                                                <p class="ma-0">Block 36</p>
                                                <p class="ma-0">Lot 18</p>
                                                <p>Phase 2</p>
                                            </div>
                                        </v-card-text>

                                        <v-card-text class="text-left pt-0">
                                            <div>
                                                <!-- <h3>Location:</h3> -->
                                                <h3 class="mb-3">Sales Manager</h3>
                                                <p class="ma-0">None</p>
                                            </div>
                                        </v-card-text>

                                        <v-card-text class="text-left pt-0">
                                            <div>
                                                <h3 class="mb-3">Sales Agent</h3>
                                                <p class="ma-0">Luzminda Montemayor</p>
                                            </div>
                                        </v-card-text>

                                        <v-card-text class="text-left pt-0">
                                            <div>
                                                <!-- <h3>Location:</h3> -->
                                                <h3 class="mb-3">Status</h3>
                                                <h4 class="ma-0">Ongoing</h4>
                                            </div>
                                        </v-card-text>
                                    </div>
                                </v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-divider class=""></v-divider>
                                    <br>
                                    <h3>Payments</h3>
                                    <v-simple-table
                                    >
                                        <template v-slot:default>
                                        <thead>
                                            <tr>
                                            <th class="text-left">
                                                Name
                                            </th>
                                            <th class="text-left">
                                                Calories
                                            </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                            v-for="item in desserts"
                                            :key="item.name"
                                            >
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.calories }}</td>
                                            </tr>
                                        </tbody>
                                        </template>
                                    </v-simple-table>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    export default {
      data () {
        return {
          desserts: [
            {
              name: 'Frozen Yogurt',
              calories: 159,
            },
            {
              name: 'Ice cream sandwich',
              calories: 237,
            },
            {
              name: 'Eclair',
              calories: 262,
            },
            {
              name: 'Cupcake',
              calories: 305,
            },
            {
              name: 'Gingerbread',
              calories: 356,
            },
            {
              name: 'Jelly bean',
              calories: 375,
            },
            {
              name: 'Lollipop',
              calories: 392,
            },
            {
              name: 'Honeycomb',
              calories: 408,
            },
            {
              name: 'Donut',
              calories: 452,
            },
            {
              name: 'KitKat',
              calories: 518,
            },
          ],
        }
      },
    }
  </script>
<style>
    .user-img {
        border-radius: 100%;
        height: 200px;
        width: 200px;
    }
</style>