Vue.use(VueRouter)

const router = new VueRouter({
    name: 'router',
    //mode: 'history',
    // base: __dirname,
    routes: [
        { path: '/', component: Login },
        { path: '/home', component: Home },
        { path: '/register', component: Register },
    ]
});
