import Model from 'extpoint-yii2/base/Model';

export default class UserMeta extends Model {

    static className = 'app\\core\\models\\User';

    static meta() {
        return {
            'id': {
                'label': 'Id',
                'showInTable': 'true',
                'showInView': 'true',
                'dbType': 'pk',
                'notNull': 'true'
            },
            'email': {
                'label': 'Email',
                'showInForm': 'true',
                'showInTable': 'true',
                'showInView': 'true',
                'notNull': 'true'
            },
            'name': {
                'label': 'Имя',
                'showInForm': 'true',
                'showInTable': 'true',
                'showInView': 'true'
            },
            'role': {
                'label': 'Роль',
                'showInForm': 'true',
                'showInTable': 'true',
                'showInView': 'true',
                'notNull': 'true'
            },
            'photo': {
                'label': 'Фото'
            },
            'password': {
                'label': 'Пароль'
            },
            'salt': {
                'label': 'Salt'
            },
            'authKey': {
                'label': 'Auth Key'
            },
            'accessToken': {
                'label': 'Access Token'
            },
            'recoveryKey': {
                'label': 'Recovery Key'
            },
            'createTime': {
                'label': 'Дата регистрации',
                'showInTable': 'true',
                'showInView': 'true',
                'dbType': 'datetime',
                'notNull': 'true'
            },
            'updateTime': {
                'label': 'Update Time',
                'dbType': 'datetime',
                'notNull': 'true'
            },
            'firstName': {
                'label': 'Имя',
                'showInForm': 'true',
                'showInView': 'true'
            },
            'lastName': {
                'label': 'Фамилия',
                'showInForm': 'true',
                'showInView': 'true'
            },
            'birthday': {
                'label': 'Дата рождения',
                'showInForm': 'true',
                'showInView': 'true',
                'dbType': 'date'
            },
            'phone': {
                'label': 'Телефон',
                'showInForm': 'true',
                'showInView': 'true'
            }
        };
    }

}
