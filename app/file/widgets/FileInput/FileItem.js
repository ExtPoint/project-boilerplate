import React, {PropTypes} from 'react';
import File from 'fileup-core/lib/models/File';
import FilePropType from 'fileup-redux/lib/types/FilePropType';
import OverlayTrigger from 'react-bootstrap/lib/OverlayTrigger';
import Tooltip from 'react-bootstrap/lib/Tooltip';

import {html} from 'components';

import './FileItem.less';
const bem = html.bem('FileItem');

export default class FileItem extends React.Component {

    static propTypes = {
        file: FilePropType,
        name: PropTypes.string,
        onRemove: PropTypes.func.isRequired
    };

    static asHumanFileSize(bytes, showZero) {
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

    render() {
        return (
            <div className={bem.block()}>
                {this._renderImage()}
                {this.props.file.status === File.STATUS_END && (
                    <a
                        href='javascript:void(0)'
                        className={bem.element('remove')}
                        onClick={this.props.onRemove}
                    >
                        <span className='glyphicon glyphicon-remove'/>
                    </a>
                )}
                <div className={bem.element('status')}>
                    {this._renderStatus()}
                </div>
                {this.props.name && this.props.file.resultHttpMessage && (
                    <input
                        name={this.props.name}
                        type='hidden'
                        defaultValue={this.props.file.resultHttpMessage.id}
                    />
                )}
            </div>
        );
    }

    _renderStatus() {
        if (this.props.file.result === File.RESULT_ERROR) {
            return (
                <OverlayTrigger
                    placement='bottom'
                    overlay={(
                        <Tooltip id={`tooltip-error-${this.props.file.id}`}>
                            <p>
                                {this.props.file.resultHttpMessage.error}
                            </p>
                        </Tooltip>
                    )}
                >
                    <div className={bem.element('status-error')}>
                        Ошибка
                    </div>
                </OverlayTrigger>
            );
        }

        if (this.props.file.status === File.STATUS_PROCESS) {
            return (
                <OverlayTrigger
                    placement='bottom'
                    overlay={(
                        <Tooltip id={`tooltip-progress-${this.props.file.id}`}>
                            {this.props.file.status === File.STATUS_PROCESS && (
                                <span>
                                    {FileItem.asHumanFileSize(this.props.file.bytesUploaded)}
                                    &nbsp;
                                    из
                                </span>
                            )}
                            {!this.props.file.result === File.RESULT_ERROR && (
                                <span>
                                    &nbsp;
                                    {FileItem.asHumanFileSize(this.props.file.bytesTotal)}
                                </span>
                            )}
                        </Tooltip>
                    )}
                >
                    <div className={bem(bem.element('status-progress'), 'progress')}>
                        <div
                            className={bem(bem.element('progress-bar'), 'progress-bar')}
                            style={{
                                width: this.props.file.progress.percent + '%'
                            }}
                        >
                            {this.props.file.progress.percent}
                            %
                        </div>
                    </div>
                </OverlayTrigger>
            );
        }

        return (
            <div className={bem.element('status-name')}>
                {this.props.file.name}
            </div>
        );
    }

    _renderImage() {
        if (!this.props.file.status === File.STATUS_END || !this.props.file.result === File.RESULT_SUCCESS) {
            return null;
        }

        var response = this.props.file.resultHttpMessage;
        if (!response || !response.previewImageUrl || !response.downloadUrl) {
            return null;
        }

        return (
            <img
                className={bem.element('image')}
                src={response.previewImageUrl}
                alt={this.props.file.name}
                style={{
                    width: 100,
                    height: 100,
                }}
            />
        );
    }
}
