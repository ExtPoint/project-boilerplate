import _merge from 'lodash/merge';

import LocaleComponent from 'extpoint-yii2/components/LocaleComponent';
import ClientStorageComponent from 'extpoint-yii2/components/ClientStorageComponent';
import HtmlComponent from 'extpoint-yii2/components/HtmlComponent';
import HttpComponent from 'extpoint-yii2/components/HttpComponent';
import BackendWidgetComponent from 'extpoint-yii2/components/BackendWidgetComponent';
import TypesComponent from 'extpoint-yii2/components/TypesComponent';
import ViewComponent from 'extpoint-yii2/components/ViewComponent';
import store from '../store';

export const clientStorage = new ClientStorageComponent();
export const html = new HtmlComponent();
export const http = new HttpComponent();
export const locale = new LocaleComponent();
export const backendWidget = new BackendWidgetComponent(store);
export const types = new TypesComponent(store);
export const view = new ViewComponent();

// Apply configuration
const customConfig = window.APP_CONFIG || {};
Object.keys(exports).forEach(name => {
    _merge(
        exports[name],
        customConfig[name] || {}
    );
});