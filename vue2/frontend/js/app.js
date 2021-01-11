Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        username: '',
        visits: '0',
        sales: '0',
        uniquevisits: '0%',
        loggedIn: false
    },
    mutations: {
        setuser (state, uname) {
            state.username = uname;
            state.loggedIn = true;
        },
        setdata(state, payload) {
            state.visits = String(payload.visits);
            state.sales = String(payload.sales);
            state.uniquevisits = payload.uniquevisits;
        },
        logout(state) {
            state.loggedIn = false;
        }
    }
});

new Vue({ el: '#app',
    store: store,
    router,
    components: {
        'widget': widget
    },
    data () {
        return {
            btnaction: 'Start',
            apppath: '',
        }
    }
});
function loadRemote(url, postdata, success, failure) {
    axios.post(url, postdata)
        .then(response => {
            console.log(response);
            success(response.data);
        })
        .catch(function (error) {
            console.log(error.message);
            failure(error.message);
        });
}
