// Optimize chunks, fetch popular libs
import 'redux';
import 'react-redux';
import 'moment';
import axios from 'axios';
import jQuery from 'jquery';

import './frontend';

// Append csrf token to requests
axios.interceptors.request.use((config) => {
    const metaToken = document.querySelector('meta[name=csrf-token]');
    if (metaToken) {
        config.headers['X-CSRF-Token'] = metaToken.getAttribute('content');
    }

    return config;
});

window.$ = window.jQuery = jQuery;
require('bootstrap');
