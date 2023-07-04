<template>
  <div>
    <v-container fluid>
        <v-row>
            <v-col lg="3" cols="12" v-for="(item,index) in statuses" :key="index">
                <v-card elevation="2" class="rounded-lg d-flex align-center">
                    <v-card-text class="d-flex justify-space-between align-center">
                        <div>
                            <strong>{{ item.title }}</strong> <br>
                        </div>
                        <v-avatar size="60" :color="item.color" style="border: 3px solid #444">
                            <span style="color: white">{{item.total}}</span>
                        </v-avatar>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-space-between">


                    </v-card-actions>
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
            <v-col cols="12" lg="6">
                <v-card>
                    <v-card-title>Activities</v-card-title>
                    <v-card-text class="py-0">
                        <v-timeline align-top dense>
                            <v-timeline-item color="indigo" small>
                                <strong>5 Minuts ago</strong>
                                <div class="text-caption">
                                   You have new order please check this out
                                </div>
                            </v-timeline-item>
                            <v-timeline-item color="green" small>
                                <strong>35 Minuts ago</strong>
                                <div class="text-caption mb-2">
                                    A Product has delivered!
                                </div>
                            </v-timeline-item>

                            <v-timeline-item color="indigo" small>
                                <strong>44 Minuts ago</strong>
                                <div class="text-caption">
                                    You have new order please check this out
                                </div>
                            </v-timeline-item>
                            <v-timeline-item color="indigo" small>
                                <strong>5 Minuts ago</strong>
                                <div class="text-caption">
                                   You have new order please check this out
                                </div>
                            </v-timeline-item>
                            <v-timeline-item color="green" small>
                                <strong>35 Minuts ago</strong>
                                <div class="text-caption mb-2">
                                    A Product has delivered!
                                </div>
                            </v-timeline-item>

                            <v-timeline-item color="indigo" small>
                                <strong>44 Minuts ago</strong>
                                <div class="text-caption">
                                    You have new order please check this out
                                </div>
                            </v-timeline-item>
                            <v-timeline-item color="indigo" small>
                                <strong>44 Minuts ago</strong>
                                <div class="text-caption">
                                    You have new order please check this out
                                </div>
                            </v-timeline-item>
                        </v-timeline>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12"></v-col>
        </v-row>
    </v-container>
  </div>
</template>
<script>
import Swal from 'sweetalert2'
import { Dashboard } from '../../services/dashboard'
export default {
    name: 'HomePages',
    data () {
        return {
            statuses: [
                {
                    key: 'total_available',
                    title: 'Total Available',
                    total: 0, 
                    icon: 'mdi-account-group-outline',
                    color: 'green darken-2'
                },
                {
                    key: 'total_reserved',
                    title: 'Total Reservation',
                    total: 0,
                    icon: 'mdi-account-group-outline',
                    color: 'orange lighten-2'
                },
                {
                    key: 'total_for_assumes',
                    title: 'Total For Assume',
                    total: 0, 
                    icon: 'mdi-account-group-outline',
                    color: 'cyan darken-2'
                },
                {
                    key: 'total_cancels',
                    title: 'Total For Cancellation', 
                    total: 0, 
                    icon: 'mdi-account', 
                    color: 'red lighten-2'
                }
            ],
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
        getStatuses() {
            Dashboard.statuses().then((res) => {
                if (res.data) {
                    this.statuses.map(function(status) {
                        if (res.data[status.key]) {
                            status.total = res.data[status.key]
                        }
                        return status
                    })
                }
            }).catch(error => {
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        error.response.data.message,
                        'warning'
                    )
                }
            })
        }
    },
    mounted() {
        this.getStatuses()
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
