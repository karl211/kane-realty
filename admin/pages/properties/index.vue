    <template>
    <div>
    <!-- <v-data-table
        :headers="headers"
        :items="properties"
        :items-per-page="5"
        class="elevation-1"
        ></v-data-table> -->
    <section>
        <h1 class="title">Locations</h1>
        <br>
        <div class="container-wrap content-w">
            <v-card
                class="item-wide mr-10 mb-10"
                max-width="500"
                v-for="(location, i) in locations" :key="i"
            >
                <!-- <v-img
                    class="white--text align-end"
                    height="250px"
                    :src="location.photo"
                > -->
                <div id="map-container-google-1" class="z-depth-1-half map-container" style="width: 500px;">
                    <iframe :src="location.map" frameborder="0"
                    style="border:0; height: 350px; width: 500px;" allowfullscreen></iframe>
                </div>

                <v-card-title>{{ location.location }}</v-card-title>
                <!-- </v-img> -->

                <v-card-text class="text--primary card-text-wrap">
                    <div>{{ location.description }}</div>
                    <div>Total property: <span class="text--font-weight-medium orange--text text-sm-h6">{{ location.properties.length }}</span></div>
                </v-card-text>
            </v-card>
        </div>
        <!-- <v-row >
            <v-col sm="4">
                
            </v-col>
            <v-col sm="4">
                <v-card
                    class="mx-auto"
                    max-width="400"
                    
                >
                    <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    >
                    <v-card-title>Top 10 Australian beaches</v-card-title>
                    </v-img>

                    <v-card-subtitle class="pb-0">
                    Number 10
                    </v-card-subtitle>

                    <v-card-text class="text--primary">
                    <div>Whitehaven Beach</div>

                    <div>Whitsunday Island, Whitsunday Islands</div>
                    </v-card-text>

                    <v-card-actions>
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
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col sm="4">
                <v-card
                    class="mx-auto"
                    max-width="400"
                    
                >
                    <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    >
                    <v-card-title>Top 10 Australian beaches</v-card-title>
                    </v-img>

                    <v-card-subtitle class="pb-0">
                    Number 10
                    </v-card-subtitle>

                    <v-card-text class="text--primary">
                    <div>Whitehaven Beach</div>

                    <div>Whitsunday Island, Whitsunday Islands</div>
                    </v-card-text>

                    <v-card-actions>
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
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row> -->
    </section>
    </div>
</template>

<script>
import { Property } from '../../services/properties'
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
            Property.all().then((response) => {
                if (response.data) {
                    this.locations = response.data.data
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
    .content-w {
        margin-left: 10%;
    }
    .container-wrap {
        display: flex;
        flex-wrap: wrap;
    }
</style>
