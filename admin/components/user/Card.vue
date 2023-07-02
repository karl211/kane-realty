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
                        <v-card-text style="height: 400px;">
                            <v-row>
                                <v-col cols="6" v-for="(access, i) in accesses" :key="i">
                                    <v-checkbox
                                    hide-details="auto"
                                    :key="i"
                                    :label="`${access.label.toUpperCase()}`"
                                    v-model="access.value"
                                    ></v-checkbox>

                                    <template v-if="access.value">
                                        <v-col cols="6" class="pa-0 pl-7" v-for="(sub_access, i) in access.sub_accesses" :key="i + '-sub'">
                                            <v-checkbox
                                            hide-details="auto"
                                            :key="i + '-sub'"
                                            :label="`${sub_access.label.toUpperCase()}`"
                                            v-model="sub_access.value"
                                            style="font-size: 12px;"
                                            class="sub-access mt-1">
                                            </v-checkbox>
                                        </v-col>
                                    </template>
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
            { label: 'dashboard', key: 'dashboard_access', value: false, sub_accesses: [] },
            { label: 'calendar', key: 'calendar_access', value: false, sub_accesses: [] },
            { 
                key: 'reservation_access', 
                label: 'reservations', 
                value: false,
                sub_accesses: [
                    {
                        key: 'reservation_create',
                        label: 'add',
                        value: false
                    },
                    {
                        key: 'reservation_edit',
                        label: 'edit',
                        value: false
                    },
                    {
                        key: 'reservation_delete',
                        label: 'delete',
                        value: false
                    }
                ]
            },
            { 
                key: 'receipt_access', 
                label: 'receipts', 
                value: false,
                sub_accesses: [
                    {
                        key: 'receipt_create',
                        label: 'add',
                        value: false
                    },
                    {
                        key: 'receipt_edit',
                        label: 'edit',
                        value: false
                    },
                    {
                        key: 'receipt_delete',
                        label: 'delete',
                        value: false
                    }
                ]
            },
            { 
                key: 'location_access', 
                label: 'locations', 
                value: false,
                sub_accesses: [
                    {
                        key: 'location_create',
                        label: 'add',
                        value: false
                    },
                    {
                        key: 'location_edit',
                        label: 'edit',
                        value: false
                    },
                    {
                        key: 'location_delete',
                        label: 'delete',
                        value: false
                    }
                ]
            },
            { key: 'invoice_access', label: 'invoices', value: false },
            { key: 'report_access', label: 'reports', value: false, sub_accesses: [] },
            { key: 'user_access', label: 'users', value: false, sub_accesses: [] },
        ],
    }),

    created () {
        this.mapPermissions()
    },

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
            User.saveAccess({user_id: this.user.id, access: this.accesses}).then((response) => {
                if (response.data) {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Successfully saved',
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
        },

        mapPermissions () {
            this.user.permissions.forEach(permission => {
                this.accesses.forEach(access => {
                    if(access.key === permission) {
                        access.value = true
                    }

                    if (access.sub_accesses) {
                        access.sub_accesses.forEach(subAccess => {
                            if (subAccess.key === permission) {
                                subAccess.value = true
                            }
                        });
                    }
                });
            });
        }
    }
}
</script>
<style>
    .sub-access i {
        font-size: 20px !important;
    }
    .sub-access label {
        font-size: 12px;
    }
</style>

