/**
 * Admin SPA entrypoint (Vue 3 + Vue Router 4 + Vite).
 */

import './bootstrap';

import { createApp, h } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import mitt from 'mitt';
import moment from 'moment';

import Swal from 'sweetalert2';
import VueProgressBar from '@aacassandra/vue3-progressbar';
import { Form } from 'vform';

/**
 * vform 2 dropped its Vue components, so re-create the two the app uses.
 */
const HasError = {
    name: 'HasError',
    props: {
        form: { type: Object, required: true },
        field: { type: String, required: true },
    },
    render() {
        if (!this.form.errors.has(this.field)) return null;
        return h(
            'span',
            { class: 'invalid-feedback d-block', role: 'alert' },
            [h('strong', this.form.errors.get(this.field))]
        );
    },
};

const AlertError = {
    name: 'AlertError',
    props: {
        form: { type: Object, required: true },
        message: { type: String, default: 'There were some problems with your input.' },
    },
    render() {
        if (!this.form.errors.any()) return null;
        return h('div', { class: 'alert alert-danger', role: 'alert' }, this.message);
    },
};

import Dashboard from './components/Dashboard.vue';
import Developer from './components/Developer.vue';
import Profile from './components/Profile.vue';
import Users from './components/Users.vue';
import Home from './components/Home.vue';
import Slider from './components/Slider.vue';
import About from './components/About.vue';
import Philosophy from './components/Philosophy.vue';
import Team from './components/Team.vue';
import TeamLeader from './components/TeamLeader.vue';
import Gallery from './components/Gallery.vue';

import PassportClients from './components/passport/Clients.vue';
import PassportAuthorizedClients from './components/passport/AuthorizedClients.vue';
import PassportPersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';
import ExampleComponent from './components/ExampleComponent.vue';

/**
 * Global toast helper (kept on window for parity with the old code).
 */
window.Swal = Swal;
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});

/**
 * Vue 3 removed instance events, so back the old `Fire.$on/$emit` bus
 * with mitt and expose the same method names.
 */
const emitter = mitt();
window.Fire = {
    $on: emitter.on,
    $off: emitter.off,
    $emit: emitter.emit,
};

window.Form = Form;

const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/developer', component: Developer },
    { path: '/profile', component: Profile },
    { path: '/users', component: Users, meta: { role: 'admin' } },
    { path: '/school-home', component: Home },
    { path: '/sliders', component: Slider },
    { path: '/admin-about', component: About },
    { path: '/admin-philosophy', component: Philosophy },
    { path: '/admin-team', component: Team },
    { path: '/admin-teamleader', component: TeamLeader },
    { path: '/admin-gallery', component: Gallery },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkExactActiveClass: 'router-link-exact-active',
});

/**
 * Client-side gate. The real enforcement is the `admin` middleware on
 * the API; this just keeps non-admins from opening the Users screen.
 */
const currentRole = window.Laravel?.user?.type ?? null;
router.beforeEach((to) => {
    if (to.meta.role === 'admin' && currentRole !== 'admin') {
        return { path: '/dashboard' };
    }
    return true;
});

/**
 * No root render/template on purpose: Vue compiles the existing markup
 * inside #app as its template (like Vue 2's `new Vue({ el: '#app' })`).
 * That keeps server-rendered pages such as /login intact while still
 * driving <router-view> on the admin shell.
 */
const app = createApp({});

app.use(router);
app.use(VueProgressBar, {
    color: '#228B22',
    failedColor: '#FF0000',
    thickness: '5px',
    transition: { speed: '0.12s', opacity: '0.6s', termination: 300 },
    autoRevert: true,
    location: 'top',
    inverse: false,
});

app.component(HasError.name, HasError);
app.component(AlertError.name, AlertError);
app.component('passport-clients', PassportClients);
app.component('passport-authorized-clients', PassportAuthorizedClients);
app.component('passport-personal-access-tokens', PassportPersonalAccessTokens);
app.component('example-component', ExampleComponent);

/**
 * The Vue 2 `upText` / `myDate` filters are now global helpers; call them
 * as methods in templates instead of `{{ value | upText }}`.
 */
app.config.globalProperties.upText = (text) =>
    text ? text.charAt(0).toUpperCase() + text.slice(1) : text;
app.config.globalProperties.myDate = (created) =>
    created ? moment(created).format('MMMM Do YYYY') : '';

if (document.getElementById('app')) {
    app.mount('#app');
}
