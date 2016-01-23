
var React = require('react');
var ReactDOM = require('react-dom');

require('./FileInputView.jsx');
require('./FileItem.jsx');

jQuery.fn.fileInput = function (options) {
    this.each(function () {
        options.inputElement = this;
        ReactDOM.render(
            React.createElement(FileUp.view.FileInputView, options),
            $('<div />').insertAfter(this).get(0)
        );
    });
};