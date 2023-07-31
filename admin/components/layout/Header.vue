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
                        <v-img :src="data.item.profile.photo"></v-img>
                    </v-avatar>
                    {{ data.item.profile.last_name }}, {{ data.item.profile.first_name }} {{ data.item.profile.middle_name }}
                </v-chip>
            </template>
            <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'">
                    <v-list-item-content v-text="data.item"></v-list-item-content>
                </template>
                <template v-else>
                    <v-list-item-avatar>
                        <img :src="data.item.profile.photo">
                    </v-list-item-avatar>
                    <v-list-item-content @click="selectBuyer(data)">
                        <v-list-item-title class="font-weight-medium">{{ data.item.profile.last_name }}, {{ data.item.profile.first_name }} {{ data.item.profile.middle_name }}</v-list-item-title>
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
                    class="concept-w mr-2"
                    @change="selectBranch"
                ></v-select>
                <v-select
                    v-model="location"
                    :items="locations"
                    required
                    dense
                    hide-details="auto"
                    class="concept-w"
                    @change="selectLocation"
                ></v-select>
                <span class="ml-3">
                    <v-divider vertical />
                </span>

                <v-menu offset-y>
            <template v-slot:activator="{ attrs, on }">
                <span
                class="mx-5 mr-5"
                style="cursor: pointer"
                v-bind="attrs"
                v-on="on"
                >
                <v-badge content="3" color="red" offset-y="10" offset-x="10">
                    <v-icon>mdi-bell</v-icon>
                </v-badge>
                </span>
            </template>
            <v-list three-line width="295">
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

                <v-list-item v-else :key="item.title">
                    <v-list-item-avatar>
                    <v-img :src="item.avatar"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                    <v-list-item-title v-html="item.title"></v-list-item-title>
                    <v-list-item-subtitle
                        v-html="item.subtitle"
                    ></v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                </template>
            </v-list>
        </v-menu>
        
                <v-icon class="ml-3" color="primary" @click="$router.push('/payments/create')">mdi-cash-fast</v-icon>
                <v-icon class="ml-3" color="primary" @click="$router.push('/reservations/create')">mdi-home-plus</v-icon>
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
                    <span>{{ $auth.user.profile.first_name }} <v-icon>mdi-chevron-down</v-icon></span>
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
            locations: [],
            items: [
                {
                avatar: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
                title: "Brunch this weekend?",
                subtitle: `<span class="text--primary">Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`,
                },
                { divider: true, inset: true },
                {
                avatar: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
                subtitle: `<span class="text--primary">to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend.`,
                },
                { divider: true, inset: true },
                {
                avatar: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
                title: "Oui oui",
                subtitle:
                    '<span class="text--primary">Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?',
                },
                { divider: true, inset: true },
                {
                avatar: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
                title: "Birthday gift",
                subtitle:
                    '<span class="text--primary">Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?',
                },
                { divider: true, inset: true },
                {
                avatar: "https://cdn.vuetifyjs.com/images/lists/5.jpg",
                title: "Recipe to try",
                subtitle:
                    '<span class="text--primary">Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos.',
                },
            ],
            branch: 1,
            location: 1
        }
    },

    watch: {
        isUpdating (val) {
            if (val) {
                setTimeout(() => (this.isUpdating = false), 3000)
            }
        },

        // branch (val) {
        //     console.log(val)
        // }
    },

    created() {
        this.getBranch()
        this.buyers = []
        this.searchBuyer = _.debounce(this.searchBuyer, 300)
        
    },

    methods: {
        // ...mapMutations(['setBranch']),

        getBranch () {
            // console.log(localStorage.getItem('branch'))
            // console.log(localStorage.getItem('location'))
            // if (localStorage.getItem('branch') && !localStorage.getItem('location')) {
                
            //     if (localStorage.getItem('branch') === 1) {
            //         localStorage.setItem('location', 1)
            //         this.location = 1
            //     } else {
            //         localStorage.setItem('location', 2)
            //         this.location = 2
            //     }
            // } 

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
                            this.branch = parseInt(localStorage.getItem('branch'))
                        } else {
                            localStorage.setItem('branch', parseInt(this.branches[0].value))
                        }
                    }
                    

                    if (res.data.data.length) {
                        const self = this
                        this.locations =  res.data.data.filter(function (el) {
                            return el.id  === self.branch
                        })[0].locations.map(function(data) {
                            return {
                                text: data.location,
                                value: data.id
                            }
                        })
                    }
                    
                    if (localStorage.getItem('location')) {
                        this.location = parseInt(localStorage.getItem('location'))
                    } else {
                        localStorage.setItem('location', parseInt(this.locations[0].value))
                        this.location = this.locations[0].value
                    }
                }
            });
        },

        getItemText(item) {
            return `${item.profile.last_name} ${item.profile.first_name} ${item.profile.middle_name} ${item.email}`;
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
                    if (res.data.data.length) {
                        this.buyers = res.data.data
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
            
            if (value === 1) {
                localStorage.setItem('location', 1)
            } else {
                localStorage.setItem('location', 2)
            }
            
            location.reload()
        },

        selectLocation (value) {
            const findLocation = this.locations.find(function(data) {
                return (data.value === value)
            })
            
            localStorage.setItem('location', parseInt(value))
            localStorage.setItem('location_name', findLocation.text)

            location.reload()
        },
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