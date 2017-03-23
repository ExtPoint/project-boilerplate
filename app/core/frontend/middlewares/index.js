import _isPlainObject from 'lodash/isPlainObject';

import errorHandler from './error-handler';

const prepare = (action, dispatch, getState) => {
    // Multiple dispatch (redux-multi)
    if (Array.isArray(action)) {
        return action.filter(v => v).map(p => prepare(p, dispatch, getState));
    }

    // Function wraper (redux-thunk)
    if (typeof action === 'function') {
        return action(p => prepare(p, dispatch, getState), getState);
    }

    // Promise, detect errors on rejects
    // Detect action through instanceof Promise is not working in production mode, then used single detection by type
    if (typeof action === 'object' && typeof action.then === 'function' && typeof action.catch === 'function') {
        return action
            .then(payload => prepare(payload, dispatch, getState))
            .catch(e => {
                errorHandler(e, p => prepare(p, dispatch, getState));
            });
    }

    // Default case
    if (_isPlainObject(action)) {
        try {
            return dispatch(action);
        } catch (e) {
            errorHandler(e, p => prepare(p, dispatch, getState));
        }
    }

    if (console) {
        console.error('Action is not array, function, promise or plain object. Is skipper in dispatch(). Action: ', action); // eslint-disable-line no-console
    }
    return action;
};


export default () => ({getState}) => next => action => prepare(action, next, getState);