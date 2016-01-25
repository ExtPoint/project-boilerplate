var FileUp = require('fileup-core');
var React = require('react');

/**
 * @class FileUp.view.FileItem
 * @extends React.Component
 */
FileUp.Neatness.defineClass('FileUp.view.FileItem', /** @lends FileUp.view.FileItem.prototype */{

    __extends: React.Component,

    __static: {

        asHumanFileSize: function (bytes, showZero) {
            if (!bytes) {
                return showZero ? '0' : '';
            }

            var thresh = 1000;
            if (Math.abs(bytes) < thresh) {
                return bytes + ' ' + 'B';
            }
            var units = [
                'kB',
                'MB',
                'GB',
                'TB',
                'PB',
                'EB',
                'ZB',
                'YB'
            ];
            var u = -1;
            do {
                bytes /= thresh;
                ++u;
            } while (Math.abs(bytes) >= thresh && u < units.length - 1);
            return bytes.toFixed(1) + ' ' + units[u];
        }

    },

    /**
     * @type {FileUp.models.QueueCollection}
     */
    queue: null,

    state: {

        /**
         * @type {FileUp.models.File}
         */
        file: null

    },

    constructor: function (options) {
        this.state.file = options.file;
        this.queue = options.queue;
        options.file.on([FileUp.models.File.EVENT_STATUS, FileUp.models.File.EVENT_PROGRESS], function (file) {
            this.setState({file: file});
        }.bind(this));
    },

    render: function () {
        return (
            <div className="list-group-item">
                <div className="media">
                    {this._renderPreview()}
                    <div className="media-body">
                        <button type="button" className="btn btn-sm btn-default pull-right" aria-label="Remove" onClick={this._onRemoveClick.bind(this)}
                                style={{display: this.state.file.isStatusEnd() ? 'block' : 'none'}}>
                            <span className="glyphicon glyphicon-remove" aria-hidden="true"/>
                        </button>
                        <h4 className="media-heading">{this.state.file.getName()}</h4>

                        {this.state.file.isResultError() ? 'Ошибка: ' + this.state.file.getResultHttpMessage() : ''}
                        {this.state.file.isStatusProcess() ? this.__static.asHumanFileSize(this.state.file.getBytesUploaded()) + ' из ' : ''}
                        {this.__static.asHumanFileSize(this.state.file.getBytesTotal())}

                        <div className="progress"
                             style={{display: this.state.file.isStatusProcess() ? 'block' : 'none'}}>
                            <div className="progress-bar" role="progressbar"
                                 aria-valuenow={this.state.file.progress.getPercent()} aria-valuemin="0"
                                 aria-valuemax="100" style={{width: this.state.file.progress.getPercent() + '%'}}>
                                {this.state.file.progress.getPercent()}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    },

    _renderPreview: function () {
        if (!this.state.file.isStatusEnd() || !this.state.file.isResultSuccess()) {
            return null;
        }

        var response = this.state.file.getResultHttpMessage();
        if (!response || !response.previewImageUrl || !response.downloadUrl) {
            return null;
        }

        return (
            <div className="media-left">
                <a href={response.downloadUrl}>
                    <img className="media-object" src={response.previewImageUrl} alt={this.state.file.getName()}/>
                </a>
            </div>
        );
    },

    _onRemoveClick: function(e) {
        this.queue.remove([this.state.file]);
    }

});