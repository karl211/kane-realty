<template>
    <v-card
        class="mx-auto max-card-h"
    >
        <br>
        <v-img
            v-if="buyer"
            class="rounded-circle mx-auto"
            width="150"
            height="150"
            :src="buyer?.profile?.photo"
        ></v-img>
        
        <v-card-text class="text-center">
            <h3>{{ buyer?.profile?.full_name || 'NONE' }}</h3>
            <p>Buyer</p>
        </v-card-text>

        <v-divider class="mx-4"></v-divider>

        <v-card-text class="text-left">
            <div>
                <h3>Name:</h3>
                <p>{{ buyer?.profile?.first_name || 'NONE' }} {{ buyer?.profile?.middle_name || 'NONE' }} {{ buyer?.profile?.last_name || 'NONE' }}</p>
            </div>

            <div>
                <h3>Contact no:</h3>
                <p>{{ buyer?.profile?.contact_number || 'NONE' }}</p>
            </div>

            <div>
                <h3>E-mail:</h3>
                <p>{{ buyer?.email || 'NONE' }}</p>
            </div>

            <div>
                <h3>Gender:</h3>
                <p>{{ buyer?.profile?.gender || 'NONE' }}</p>
            </div>

            <div>
                <h3>TIN:</h3>
                <p>{{ buyer?.profile?.tin || 'NONE' }}</p>
            </div>

            <div>
                <h3>Civil status:</h3>
                <p>{{ buyer?.profile?.civil_status || 'NONE' }}</p>
            </div>

            <div>
                <h3>Date of Birth:</h3>
                <p>{{ buyer?.profile?.date_of_birth || 'NONE' }}</p>
            </div>

            <div>
                <h3>Address:</h3>
                <p>{{ buyer?.profile?.address || 'NONE' }}</p>
            </div>
        </v-card-text>
    </v-card>
    <!-- <div v-else class="center-loading">
        <v-progress-circular
            indeterminate
            color="primary"
        ></v-progress-circular>
    </div> -->
</template>
<script>
import ReservationMixin from "~/mixins/ReservationMixin.js"
export default {
    name: "CommonInformationCreate",
    mixins: [ReservationMixin],
    props: {
        buyer: {
            type: Object,
            default: () => {}
        }
    },
    data: vm => ({
        
    }),
}
</script>