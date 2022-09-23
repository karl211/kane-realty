<template>
  <div>
    <v-container fluid>
        <v-row
          class="card-stats"
          align="start">
          <v-col md="3">
              <v-card class="pa-2">
                  <v-card-title>
                      Jobs Upgraded
                  </v-card-title>
                  <v-card-subtitle>
                      2000
                  </v-card-subtitle>
              </v-card>
          </v-col>
          <v-col md="3">
              <v-card class="pa-2 card-stats">
                  <v-card-title>
                      Jobs Upgraded
                  </v-card-title>
                  <v-card-subtitle>
                      2000
                  </v-card-subtitle>
              </v-card>
          </v-col>
          <v-col md="3">
              <v-card class="pa-2">
                  <v-card-title>
                      Jobs Applicants
                  </v-card-title>
                  <v-card-subtitle>2
                  </v-card-subtitle>
              </v-card>
          </v-col>
          <v-col md="3">
              <v-card class="pa-2">
                  <v-card-title>
                      Talent Found
                  </v-card-title>
                  <v-card-subtitle>
                      2000
                  </v-card-subtitle>
              </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">
            <v-card
              class="mx-auto"
            >
              <v-toolbar
                color="cyan"
                dark
              >
                <v-toolbar-title>Top Users</v-toolbar-title>
              </v-toolbar>
              <v-list three-line>
                <template v-for="(item, index) in items">
                  <v-subheader
                    v-if="item.header"
                    :key="item.header"
                    v-text="item.header"
                  ></v-subheader>

                  <v-divider
                    v-else-if="item.divider"
                    :key="index"
                    :inset="item.inset"
                  ></v-divider>

                  <v-list-item
                    v-else
                    :key="item.title"
                  >
                    <v-list-item-avatar>
                      <v-img :src="item.avatar"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      {{ item.title }}
                      <span class="text--primary">{{ item.subtitle }}</span>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-list>
            </v-card>
          </v-col>
        </v-row>
    </v-container>
  </div>
</template>
<script>

  export default {
    name: 'HomePages',
    data () {
      return {
        items: [
            { header: 'This Month' },
            {
              avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
              title: 'Brunch this weekend?',
              subtitle: `Ali Connors I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`,
            },
            { divider: true, inset: true },
            {
              avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
              title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
              subtitle: `to Alex, Scott, Jennifer Wish I could come, but I'm out of town this weekend.`,
            },
            { divider: true, inset: true },
            {
              avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
              title: 'Oui oui',
              subtitle: 'Sandra Adams Do you have Paris recommendations? Have you ever been?',
            },
            { divider: true, inset: true },
            {
              avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
              title: 'Birthday gift',
              subtitle: 'Trevor Hansen Have any ideas about what we should get Heidi for her birthday?',
            },
            { divider: true, inset: true },
            {
              avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
              title: 'Recipe to try',
              subtitle: 'Britta Holt We should eat this: Grate, Squash, Corn, and tomatillo Tacos.',
            },
          ],
      }
    },
    created() {
      // this.initBar(response.data.data.total_candidate_per_month)
    },
    methods: {
      getPayments() {
        // return this.accountService.$get(`/payments`)
        // Auth.payments().then((res) => {
        //     console.log(res)
        // });
      }
      // initBar(total_candidate_per_month) {
      //       this.data = {
      //           labels: total_candidate_per_month.map((obj) => { return obj.label }),
      //           datasets: [
      //               {
      //                   data: total_candidate_per_month.map((obj) => { return obj.data }),
      //                   borderRadius: 15,
      //                   backgroundColor: [
      //                       this.bgColor('1'),
      //                       this.bgColor('2'),
      //                       this.bgColor('3'),
      //                       this.bgColor('4'),
      //                       this.bgColor('5'),
      //                       this.bgColor('6'),
      //                       this.bgColor('7'),
      //                       this.bgColor('8'),
      //                       this.bgColor('9'),
      //                       this.bgColor('10'),
      //                       this.bgColor('11'),
      //                       this.bgColor('12'),
      //                   ],
      //                   borderColor: [
      //                       this.bgColor('1'),
      //                       this.bgColor('2'),
      //                       this.bgColor('3'),
      //                       this.bgColor('4'),
      //                       this.bgColor('5'),
      //                       this.bgColor('6'),
      //                       this.bgColor('7'),
      //                       this.bgColor('8'),
      //                       this.bgColor('9'),
      //                       this.bgColor('10'),
      //                       this.bgColor('11'),
      //                       this.bgColor('12'),
      //                   ],
      //                   borderWidth: 1,
      //                   datalabels: {
      //                       display: false
      //                   }
      //               }
      //           ]
      //       }
      //   },
    },
    mounted() {
      this.getPayments()
      // console.log()
    }
  }
</script>
<style lang="scss">
  .card-stats {
    .v-card {
      border-radius: 15px;
    }
  }
</style>
