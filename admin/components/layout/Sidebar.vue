<template>
    <v-navigation-drawer
    v-model="drawer"
    app
    >
    <v-list-item>
        <v-list-item-content>
        <v-list-item-title class="text-h6">
            Kane Realty
        </v-list-item-title>
        <!-- <v-list-item-subtitle>
            Inc
        </v-list-item-subtitle> -->
        </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list
        dense
        nav
    >
        <div v-for="item in items" :key="item.title">
            
            <v-list-group
                v-if="item.title == 'Reports'"
                :value="true"
                no-action
                sub-group
                class="report"
                >
                <v-icon slot="prependIcon" >mdi-note</v-icon>
      
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title>Reports</v-list-item-title>
                    </v-list-item-content>
                </template>

                <v-list-item
                    v-for="(item, i) in admins"
                    :key="i"
                    :to="item.to"
                    link
                >
                    <v-list-item-title v-text="item.title"></v-list-item-title>
                </v-list-item>
            </v-list-group>
            
            <v-list-item
                v-else
                :to="item.to"
                color="primary">
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </div>

        

        

        
    </v-list>
    </v-navigation-drawer>
</template>
<script>
export default {
    name: 'DefaultLayout',
    props: {
        toggleSidebar: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
    drawer: null,
    items: [
        { title: 'Dashboard', icon: 'mdi-view-dashboard', to: '/dashboard' },
        { title: 'Calendar', icon: 'mdi-calendar', to: '/calendar' },
        { title: 'Reservations', icon: 'mdi-book-account', to: '/reservations' },
        { title: 'Receipts', icon: 'mdi-cash-clock', to: '/receipts' },
        { title: 'Locations', icon: 'mdi-home-group', to: '/locations' },
        { title: 'Invoices', icon: 'mdi-list-box-outline', to: '/invoices' },
        { title: 'Reports', icon: 'mdi-note', to: '/reports' },
        { title: 'Users', icon: 'mdi-account', to: '/users' },
    ],
    admins: [
        { title: 'Sales', icon: 'mdi-network-pos', to: '/reports/sales' },
        { title: 'Expenses', icon: 'mdi-cash-fast', to: '/reports/expenses' },
    ],
    }),
    watch: {
    toggleSidebar(val) {
        this.drawer = val
    }
    }
}
</script>
<style>
.v-list-group__header {
    padding-left: 8px !important;
}
.report .v-list-item__icon {
    padding-right: 16px !important;
}
</style>
