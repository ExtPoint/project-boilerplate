import _merge from 'lodash/merge';

import LocaleComponent from 'extpoint-yii2/components/LocaleComponent';
import ClientStorageComponent from 'extpoint-yii2/components/ClientStorageComponent';
import HtmlComponent from 'extpoint-yii2/components/HtmlComponent';
import HttpComponent from 'extpoint-yii2/components/HttpComponent';
import BackendWidgetComponent from 'extpoint-yii2/components/BackendWidgetComponent';
import store from '../store';

export const clientStorage = new ClientStorageComponent();
export const html = new HtmlComponent();
export const http = new HttpComponent();
export const locale = new LocaleComponent();
export const backendWidget = new BackendWidgetComponent(store);

// Apply configuration
const customConfig = window.APP_CONFIG || {};
Object.keys(exports).forEach(name => {
    _merge(
        exports[name],
        customConfig[name] || {}
    );
});

// Publish to global
window.__ = locale.translate.bind(locale);
window.__appWidget = backendWidget;