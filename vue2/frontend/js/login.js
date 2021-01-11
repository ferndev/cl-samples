const Login = {template: `
        <v-app id="clvuesample">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Login form</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-tooltip right>
                  <template v-slot:activator="{ on }">
                    <v-btn flat icon href="" large v-on="on">
                      <v-icon large>person</v-icon>
                    </v-btn>
                  </template>
                  <span>Please login</span>
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person"
                    name="username" label="Username"
                    type="text" v-model.trim="username"
                    :error-messages="usernameErrors"
                    required
                    v-on:keyup.enter="submit">
                  </v-text-field>

                  <v-text-field
                    id="password" prepend-icon="lock"
                    :append-icon="show4 ? 'visibility' : 'visibility_off'"
                    :type="show4 ? 'text' : 'password'" error
                    v-on:keyup.enter="submit"
                    @click:append="show4 = !show4"
                    :error-messages="passwordErrors"
                    required
                    name="password" label="Password" v-model="password">
                  </v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <span>{{ feedback }}</span>
                <div>
                No account yet? <a href="#" v-on:click="$router.push('register')" color="primary">Register</a>
                </div>
                <v-btn :disabled="incomplete" @click="submit" color="primary">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
        `,
    data () {
        return {
            username: '',
            password: '',
            show4: false,
            feedback: ''
        }
    },
    mounted() {
        //
    },
    computed: {
        usernameErrors () {
            const errors = []
            if (this.username.length < 4) {
                errors.push('Username must be at least 4 characters long');
            }
            return errors
        },
        passwordErrors () {
            const errors = []
            if (this.password.length < 5) {
                errors.push('Password must be at least 8 characters long');
            }
            return errors
        },
        incomplete() {
            return (this.passwordErrors.length > 0 || this.usernameErrors.length > 0);
        },
    },
    methods: {
        submit() {
            var self = this;
            if (this.incomplete) return;
            loadRemote('index.php/user/login', {
                "username": self.username,
                "password": self.password
            },(response => {
                console.log(response);
                if (response.status === 'success') {
                    self.$store.commit('setuser', self.username);
                    self.$store.commit('setdata', response);
                    self.$router.push('home');
                }
            }), function (error) {
                console.log(error);
                self.feedback = 'Login failed';
            });
        }
    }
};
