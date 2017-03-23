import IntlMessageFormat from 'intl-messageformat';
import moment from 'moment';
import 'moment/locale/ru';

// Fix load locale data
window.IntlMessageFormat = IntlMessageFormat;
require('intl-messageformat/dist/locale-data/ru');
delete window.IntlMessageFormat;

/**
 * @example
 *  {__('{count} {count, plural, one{день} few{дня} many{дней}}', {count: 2})}
 */
export default class LocaleComponent {

    constructor() {
        this.language = null;
        this.translations = {};
    }

    moment() {
        return moment(...arguments).locale(this.language);
    }

    translate(message, params = {}) {
        // Translate
        message = this.translations[message] || message;

        // Format message (params, plural, etc..)
        const formatter = new IntlMessageFormat(message, this.language);
        message = formatter.format(params);

        return message;
    }
}