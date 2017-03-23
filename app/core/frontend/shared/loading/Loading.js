import React from 'react';

import {html} from 'components';

import './Loading.less';
const bem = html.bem('Loading');

export default class Loading extends React.Component {

    static propTypes = {
        isLoading: React.PropTypes.bool,
        className: React.PropTypes.string,
    };

    render() {
        return (
            <div
                className={bem(
                    bem.block(),
                    bem.block({visible: this.props.isLoading}),
                )}
            >
                <div className={bem.element('loader')}>
                    <div className={bem.element('rect1')}/>
                    <div className={bem.element('rect2')}/>
                    <div className={bem.element('rect3')}/>
                    <div className={bem.element('rect4')}/>
                    <div className={bem.element('rect5')}/>
                </div>
                <div className={bem(bem.element('content'), this.props.className)}>
                    {this.props.children}
                </div>
            </div>
        );
    }

}