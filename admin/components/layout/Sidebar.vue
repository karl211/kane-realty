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
                v-if="item.title == 'Reports' && item.isShow"
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
                v-else-if="item.isShow"
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
            { menu_id: 'dashboard_access', isShow: false, title: 'Dashboard', icon: 'mdi-view-dashboard', to: '/dashboard' },
            { menu_id: 'calendar_access', isShow: false, title: 'Calendar', icon: 'mdi-calendar', to: '/calendar' },
            { menu_id: 'reservation_access', isShow: false, title: 'Reservations', icon: 'mdi-book-account', to: '/reservations' },
            { menu_id: 'receipt_access', isShow: false, title: 'Receipts', icon: 'mdi-cash-clock', to: '/receipts' },
            { menu_id: 'location_access', isShow: false, title: 'Locations', icon: 'mdi-home-group', to: '/locations' },
            { menu_id: 'invoice_access', isShow: false, title: 'Invoices', icon: 'mdi-list-box-outline', to: '/invoices' },
            { menu_id: 'report_access', isShow: false, title: 'Reports', icon: 'mdi-note', to: '/reports' },
            { menu_id: 'user_access', isShow: false, title: 'Users', icon: 'mdi-account', to: '/users' },
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
    },
    created () {
        const permissions = this.$auth.user.permissions
        const roles = this.$auth.user.roles
        
        if (roles.length) {
            if (roles[0].name === 'Super Admin') {
                this.items.forEach(item => {
                    item.isShow = true
                });
            } else {
                permissions.forEach(permission => {
                    const menu = this.items.find(function (item) {
                        return item.menu_id === permission.name
                    })

                    if (menu) {
                        menu.isShow = true
                    }
                });
            }
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
