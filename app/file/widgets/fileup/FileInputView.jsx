var FileUp = require('fileup-core');
var React = require('react');

/**
 * @class FileUp.view.FileInputView
 * @extends React.Component
 */
FileUp.Neatness.defineClass('FileUp.view.FileInputView', /** @lends FileUp.view.FileInputView.prototype */{

    __extends: React.Component,

    state: {
        files: []
    },

    multiple: false,

    inputElement: null,

    uploader: null,

    constructor: function (options) {
        this.multiple = !!options.multiple;
        this.inputElement = options.inputElement;
        this.uploader = new FileUp(jQuery.extend({}, {
            dropArea: {},
            form: {
                multiple: this.multiple
            }
        }, options.uploader || {}));
        this.state.files = jQuery.map(options.files || [], function(file) {
            return new FileUp.models.File({
                //path: file.folder + file.fileName,
                path: file.title,
                type: file.fileMimeType,
                bytesUploaded: file.fileSize,
                bytesUploadEnd: file.fileSize,
                bytesTotal: file.fileSize,
                status: FileUp.models.File.STATUS_END,
                result: FileUp.models.File.RESULT_SUCCESS,
                resultHttpStatus: 200,
                resultHttpMessage: file
            });
        });
        this.uploader.queue.on(FileUp.models.QueueCollection.EVENT_ADD, function(files) {
            this.setState({
                files: this.multiple ? this.state.files.concat(files) : [files[0]]
            });
        }.bind(this));
        this.uploader.queue.on(FileUp.models.QueueCollection.EVENT_ITEM_END, function(file) {
            if (!file.isResultSuccess()) {
                return;
            }

            var data = file.getResultHttpMessage();
            if (!data.uid) {
                return;
            }

            if (this.multiple) {
                // @todo
            } else {
                this.inputElement.value = data.uid;
            }
        }.bind(this));
    },

    render: function () {
        return (
            <div className="FileUp-FileInputView">
                <div className="list-group" style={{display: this.state.files.length > 0 ? 'block' : 'none'}}>
                    {jQuery.map(this.state.files, function(file) {
                        return <FileUp.view.FileItem key={file.getUid()} file={file}/>
                        })}
                </div>
                <button type="button" className="btn btn-primary" onClick={this._onClick.bind(this)}>Выбрать файл</button>
            </div>
        );
    },

    _onClick: function (e) {
        this.uploader.browse();
    }

});