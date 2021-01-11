<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@1.x/dist/vuetify.min.css" rel="stylesheet">
    <link href="frontend/css/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<div id="app">
    <v-app>
        <v-content>
            <v-container fill-height
                         fluid
            >
                <v-layout>
                    <v-flex xs12 sm6 offset-sm3>
                        <v-card>
                            <v-card-title>
                                <div>
                                    <span class="grey--text">CodeLib (CL) Sample App - A VueJs app created with CL</span><br>
                                    <h3>A VueJs app created with CL, without NodeJs</h3><br>
                                    <span>It consists of a simple VueJs based frontend, and a PHP backend.</span>
                                    <span>The frontend presents a Login screen, and on successful login displays a simple
                                    user dashboard, with information about a fictitious website owned by the user.</span>
                                    <span>The backend uses a MySql database to store and authenticate user information.
                                    It receives login info via JSON and sends a JSON response back to the frontend,
                                        which includes login status, as well as website data if login was successful. That's it!</span>

                                </div>
                            </v-card-title>
                            <router-view></router-view>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@1.x/dist/vuetify.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vuex"></script>
<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
<script src="frontend/js/widget.js"></script>
<script src="frontend/js/login.js"></script>
<script src="frontend/js/register.js"></script>
<script src="frontend/js/home.js"></script>
<script src="frontend/js/router.js"></script>
<script src="frontend/js/app.js"></script>
</body>
</html>
