import _merge from 'lodash/merge';

import LocaleComponent from './LocaleComponent';
//import ClientStorageComponent from './ClientStorageComponent';
import HtmlComponent from './HtmlComponent';
import HttpComponent from './HttpComponent';

//export const clientStorage = new ClientStorageComponent();
export const html = new HtmlComponent();
export const http = new HttpComponent();
export const locale = new LocaleComponent();

// Apply configuration
const customConfig = window.APP_CONFIG || {};
Object.keys(exports).forEach(name => {
    _merge(
        exports[name],
        customConfig[name] || {}
    );
});

window.__ = locale.translate.bind(locale);