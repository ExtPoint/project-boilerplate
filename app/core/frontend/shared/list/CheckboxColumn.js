import React, {PropTypes} from 'react';

import {html} from 'components';

import './GridView.less';
const bem = html.bem('GridView');

export default class CheckboxColumn extends React.Component {

    static propTypes = {
        item: PropTypes.object,
        column: PropTypes.object,
        rowIndex: PropTypes.number,
        cellIndex: PropTypes.number,
    };

    render() {
        const id = `checkbox_${this.props.rowIndex}`;

        return (
            <div className={bem(bem.element('checkbox-container'), 'g__checkbox-container')}>
                <input
                    className='g__checkbox'
                    type='checkbox'
                    id={id}
                />
                <label
                    className={bem(bem.element('checkbox-icon'), 'g__checkbox-icon')}
                    htmlFor={id}
                />
            </div>
        );
    }

}
