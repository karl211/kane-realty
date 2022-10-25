<template>
    <v-app-bar app>
        <v-autocomplete
            v-model="buyer"
            :disabled="isUpdating"
            :items="buyers"
            filled
            chips
            color="blue-grey lighten-2"
            label="Search..."
            :item-text="getItemText"
            item-value="id"
            solo
            flat
            hide-no-data
            class="mt-7"
            @update:search-input="searchBuyer"
        >
            <template v-slot:selection="data">
                <v-chip
                    v-bind="data.attrs"
                    :input-value="data.selected"
                    close
                    @click:close="remove(data.item)"
                >
                    <v-avatar left>
                        <v-img :src="data.item.photo"></v-img>
                    </v-avatar>
                    {{ data.item.last_name }}, {{ data.item.first_name }} {{ data.item.middle_name }}
                </v-chip>
            </template>
            <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'">
                    <v-list-item-content v-text="data.item"></v-list-item-content>
                </template>
                <template v-else>
                    <v-list-item-avatar>
                        <img :src="data.item.photo">
                    </v-list-item-avatar>
                    <v-list-item-content @click="selectBuyer(data)">
                        <v-list-item-title class="font-weight-medium">{{ data.item.last_name }}, {{ data.item.first_name }} {{ data.item.middle_name }}</v-list-item-title>
                        <v-list-item-subtitle>
                            <small class="text-md-caption blue--text">{{ data.item.email }}</small>
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </template>
        </v-autocomplete>

        <v-spacer></v-spacer>
        
        <div class="mr-3">
            <div class="d-flex">
                <v-select
                    v-model="branch"
                    :items="branches"
                    required
                    dense
                    hide-details="auto"
                    class="concept-w"
                    @change="selectBranch"
                ></v-select>
                <v-icon color="primary" @click="$router.push('/reservations/create')">mdi-home-plus</v-icon>
            </div>
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
                <v-list-item class="pointer subtitle-2" @click="logout">
                    <v-icon class="pr-2">mdi-logout</v-icon> Logout
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>
<script>
import _ from 'lodash'
// import { mapMutations } from 'vuex'
import { Auth } from '../../services/auth'
export default {
    name: 'HeaderLayout',
    data () {
        return {
            autoUpdate: true,
            buyer: '',
            isUpdating: false,
            buyers: [],
            branches: [],
            branch: 1
        }
    },

    watch: {
        isUpdating (val) {
            if (val) {
                setTimeout(() => (this.isUpdating = false), 3000)
            }
        },
    },

    created() {
        this.buyers = []
        this.searchBuyer = _.debounce(this.searchBuyer, 360)
        this.getBranch()
    },

    methods: {
        // ...mapMutations(['setBranch']),

        getBranch () {
            Auth.branch().then((res) => {
                if (res.data.data.length) {
                    this.branches = res.data.data.map(function(data) {
                        return {
                            text: data.branch,
                            value: data.id
                        }
                    })

                    if (this.branches.length) {
                        if (localStorage.getItem('branch')) {
                            this.$store.commit('account/setBranch', parseInt(localStorage.getItem('branch')))

                            this.branch = parseInt(localStorage.getItem('branch'))
                        } else {
                            localStorage.setItem('branch', parseInt(this.branches[0].value))
                            this.$store.commit('account/setBranch', parseInt(this.branches[0].value))
                        }
                    }
                }

                // console.log(this.$store.getters['account/getBranch'])
            });
        },

        getItemText(item) {
            return `${item.last_name} ${item.first_name} ${item.middle_name} ${item.email}`;
        },

        remove (item) {
            this.buyer = ''
            this.buyers = []
        },

        logout () {
            localStorage.removeItem('branch');
            this.$emit('logout')
        },

        searchBuyer (keyword) {
            if (keyword) {
                Auth.searchBuyer({search: keyword}).then((res) => {
                    if (res.data.data.data.length) {
                        this.buyers = res.data.data.data
                    }
                });
            } else {
                this.buyers = []
            }
        },

        selectBuyer (data) {
            this.$router.push({path: `/reservations/${data.item.slug}`});
        },

        selectBranch (value) {
            localStorage.setItem('branch', parseInt(value))
            this.$store.commit('account/setBranch', parseInt(value))

            location.reload()
        }
    },
}
</script>
<style>
.pointer {
    cursor: pointer;
}
.concept-w {
    width: 160px;
}
</style>