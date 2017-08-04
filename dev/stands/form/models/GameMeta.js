import BaseModelMeta from 'extpoint-yii2/base/Model';
import GameGenreMeta from './GameGenreMeta';

export default class GameMeta extends BaseModelMeta {

    static meta() {
        return {
            'id': {
                'label': 'ID',
                'appType': 'primaryKey',
            },
            'title': {
                'label': 'Название',
                'stringType': 'words'
            },
            'shortDescription': {
                'label': 'Краткое описание',
                'appType': 'text',
            },
            'fullDescription': {
                'label': 'Полное описание',
                'appType': 'html',
            },
            'rating': {
                'label': 'Рейтинг',
                'appType': 'integer',
                'required': true,
                'defaultValue': '0',
            },
            'isDisabled': {
                'label': 'Отключен?',
                'appType': 'boolean',
            },
            'updateTime': {
                'label': 'Дата обновления',
                'appType': 'autoTime',
            },
            'tillDate': {
                'label': 'Активен "до"',
                'appType': 'date',
                'format': 'php:Y.d.m'
            },
            'price': {
                'label': 'Цена',
                'appType': 'money',
                'currency': 'RUB'
            },
            'logoId': {
                'label': 'Логотип',
                'appType': 'file',
            },
            'creatorId': {
                'label': 'Игру добавил',
                'appType': 'relation',
                'componentProps': {
                    'items': {
                        1: 'Player 1',
                        2: 'John18',
                        6: 'Driver',
                        36: 'X-man',
                        46: 'Dron',
                        55: 'Bazzzan'
                    }
                }
            },
            'genre': {
                'label': 'Жанр',
                'appType': 'enum',
                'enumClassName': GameGenreMeta,
                'componentProps': {
                    'multiple': true,
                    'autoComplete': true,
                    'items': {
                        1: 'Player 1',
                        2: 'John18',
                        6: 'Driver',
                        36: 'X-man',
                        46: 'Dron',
                        55: 'Bazzzan'
                    }
                }
            },
            'email': {
                'label': 'Email',
                'appType': 'email',
            },
            'oldPassword': {
                'label': 'Old password',
                'appType': 'password',
            },
            'newPassword': {
                'label': 'New password',
                'appType': 'password',
                'componentProps': {
                    securityLevel: true,
                }
            },
            'phone': {
                'label': 'Phone',
                'appType': 'phone',
            },
            'saleFrom': {
                'label': 'Период скидки',
                'appType': 'range',
                'subAppType': 'date',
                'refAttribute': 'saleTo'
            },
        };
    }

}
