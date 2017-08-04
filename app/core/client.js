import jQuery from 'jquery';
import './frontend';

window.$ = window.jQuery = jQuery;
require('bootstrap');

// Bootstrap functional
jQuery(() => {
    jQuery('.dropdown-toggle').dropdown();
    jQuery('[data-toggle=tooltip]').tooltip();
});
