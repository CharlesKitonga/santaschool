import _ from 'lodash';
window._ = _;

/**
 * jQuery + Bootstrap 4 + AdminLTE 3 provide the admin theme's
 * JavaScript widgets (sidebar, treeview, modals, tabs).
 */
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import Popper from 'popper.js';
window.Popper = Popper;

import 'bootstrap';
import 'admin-lte';

/**
 * axios for talking to the Laravel API. Sends the CSRF token from the
 * <meta name="csrf-token"> tag and the XSRF cookie automatically.
 */
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
