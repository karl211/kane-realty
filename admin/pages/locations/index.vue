<template>
    <section>
        <h1 class="title ml-2">Locations</h1>
        <br>
        <div>
            <v-btn
                class="ml-2"
                elevation="0"
                color="info"
                @click="$router.push('/locations/create')"
            >
                <v-icon>mdi-map</v-icon> Add Location
            </v-btn>
        </div>
        <br>
        <div class="container-wrap content-w">
            <v-card
                class="item-wide mr-10 mb-10"
                max-width="500"
                v-for="(location, i) in locations" :key="i"
                @click="$router.push(`/locations/properties?id=${location.id}`)"
            >
                <div id="map-container-google-1" class="z-depth-1-half map-container" style="width: 400px;">
                    <iframe :src="location.map" frameborder="0"
                    style="border:0; height: 250px; width: 400px;" allowfullscreen></iframe>
                </div>

                <v-card-title>{{ location.location }}</v-card-title>

                <v-card-text class="text--primary card-text-wrap">
                    <div>{{ location.description }}</div>
                    <div>Total property: <span class="text--font-weight-medium orange--text text-sm-h6">{{ location.properties.length }}</span></div>
                </v-card-text>

                <v-card-actions>
                    <v-btn
                        color="orange"
                        text
                    >
                        View
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>
    </section>
</template>

<script>
import Swal from 'sweetalert2'
import { Location } from '../../services/locations'
export default {
    name: "PropertiesIndex",
    data () {
        return {
            loading: false,
            loaded: false,
            search: "",
            prof_title_id: "",
            headers: [
                {
                text: 'Location',
                align: 'start',
                },
                { text: 'Property', value: 'property' },
                
            ],
            mapProfessionalTitles: [
                'Location'
            ],

            
            locations: []
        }
    },

    created () {
        
        this.getProperties()
    },

    methods: {
        getProperties() {
            Location.all().then((response) => {
                if (response.data) {
                    this.locations = response.data.data
                }
            }).catch(error => {
                if (error.response) {
                    Swal.fire(
                        'Ops.',
                        error.response.data.message,
                        'warning'
                    )
                }
            })
        }
    },
}
</script>
<style>
    .card-text-wrap {
        min-height: 50px;
    }
    .content-w {
        margin-left: 10%;
    }
    .container-wrap {
        display: flex;
        flex-wrap: wrap;
    }
</style>
