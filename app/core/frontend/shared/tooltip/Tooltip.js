import React from 'react';
import OverlayTrigger from 'react-bootstrap/lib/OverlayTrigger';
import PropTypes from 'prop-types';
import uniqueId from 'lodash/uniqueId';

import {html} from 'components';

import './Tooltip.less';
const bem = html.bem('Tooltip');

export default class TooltipWrapper extends React.Component {

    static propTypes = {
        label: PropTypes.string,
        text: PropTypes.oneOfType([
            PropTypes.string,
            PropTypes.element
        ]),
        placement: PropTypes.string,
    };

    static defaultProps = {
        placement: 'top',
    };

    constructor() {
        super(...arguments);

        this._id = uniqueId();
    }

    render() {
        return (
            <span className={bem.block()}>
                <OverlayTrigger
                    placement={this.props.placement}
                    overlay={this.renderTooltip()}
                >
                    <span>
                        {this.props.label || this.props.children}
                    </span>
                </OverlayTrigger>
            </span>
        );
    }

    renderTooltip() {
        return (
            <Tooltip>
                {this.props.text}
            </Tooltip>
        );
    }

}

class Tooltip extends React.Component {

    static propTypes = {
        placement: PropTypes.oneOf(['top', 'right', 'bottom', 'left']),
        positionTop: PropTypes.oneOfType([
            PropTypes.number, PropTypes.string,
        ]),
        positionLeft: PropTypes.oneOfType([
            PropTypes.number, PropTypes.string,
        ]),
        arrowOffsetTop: PropTypes.oneOfType([
            PropTypes.number, PropTypes.string,
        ]),
        arrowOffsetLeft: PropTypes.oneOfType([
            PropTypes.number, PropTypes.string,
        ]),
    };

    static defaultProps = {
        placement: 'top',
    };

    render() {
        return (
            <div
                role='tooltip'
                className={bem(
                    bem.element('tooltip'),
                    bem.element('tooltip', {placement: this.props.placement}),
                )}
                style={{
                    top: this.props.positionTop,
                    left: this.props.positionLeft,
                    ...this.props.style,
                }}
            >
                <div
                    className={bem.element('arrow')}
                    style={{
                        top: this.props.arrowOffsetTop,
                        left: this.props.arrowOffsetLeft,
                    }}
                />

                <div className={bem.element('inner')}>
                    {this.props.children}
                </div>
            </div>
        );
    }
}