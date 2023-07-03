<template>
  <div>
    <section>
        <h1 class="title">Users</h1>
        <br>
        <v-row>
            <v-col md="3" sm="6" xs="12" v-for="(user, i) in users" :key="i">
                <UserCard :user="user"/>
            </v-col>
        </v-row>
    </section>
  </div>
</template>

<script>

import { User } from '../../services/users'
    export default {
    name: "UsersIndex",
    data () {
        return {
            users: []
        }
    },
    
    created () {
        this.getEmployees() 
    },

    methods: {
        getEmployees () {
            User.employees().then((res) => {
                this.users = res.data.data
            });
        },
    }
}
</script>
<style lang="scss">
    .m-auto {
        margin: auto;
        text-align: center;
    }

    .card-text-wrap {
        min-height: 100px;
    }

    .filling-empty-space-childs {
        width: 25%;
        height:0; 
    }

    .container-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around
    }

    .menu-icon {
        cursor: pointer;
        position: absolute !important;
        top: 1rem !important;
        right: 1rem !important;
    }
</style>