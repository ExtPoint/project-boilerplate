import 'extpoint-yii2';

import {locale, backendWidget, types, view} from 'components';
import * as fields from 'extpoint-yii2/form';
import * as fieldViews from 'extpoint-yii2/form/views';
import * as listViews from 'extpoint-yii2/list/views';
import './store';

// Publish to global
window.__ = locale.translate.bind(locale);
window.__appWidget = backendWidget;
window.__appTypes = types;

// Register form field views
types.addFieldComponents(fields);
view.addFormViews(fieldViews);
view.addListViews(listViews);
