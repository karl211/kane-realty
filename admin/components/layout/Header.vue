<template>
    <v-app-bar app>
      <v-text-field
        label="Search..."
        prepend-inner-icon="mdi-magnify"
        solo
        flat
        class="mt-7"
      ></v-text-field>
      <v-spacer></v-spacer>
      
        <div class="mr-3">
            <v-icon color="primary" @click="$router.push('/reservations/create')">mdi-home-plus</v-icon>
        </div>

      <v-menu
        offset-y
        transition="slide-y-transition"
        nudge-bottom="15"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            id="activator"
            v-bind="attrs"
            v-on="on"
            depressed
            tile
            class="pa-3"
            
          >
            <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->
            <v-avatar
              size="36px"
              class="mr-2"
            >
              <img
                alt="Avatar"
                src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460"
              >
            </v-avatar>
            <span>Marcus <v-icon>mdi-chevron-down</v-icon></span>
          </v-btn>
        </template>

        <v-list class="pa-0">
          <v-list-item class="pointer subtitle-2">
            <v-icon class="pr-2">mdi-account-cog</v-icon> Profile
          </v-list-item>
          <v-list-item class="pointer subtitle-2" @click="$emit('logout')">
            <v-icon class="pr-2">mdi-logout</v-icon> Logout
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
</template>
<script>
  export default {
    name: 'HeaderLayout',
    data() {
      return {
        search: ''
      }
    },
    method: {
      // logout() {
      //   alert()
      //   // await this.$auth.logout()
      // }
    }
  }
</script>
<style>
  .pointer {
    cursor: pointer;
  }
</style>