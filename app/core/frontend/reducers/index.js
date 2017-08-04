import {combineReducers} from 'redux';
import {reducer as form} from 'redux-form';
import fileup from 'fileup-redux/lib/reducers/fileup';
import formList from 'extpoint-yii2/reducers/formList';
import list from 'extpoint-yii2/reducers/list';
import notifications from 'extpoint-yii2/reducers/notifications';

export default combineReducers({
    form,
    formList,
    list,
    notifications,
    fileup,
});