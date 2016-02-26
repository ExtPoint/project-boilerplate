
var React = require('react');
var ReactDOM = require('react-dom');

require('./FileInputView.jsx');
require('./FileItem.jsx');

jQuery.fn.fileInput = function (options) {
    this.each(function () {
        var container = $('<div />').insertAfter(this).get(0);
        options.name = $(this).attr('name');
        $(this).remove();

        var fileInput = ReactDOM.render(
            React.createElement(FileUp.view.FileInputView, options),
            container
        );
        $(container).find('.FileUp-FileInputView').data('fileInput', fileInput);
    });
};