import {createStore, applyMiddleware} from 'redux';
import _merge from 'lodash/merge';
import middleware from 'extpoint-yii2/middleware';

import reducer from './reducers';

export default createStore(
    reducer,
    _merge.apply(null, window.APP_REDUX_PRELOAD_STATES || [{}]),
    applyMiddleware(
        middleware()
    )
);
