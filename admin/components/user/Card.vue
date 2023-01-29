<template>
    <v-card
        class="mx-auto mb-5"
        max-width="350"
        height="276"
        
    >
        <v-card-text class="pa-0">
            <div class="container text-center pt-10">
                
                <v-row justify="center" class="mt-5">
                    <v-dialog
                        v-model="openAccess"
                        scrollable
                        max-width="500px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon 
                            large 
                            class="menu-icon"
                            v-bind="attrs"
                            v-on="on">
                            mdi-dots-horizontal
                        </v-icon>
                    </template>
                    <v-card>
                        <v-card-title>Manage User Access</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text style="height: 300px;">
                            <v-row>
                                <v-col cols="6" v-for="(access, i) in accesses" :key="i">
                                    <v-checkbox
                                    hide-details="auto"
                                    :key="i"
                                    :label="`${access.label.toUpperCase()}`"
                                    v-model="access[access.label]"
                                    ></v-checkbox>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions class="d-flex justify-lg-space-around">
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="openAccess = false"
                            >
                                Close
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="saveAccess"
                            >
                                Save
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-row>
                
                <v-img
                    class="avatar-lg rounded-circle m-auto"
                    :src="user.profile.photo"
                >
                </v-img>
                <h1 class="mt-5">{{ user.profile?.full_name }}</h1>
                <h4 class="my-2">{{ user.role_name }}</h4> 
            </div>
            <div class="d-flex mt-6">
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
</template>
<script>
import Swal from 'sweetalert2'
import { User } from '../../services/users'
export default {
    name: "UserCard",
    props: {
        user: {
            type: Object,
            default: () => {}
        }
    },
    data: vm => ({
        openAccess: false,
        accesses: [
            { label: 'calendar', calendar: false },
            { label: 'reservations', reservations: false },
            { label: 'receipts', receipts: false },
            { label: 'locations', locations: false },
            { label: 'invoices', invoices: false },
            { label: 'reports', reports: false },
            { label: 'users', users: false },
        ],
    }),

    methods: {
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
                    User.removeUser({id: item.id}).then((response) => {
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
        },

        saveAccess () {
            console.log(this.accesses)
        }
    }
}
</script>

