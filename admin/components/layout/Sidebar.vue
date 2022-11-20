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
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.to"
          color="primary"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
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
        { title: 'Payments', icon: 'mdi-cash-clock', to: '/payments' },
        { title: 'Locations', icon: 'mdi-home-group', to: '/locations' },
        { title: 'Invoices', icon: 'mdi-list-box-outline', to: '/invoices' },
        { title: 'Reports', icon: 'mdi-note', to: '/reports' },
        { title: 'Users', icon: 'mdi-account', to: '/users' },
      ],
    }),
    watch: {
      toggleSidebar(val) {
        this.drawer = val
      }
    }
  }
</script>