<template>
    <section>
        <br>
        <div class="d-flex justify-space-between mx-6">
            <h1 class="title ml-2 text-h4">{{ location }} <small>Properties</small></h1>
            <v-btn
                class="ml-2"
                elevation="0"
                color="info"
                @click="$router.push('/locations/properties/create?id=' + $route.query.id + '&location=' + location)"
            >
                <v-icon>mdi-home-plus</v-icon> Add Property
            </v-btn>
        </div>
        <br>
        <div class="container-wrap">
            <v-card
                class="mx-auto mb-10"
                max-width="350"
                v-for="(property, i) in properties" :key="i"
            >
                <v-img
                    class="white--text align-end"
                    height="200px"
                    :src="property.photo"
                >
                <v-card-title>{{ property.model }}</v-card-title>
                </v-img>

                <v-card-text class="text--primary">
                    <div>Status: <span class="green--text font-weight-medium">{{ property.status }}</span></div>
                    <div>Block {{ property.block }}, Lot {{ property.lot }} <span v-if="property.phase">, Phase {{ property.phase }}</span></div>
                    <div>Lot Size: {{ property.lot_size }}</div>
                    <div>Floor Area: {{ property.floor_area }}</div>
                    <div>Contract Price: {{ '₱' + Number(property.contract_price).toLocaleString() }}</div>
                    <div>Default Amortization: {{ '₱' + Number(property.default_monthly_amortization).toLocaleString() }}</div>
                    <div>Term: {{ property.term }}</div>
                    
                    <!-- <div class="mt-3" v-if="property.description">{{ property.description.substring(0, 150) }} <a>.....</a></div> -->
                </v-card-text>

                <!-- <v-card-actions>
                <v-btn
                    color="orange"
                    text
                >
                    Share
                </v-btn>

                <v-btn
                    color="orange"
                    text
                >
                    Explore
                </v-btn>
                </v-card-actions> -->
            </v-card>
            <div class="filling-empty-space-childs"></div>
            <div class="filling-empty-space-childs"></div>
            <div class="filling-empty-space-childs"></div>
            <!-- <div class="filling-empty-space-childs"></div> -->
        </div>
    </section>
</template>

<script>
import { Property } from '../../../services/properties'
export default {
    name: "PropertiesIndex",
    data () {
        return {
            location: null,
            properties: []
        }
    },

    created () {
        if (this.$route.query.id) {
            this.getProperties()
        }
    },

    methods: {
        getProperties() {
            Property.all({location_id: this.$route.query.id}).then((response) => {
                if (response.data.data.length) {
                    this.properties = response.data.data[0].properties
                    this.location = response.data.data[0].location
                }
            });
        }
    },
}
</script>
<style>
    .card-text-wrap {
        min-height: 100px;
    }
 
    .container-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around
    }

    .filling-empty-space-childs {
        width: 25%;
        height:0; 
    }
</style>
