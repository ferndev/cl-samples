Vue.use(VueRouter)

const router = new VueRouter({
    name: 'router',
    //mode: 'history',
    // base: __dirname,
    routes: [
        { path: '/', component: Login },
        { path: '/home', component: Home },
        { path: '/index', component: Index },
        { path: '/register', component: Register },
    ]
});
