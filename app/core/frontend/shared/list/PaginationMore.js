import React, {PropTypes} from 'react';

export default class PaginationMore extends React.Component {

    static propTypes = {
        label: PropTypes.string,
    };

    static defaultProps = {
        label: __('Показать еще'),
    };

    render() {
        if (this.props.currentPage >= this.props.totalPages) {
            return null;
        }

        return (
            <div className='text-center'>
                <button
                    className='g__btn-inverse btn btn-primary'
                    onClick={() => this.props.onSelect(this.props.currentPage + 1)}
                >
                    {this.props.label}
                </button>
            </div>
        );
    }

}