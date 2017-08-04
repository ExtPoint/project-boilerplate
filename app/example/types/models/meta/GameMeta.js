import Model from 'extpoint-yii2/base/Model';
import GameGenreMeta from 'app/example/types/enums/meta/GameGenreMeta';

export default class GameMeta extends Model {

    static className = 'app\\example\\types\\models\\Game';

    static meta() {
        return {
            'id': {
                'label': 'ID',
                'appType': 'primaryKey',
                'publishToFrontend': true,
                'showInTable': true,
                'showInView': true
            },
            'createTime': {
                'label': 'Дата создания',
                'appType': 'autoTime',
                'publishToFrontend': true,
                'showInTable': true,
                'showInView': true
            },
            'updateTime': {
                'label': 'Дата обновления',
                'appType': 'autoTime',
                'publishToFrontend': true,
                'showInView': true,
                'touchOnUpdate': true
            },
            'title': {
                'label': 'Название',
                'publishToFrontend': true,
                'showInForm': true,
                'showInTable': true,
                'showInView': true,
                'stringType': 'words'
            },
            'shortDescription': {
                'label': 'Краткое описание',
                'appType': 'text',
                'publishToFrontend': true,
                'showInForm': true,
                'showInTable': true,
                'showInView': true
            },
            'fullDescription': {
                'label': 'Полное описание',
                'appType': 'html',
                'publishToFrontend': true,
                'showInForm': true,
                'showInView': true
            },
            'rating': {
                'label': 'Рейтинг',
                'appType': 'integer',
                'required': true,
                'defaultValue': '0',
                'publishToFrontend': true,
                'showInForm': true,
                'showInView': true
            },
            'isDisabled': {
                'label': 'Отключен?',
                'appType': 'boolean',
                'publishToFrontend': true,
                'showInForm': true,
                'showInView': true
            },
            'price': {
                'label': 'Цена (руб)',
                'appType': 'money',
                'publishToFrontend': true,
                'showInForm': true,
                'showInTable': true,
                'showInView': true,
                'currency': 'RUB'
            },
            'tillDate': {
                'label': 'Активен \'до\'',
                'appType': 'date',
                'publishToFrontend': true,
                'showInForm': true,
                'showInView': true,
                'format': 'php:Y.d.m'
            },
            'logoId': {
                'label': 'Логотип',
                'appType': 'file',
                'publishToFrontend': true,
                'showInForm': true,
                'showInTable': true,
                'showInView': true
            },
            'photoIds': {
                'label': 'Фотографии',
                'appType': 'files',
                'publishToFrontend': true,
                'showInForm': true,
                'showInView': true,
                'relationName': 'photos'
            },
            'winExeId': {
                'label': 'Скачать (win)',
                'appType': 'file',
                'showInForm': true,
                'showInView': true
            },
            'macDmgId': {
                'label': 'Скачать (mac)',
                'appType': 'file',
                'showInForm': true,
                'showInView': true
            },
            'documentIds': {
                'label': 'Инструкции',
                'appType': 'files',
                'showInForm': true,
                'showInView': true,
                'relationName': 'documents'
            },
            'creatorId': {
                'label': 'Игру добавил',
                'appType': 'relation',
                'showInForm': true,
                'showInView': true,
                'relationName': 'creator',
                'listRelationName': 'players'
            },
            'playersIds': {
                'label': 'Игроки',
                'appType': 'relation',
                'showInForm': true,
                'showInView': true,
                'relationName': 'players',
                'listRelationName': 'players'
            },
            'saleFrom': {
                'label': 'Период скидки',
                'appType': 'range',
                'showInForm': true,
                'showInView': true,
                'subAppType': 'date',
                'refAttribute': 'saleTo'
            },
            'genre': {
                'label': 'Жанр',
                'appType': 'enum',
                'publishToFrontend': true,
                'showInForm': true,
                'showInTable': true,
                'showInView': true,
                'enumClassName': GameGenreMeta
            }
        };
    }

}
