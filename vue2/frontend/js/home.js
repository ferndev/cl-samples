const Home = {template: `
        <v-container fluid grid-list-xl>
            <v-layout row wrap>
                <v-flex xs12 sm6 offset-sm3>
                        <v-card>
                            <v-card-title>
                                <div>
                                    <span class="grey--text">User Dashboard</span><br>
                                    <h3>Welcome back, {{ username }}</h3>
                                    <v-btn color="blue darken-1" text @click="logout">Logout</v-btn><br>
                                </div>
                            </v-card-title>
                        </v-card>
                    </v-flex>
            </v-layout>
            <v-layout row wrap>
              <!-- Widgets-->
              <v-flex d-flex lg3 sm6 xs12>
                <widget icon="domain" :title="visits" subTitle= '13% higher yesterday' supTitle="Today's Visits" color="#00b297"/>
              </v-flex>
              <v-flex d-flex lg3 sm6 xs12>
                <widget icon="money_off" :title="sales" subTitle= 'no tax deducted' supTitle="Today's Sales" color="#dc3545"/>
              </v-flex>
              <v-flex d-flex lg3 sm6 xs12>
                <widget icon="computer" :title="uniquevisits" subTitle= '13% average duration' supTitle="% Unique Visits" color="#0866C6"/>
              </v-flex>
            </v-layout>
        </v-container>
        `,
    data () {
        return {
            feedback: 'CL Docs',
            username: this.$store.state.username,
            visits: this.$store.state.visits,
            sales: this.$store.state.sales,
            uniquevisits: this.$store.state.uniquevisits
        }
    },
    mounted() {
        if (!this.$store.state.loggedIn) {
            this.$router.push('/');
        }
        console.log('username: ' + this.username + ' and ' + this.$store.state.username)
    },
    methods: {
        logout() {
            this.$store.commit('logout');
            this.$router.push('/');
        }
    }
};
