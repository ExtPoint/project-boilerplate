import Model from 'extpoint-yii2/base/Model';

export default class PlayerMeta extends Model {

    static className = 'app\\example\\types\\models\\Player';

    static meta() {
        return {
            "id": {
                "label": "ID",
                "appType": "primaryKey"
            },
            "name": {
                "label": "Имя",
                "required": true,
                "showInForm": true,
                "showInTable": true,
                "showInView": true,
                "stringType": "words"
            },
            "role": {
                "label": "Роль",
                "appType": "enum",
                "showInForm": true,
                "showInView": true,
                "enumClassName": UserRoleMeta
            },
            "email": {
                "label": "Email",
                "appType": "email",
                "required": true
            }
        };
    }

}
