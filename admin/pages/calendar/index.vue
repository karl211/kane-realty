<template>
    <v-row class="fill-height">
        <v-col>
        <v-sheet height="64">
            <v-toolbar
                flat
            >
                <v-btn
                    outlined
                    class="mr-4"
                    color="grey darken-2"
                    @click="setToday"
                >
                    Today
                </v-btn>
                <v-btn
                    fab
                    text
                    small
                    color="grey darken-2"
                    @click="prev"
                >
                    <v-icon small>
                    mdi-chevron-left
                    </v-icon>
                </v-btn>
                <v-btn
                    fab
                    text
                    small
                    color="grey darken-2"
                    @click="next"
                >
                    <v-icon small>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
                <v-toolbar-title v-if="$refs.calendar">
                    {{ $refs.calendar.title }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-menu
                    bottom
                    right
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            outlined
                            color="grey darken-2"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <span>{{ typeToLabel[type] }}</span>
                            <v-icon right>
                            mdi-menu-down
                            </v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item @click="type = 'day'">
                            <v-list-item-title>Day</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = 'week'">
                            <v-list-item-title>Week</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = 'month'">
                            <v-list-item-title>Month</v-list-item-title>
                        </v-list-item>
                        <!-- <v-list-item @click="type = '4day'">
                            <v-list-item-title>4 days</v-list-item-title>
                        </v-list-item> -->
                    </v-list>
                </v-menu>
            </v-toolbar>
        </v-sheet>
        <v-sheet height="600">
            <v-calendar
            ref="calendar"
            v-model="focus"
            color="primary"
            :events="events"
            :event-color="getEventColor"
            :type="type"
            @click:event="showEvent"
            @click:more="viewDay"
            @click:date="viewDay"
            @change="updateRange"
            ></v-calendar>
            <v-menu
            v-model="selectedOpen"
            :close-on-content-click="false"
            :activator="selectedElement"
            offset-x
            >
                <v-card
                    color="grey lighten-4"
                    min-width="300px"
                    flat
                >
                    <v-toolbar
                    :color="selectedEvent.color"
                    dark
                    >
                    <!-- <v-btn icon @click="edit">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn> -->
                    <!-- <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title> -->
                    <v-spacer></v-spacer>
                    <!-- <v-btn icon>
                        <v-icon>mdi-heart</v-icon>
                    </v-btn> -->
                    <!-- <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn> -->
                    </v-toolbar>
                    <v-card-text>
                        <!-- <span v-html="selectedEvent.details"></span> -->
                        <div class="d-flex">
                            <v-list-item-avatar >
                                <img :src="selectedEvent.photo">
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title class="text-xl-h5 font-weight-medium">{{ selectedEvent.name_only }}</v-list-item-title>
                                <v-list-item-subtitle>
                                    <small class="text-xl-h6 blue--text">{{ selectedEvent.property }}</small>
                                </v-list-item-subtitle>
                                <v-list-item-subtitle>
                                    <small class="text-xl-h6 blue--text">Monthly Amortization - {{ formatCurrency(selectedEvent.monthly_amortization) }}</small>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </div>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-space-between">
                        <v-btn
                            text
                            color="secondary"
                            @click="selectedOpen = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="viewBuyerInfo"
                        >
                            View
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>
        </v-sheet>
        </v-col>
    </v-row>
</template>
<script>
import { Calendar } from '../../services/calendars'
export default {
    name: 'CalendarPage',
    middleware: 'auth',
    data: () => ({
        focus: '',
        type: 'month',
        typeToLabel: {
            month: 'Month',
            week: 'Week',
            day: 'Day',
            '4day': '4 Days',
        },
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        events: [],
        colors: ['red', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
        names: ['3 Past Dues', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
    
    created() {
        this.getPastDues()
    },

    mounted () {
        this.$refs.calendar.checkChange()
    },
    methods: {
        viewDay ({ date }) {
            this.focus = date
            this.type = 'day'
        },
        getEventColor (event) {
            return event.color
        },
        setToday () {
            this.focus = ''
        },
        prev () {
            this.$refs.calendar.prev()
        },
        next () {
            this.$refs.calendar.next()
        },
        showEvent ({ nativeEvent, event }) {
            console.log(event)
            const open = () => {
                this.selectedEvent = event
                this.selectedElement = nativeEvent.target
                requestAnimationFrame(() => {this.selectedOpen = true})
            }

            if (this.selectedOpen) {
                this.selectedOpen = false
                // requestAnimationFrame(() => requestAnimationFrame(() => open()))
                requestAnimationFrame(() => open())
            } else {
                open()
            }

            nativeEvent.stopPropagation()
        },
        updateRange ({ start, end }) {
            // const events = []

            // const min = new Date(`${start.date}T00:00:00`)
            // const max = new Date(`${end.date}T23:59:59`)
            // const days = (max.getTime() - min.getTime()) / 86400000
            // const eventCount = this.rnd(days, days)

            // for (let i = 0; i < eventCount; i++) {
            //     const allDay = this.rnd(0, 3) === 0
            //     const firstTimestamp = this.rnd(min.getTime(), max.getTime())
            //     const first = new Date(firstTimestamp - (firstTimestamp % 900000))
            //     const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
            //     const second = new Date(first.getTime() + secondTimestamp)

            //     events.push({
            //         name: this.names[this.rnd(0, this.names.length - 1)],
            //         start: first,
            //         end: second,
            //         color: this.colors[this.rnd(0, this.colors.length - 1)],
            //         timed: !allDay,
            //     })
            // }

            // const min = new Date(`${start.date}T00:00:00`)
            // const max = new Date(`${end.date}T23:59:59`)
            // console.log(start.date)
            // console.log(min.getTime())
            // console.log(max.getTime())
            // const firstTimestamp = this.rnd(min.getTime(), max.getTime())
            // const first = new Date(firstTimestamp )
           
        },
        rnd (a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a
        },

        edit () {
            // alert()
        },

        viewBuyerInfo () {
            
            this.$router.push({path: `/reservations/${this.selectedEvent.buyer_slug}`});
        },

        getPastDues () {
            Calendar.pastDues().then((response) => {
                if (response.data) {
                    response.data.forEach(dues => {
                        if (dues) {
                            dues.forEach(due => {
                                this.events.push({
                                    buyer_slug: due.buyer_slug,
                                    photo: due.photo,
                                    name: due.name + ' - ' + due.property,
                                    name_only: due.name,
                                    property: due.property,
                                    monthly_amortization: due.monthly_amortization,
                                    start: new Date(`${due.due_date}T00:00:00`),
                                    // end: second,
                                    color: this.colors[0],
                                    // timed: !allDay,
                                })

                                // this.events = events
                            });
                        }
                        
                        
                    });
                    const count = [];
                    response.data.forEach(dues => {
                        // console.log(dues)
                        if (dues) {
                            dues.forEach(due => {
                                count[due.due_date] = (count[due.due_date]||0) + 1
                            });
                            
                        }
                        
                    });

                    
                    // response.data.forEach(function(i) { count[i.due_date] = (count[i.due_date]||0) + 1;});
                    console.log(count.sort());
                }
                // this.paginateData = response.data
                // this.loaded = true
                // this.loading = false

                // const self = this

                // this.invoices = response.data.data.filter(function(reservation, index) {
                //     let total = 0
                //     const payments = reservation.payments

                //     payments.forEach(payment => {
                //         total += payment.amount
                //     });

                //     self.$set(reservation, 'index', index)

                //     self.$set(reservation, 'total_payment', total)

                //     self.$set(reservation, 'balance', self.getBalance(reservation))

                //     reservation.contract_price = '₱' + Number(reservation.contract_price).toLocaleString()

                //     if (self.filter_invoice === 'Upcoming Invoice' && reservation.upcoming_invoices.length) {
                //         return reservation
                //     }
                //     else if (self.filter_invoice === 'Past Due' && reservation.past_dues.length) {
                //         return reservation
                //     }
                //     else if (self.filter_invoice === 'Paid' && reservation.paids.length) {
                //         return reservation
                //     }
                //     return false
                // })
            });
        }
        
    },
  }
</script>
<style>
    .v-menu__content {
        max-width: 450px !important;
        min-width: 450px !important;
    }
</style>