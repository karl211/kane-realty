<template>
  <v-app>
    <template v-if="this.$auth.loggedIn">
      <LayoutSidebar  :toggle-sidebar="drawer"/>
      <LayoutHeader v-if="this.$auth.loggedIn" @logout="logoutUser"/>
    </template>

    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>
<script>
  export default {
    name: 'DefaultLayout',
    middleware: 'auth',
    data: () => ({ 
      drawer: true,
    }),
    methods: {
      toggleSidebar() {
        this.drawer = !this.drawer
      },
      logoutUser() {
        this.$auth.logout('laravelSanctum').then((res) => {
          this.$router.replace({ name: "login" });
        });
      }
    },
  }
</script>
