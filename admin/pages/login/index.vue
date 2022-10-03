<template>
<v-row>
    <v-col cols="12" lg="7" xl="6" class="info d-none d-md-flex align-center justify-center">
        <v-container>
            <div class="pa-10">
                <v-row justify="center">
                    <v-col cols="8" xl="5">
                    <div>
                        <h2
                        class="display-1 white--text font-weight-medium"
                        >Elegant Design with unlimited features, built with love</h2>
                        <h6
                        class="subtitle-1 mt-4 white--text op-5 font-weight-regular"
                        >Wrappixel helps developers to build organized and well-coded admin dashboards full of beautiful and feature rich modules.</h6>
                        <v-btn class="mt-4 text-capitalize" x-large outlined color="white">Learn More</v-btn>
                    </div>
                    </v-col>
                </v-row>
            </div>
        </v-container>
    </v-col>
    <v-col cols="12" lg="5" xl="6" class="d-flex align-center">
        <v-container>
            <div class="pa-7 pa-sm-12">
                <v-row>
                    <v-col cols="12" lg="9" xl="6">
                    <!-- <img style="width:100%" src="/images/ethesia-logo-colored.png" /> -->
                    <h2 class="font-weight-bold mt-4 blue-grey--text text--darken-2">Sign in</h2>

                    <v-form ref="form" v-model="valid" @submit.prevent="submit" lazy-validation >
                        <v-text-field
                            v-model="email"
                            :rules="emailRules"
                            label="E-mail"
                            class="mt-4"
                            required
                            outlined
                            :error="hasErrorMessage"
                        ></v-text-field>
                        <v-text-field
                            v-model="password"
                            :rules="passwordRules"
                            label="Password"
                            required
                            outlined
                            :error="hasErrorMessage"
                            hide-details
                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                            :type="show1 ? 'text' : 'password'"
                            @click:append="show1 = !show1"
                        ></v-text-field>
                        <div v-if="hasErrorMessage" class="red--text darken-1 pt-2">{{ errorMessage }}</div>
                        <v-btn
                            :disabled="!valid || loading"
                            :loading="loading"
                            color="info"
                            block
                            class="mr-4 mt-4"
                            type="submit"
                        >Sign In</v-btn>
                    </v-form>
                    
                    </v-col>
                </v-row>
            </div>
        </v-container>
    </v-col>
</v-row>
</template>
<script>
// import { Auth } from '../../services/auth'
export default {
    name: "loginPage",
    layout (context) {
        return 'login'
    },
    data: () => ({
        valid: true,
        loading: false,
        password: '',
        email: '',
        show1: false,
        passwordRules: [
            v => !!v || "Password is required"
        ],
        emailRules: [
            v => !!v || "E-mail is required",
            v => /.+@.+\..+/.test(v) || "E-mail must be valid"
        ],
        hasErrorMessage: false,
        errorMessage: 'Invalid email or password',
    }),
    watch: {
        email() {
            this.hasErrorMessage = false
        },
        password() {
            this.hasErrorMessage = false
        },
    },
    methods: {
        async submit() {
            try {
                const response = await this.$auth.loginWith("local", { data: {
                        email: this.email,
                        password: this.password
                    } 
                })

                if (response.status === 200) {
                    localStorage.setItem( 'auth_token', response.data.token );
                }

                this.$router.push({name: "index"});
            } catch (error) {
                console.log(error);
                // if (error.response.status === 422) {
                //     // this.errors = error?.response?.data?.errors;
                //     return;
                // }
                // if (error.response.status === 401) {
            }
            // this.$nuxt.$loading.start();
            // try {
            //     const response = await this.$auth.loginWith("laravelSanctum", { data: {
            //             email: this.email,
            //             password: this.password
            //         } 
            //     });

            //     if (response.status === 200) {
            //         Auth.user().then((response) => {
            //             console.log(response.data.data)
            //             // this.$auth.setUser(response.data.data)
            //             // this.$auth.setUser(response.data.data)
            //             // this.$auth.$storage.setUniversal('user', response.data.data)
            //             // this.$auth.$storage.setUniversal('loggedIn', true)
            //         });

            //         // this.$axios.$get('/user')
            //         // .then(res => {
            //         //     console.log(res.data)
            //         //     // this.$auth.setUser(res.data)
            //         // })

            //         localStorage.setItem( 'auth_token', response.data.token );
            //     }
            //     this.$router.push({
            //         path: "/",
            //     });
            // } catch (err) {
            //     console.log(err);
            // }
            // this.$nuxt.$loading.finish()
        },

        
        // async submit() {
        //     this.loading = true
        //     this.$refs.form.validate();
            
        //     if (this.$refs.form.validate(true)) {
        //         await this.$auth.loginWith('laravelSanctum', {
        //             data: {
        //                 email: this.email,
        //                 password: this.password
        //             }
        //         }).then((response)=>{
        //             this.loading = false

        //             if (response.status === 200) {
        //                 localStorage.setItem( 'auth_token', response.data.token );
        //             }
        //         }).catch((error) => {
        //             this.loading = false

        //             if (error.response) {
        //                 this.hasErrorMessage = true
        //             }
        //         })

        //         this.$router.push('/')
        //     } else {
        //         this.loading = false
        //     }
        // }
    },
};
</script>