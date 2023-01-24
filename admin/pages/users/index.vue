<template>
  <div>
    <!-- <v-data-table
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1"
      ></v-data-table> -->
    <section>
        <h1 class="title">Users</h1>
        <br>
        <v-row>
            <v-col md="3" sm="6" xs="12" v-for="(user, i) in users" :key="i">
                <v-card
                    class="mx-auto mb-5"
                    max-width="350"
                    
                >
                    <v-card-text class="pa-0">
                        <div class="container text-center pt-10">
                            <v-img
                                class="avatar-lg rounded-circle m-auto"
                                :src="user.profile.photo"
                            >
                            </v-img>
                            <h1 class="mt-5">{{ user.profile?.full_name }}</h1>
                            <h4 class="my-2">{{ user.role_name }}</h4> 
                        </div>
                        <div class="d-flex mt-3">
                            <v-btn color="link" class="w-50 rounded-0 warning--text" @click="edit">
                                <v-icon small>
                                    mdi-pencil
                                </v-icon> 
                                Edit
                            </v-btn>
                            <v-btn color="link" class="w-50 rounded-0 danger--text" @click="remove(user)">
                                <v-icon small>
                                    mdi-delete-forever
                                </v-icon> 
                                Delete
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        
     
    </section>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { User } from '../../services/users'
    export default {
    name: "UsersIndex",
    data () {
        return {
            loading: false,
            loaded: false,
            search: "",
            prof_title_id: "",
            users: []
        }
    },
    
    created () {
        this.getUsers() 
    },

    methods: {
        getUsers () {
            User.all().then((res) => {
                this.users = res.data.data
            });
        },

        edit () {

        },

        remove (item) {
            Swal.fire({
                title: 'Are you sure?',
                showCancelButton: true,
                icon: 'warning',
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    User.remove({id: item.id}).then((response) => {
                        if (response.data) {
                            Swal.fire({
                                title: 'Done!',
                                text: 'Successfully deleted',
                                confirmButtonText: 'Okay',
                                icon: 'success',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                } 
                            })
                        }
                    }).catch(error => {
                        // Handle error
                        if (error.response) {
                            Swal.fire(
                                'Ops.',
                                'Something went wrong',
                                'warning'
                            )
                            // const self = this
                            // setTimeout(() => {
                                
                            // }, 1000);
                            // this.errors = error.response.data.errors
                        }
                    })
                }
            })
        }
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
</style>