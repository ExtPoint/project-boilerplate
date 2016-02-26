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

    name: '',

    multiple: false,

    uploader: null,

    buttonClass: 'btn btn-default',
    buttonLabel: 'Выбрать файл',

    constructor: function (options) {
        this.multiple = !!options.multiple;
        this.name = options.name;
        this.buttonClass = options.buttonClass || this.buttonClass;
        this.buttonLabel = options.buttonLabel || this.buttonLabel;
        this.uploader = new FileUp(jQuery.extend({}, {
            dropArea: {},
            form: {
                multiple: this.multiple
            }
        }, options.uploader || {}));

        this.state.files = jQuery.map(options.files || [], function (file) {
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
        this.uploader.queue.add(this.state.files);

        if (!this.multiple) {
            this.uploader.queue.on(FileUp.models.QueueCollection.EVENT_ADD, function (addedFiles) {
                var files = this.uploader.queue.getFiles();
                var toRemove = [];
                for (var i = 0, l = files.length; i < l; i++) {
                    if (addedFiles.indexOf(files[i]) === -1) {
                        toRemove.push(files[i]);
                    }
                }
                this.uploader.queue.remove(toRemove);
            }.bind(this));
        }
        this.uploader.queue.on([FileUp.models.QueueCollection.EVENT_ADD, FileUp.models.QueueCollection.EVENT_REMOVE, FileUp.models.QueueCollection.EVENT_ITEM_END], function () {
            var files = this.uploader.queue.getFiles();
            this.setState({
                files: !this.multiple && files.length > 0 ? [files[files.length - 1]] : files
            });
        }.bind(this));
    },

    render: function () {
        var queue = this.uploader.queue;
        return (
            <div className="FileUp-FileInputView">
                {this._renderInputs()}
                <div className="list-group" style={{display: this.state.files.length > 0 ? 'block' : 'none'}}>
                    {jQuery.map(this.state.files, function(file) {
                        return <FileUp.view.FileItem key={file.getUid()} file={file} queue={queue}/>
                        })}
                </div>
                <button type="button" className={this.buttonClass} onClick={this._onClick.bind(this)}>
                    {this.buttonLabel}
                </button>
            </div>
        );
    },

    _renderInputs: function () {
        var uids = [];
        jQuery.each(this.state.files, function (i, file) {
            /** @typedef {FileUp.models.File} file */
            if (!file.isResultSuccess()) {
                return;
            }

            var data = file.getResultHttpMessage();
            if (typeof data !== 'object' || !data.uid) {
                return;
            }

            uids.push(data.uid);
        });

        if (uids.length === 0 && !this.multiple) {
            uids.push('');
        }
        uids = this.multiple ? uids : [uids[0]];
        if (this.name.indexOf('[]') !== -1) {
            return jQuery.map(uids, function (uid) {
                return <input type='hidden' name={this.name} key={uid} value={uid}/>;
            }.bind(this));
        } else {
            return <input type='hidden' name={this.name} value={uids.join(',')}/>;
        }
    },

    _onClick: function (e) {
        this.uploader.browse();
    }

});