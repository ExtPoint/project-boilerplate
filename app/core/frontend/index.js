import React from 'react';
import {Provider} from 'react-redux';
import ReactDOM from 'react-dom';
import {createStore, applyMiddleware} from 'redux';
import _merge from 'lodash/merge';
import _trimStart from 'lodash/trimStart';

import middleware from './middlewares';
import reducer from './reducers';

const store = createStore(
    reducer,
    _merge.apply(null, window.APP_REDUX_PRELOAD_STATES || [{}]),
    applyMiddleware.apply(null, [
        middleware(),
        // Uncomment to enable redux logger
        // process.env.NODE_ENV !== 'production' && require('redux-logger')(),
    ].filter(Boolean))
);

// Application
window.__appWidget = {

    _widgets: {},

    register(name, func) {
        this._widgets[_trimStart(name, '\\')] = func;
        return func;
    },

    render(elementId, name, props) {
        const WidgetComponent = this._widgets[_trimStart(name, '\\')];
        ReactDOM.render(
            <Provider store={store}>
                <WidgetComponent {...props} />
            </Provider>,
            document.getElementById(elementId)
        );
    }

};
