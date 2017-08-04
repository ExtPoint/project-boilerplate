import BaseEnumMeta from 'extpoint-yii2/base/Enum';

export default class GameGenreMeta extends BaseEnumMeta {

    static ACTION = 'action';
    static SIMULATOR = 'simulator';
    static STRATEGY = 'strategy';
    static ADVENTURE = 'adventure';
    static ROLE_PLAYING = 'role_playing';

    static getLabels() {
        return {
            [this.ACTION]: '3D-экшен',
            [this.SIMULATOR]: 'Симулятор "a" \'b\'',
            [this.STRATEGY]: 'Стратегия',
            [this.ADVENTURE]: 'Приключения',
            [this.ROLE_PLAYING]: 'Ролевая',
        };
    }

    static getCssClasses() {
        return {
            [this.ACTION]: 'success',
            [this.SIMULATOR]: 'warning',
            [this.STRATEGY]: 'warning',
            [this.ROLE_PLAYING]: 'info',
        };
    }
}
