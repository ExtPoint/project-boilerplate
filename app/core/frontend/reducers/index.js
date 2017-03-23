import {combineReducers} from 'redux';
import {reducer as form} from 'redux-form';
import fileup from 'fileup-redux/lib/reducers/fileup';

import list from './list';

export default combineReducers({
    form,
    list,
    fileup,
});