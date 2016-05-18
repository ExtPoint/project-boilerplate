(function () {
    var helpers = {

        getGeneratorInputs: function () {
            var inputs = {};
            $('form').find('input[type=text], select').each(function () {
                var $el = $(this);
                var name = $el.attr('name');
                if (name) {
                    name = name.replace(/^[^\[]+\[([^\[\]]+)\]/g, '$1');
                    inputs[name] = $el;
                }
            });
            return inputs;
        },

        getClassNamespace: function (value) {
            if (value.indexOf('\\') == -1) {
                return '';
            }
            return value.replace(/^\\|\\[^\\]+$/g, '');
        },

        getClassName: function (value) {
            return value.replace(/.*\\([^\\]+)?$/g, '$1');
        },

        tableToCamel: function (value) {
            var modelClass = '';
            $.each(value.split('_'), function () {
                if (this.length > 0) {
                    modelClass += this.substring(0, 1).toUpperCase() + this.substring(1).replace(/s$/, '');
                }
            });
            return modelClass;
        }

    };
    var inputs = helpers.getGeneratorInputs();
    var isManualChanged = {};

    var onChange = function (e) {
        // Set manual changed
        $.each(inputs, function (i, el) {
            if (e.target === el.get(0)) {
                isManualChanged[i] = true;
            }
        });

        if (window.generatorAutoFill) {
            window.generatorAutoFill(helpers, inputs, isManualChanged);
        }
    };

    $.each(inputs, function (i, $el) {
        $el.on($el.get(0).tagName.toLowerCase() === 'input' ? 'keyup' : 'change', onChange);
    });
}());