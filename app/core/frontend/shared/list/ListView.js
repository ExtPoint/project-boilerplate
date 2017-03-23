import React, {PropTypes} from 'react';
import _isFunction from 'lodash/isFunction';
import _get from 'lodash/get';
import _merge from 'lodash/merge';
import {connect} from 'react-redux';

import Pagination from './Pagination';
import PaginationMore from './PaginationMore';
import {init, fetch} from '../../actions/list';
import {getList} from '../../reducers/list';
import Loading from 'shared/loading/Loading';

class ListView extends React.Component {

    static propTypes = {
        id: PropTypes.string.isRequired,
        method: PropTypes.oneOfType([
            PropTypes.string,
            PropTypes.func,
        ]).isRequired,
        query: PropTypes.object,
        primaryKey: PropTypes.string,
        pageSize: PropTypes.number,
        loadMore: PropTypes.bool,
        list: PropTypes.shape({
            isFetched: PropTypes.bool,
            isLoading: PropTypes.bool,
            page: PropTypes.number,
            size: PropTypes.number,
            sort: PropTypes.array,
            params: PropTypes.object,
            metadata: PropTypes.object,
            entries: PropTypes.array,
            totalCount: PropTypes.number,
            hasPagination: PropTypes.bool,
        }),
        itemsOrder: PropTypes.string,
        itemComponent: PropTypes.func.isRequired,
        itemProps: PropTypes.object,
        wrapperComponent: PropTypes.func,
        wrapperProps: PropTypes.object,
        emptyComponent: PropTypes.func,
        paginationComponent: PropTypes.func,
        paginationProps: PropTypes.object,
        disableCache: PropTypes.bool,
    };

    static defaultProps = {
        primaryKey: 'id',
        pageSize: 20,
        loadMore: false,
        disableCache: false,
        itemsOrder: 'desc',
    };

    constructor() {
        super(...arguments);

        this.selectNextPage = this.selectNextPage.bind(this);
        this.selectPage = this.selectPage.bind(this);
    }

    componentDidMount() {
        this.props.dispatch(init(
            this.props.id,
            this.getMethod(),
            this.getCurrentPage(),
            this.props.pageSize,
            this.props.list.sort,
            this.props.loadMore,
            this.props.primaryKey,
            _merge(this.props.list.params, this.props.query || {})
        ));

        if (!this.props.list.isFetched || this.props.disableCache) {
            this.selectPage(this.getCurrentPage());
        }
    }

    getCurrentPage() {
        // TODO get page from route
        return this.props.list.page || 1;
    }

    getMethod() {
        return _isFunction(this.props.method) ? this.props.method() : this.props.method;
    }

    render() {
        if (!this.props.list.isFetched) {
            return null;
        }

        let entries = this.props.list.entries;
        if (this.props.itemsOrder.toLowerCase() !== 'desc') {
            entries = [].concat(entries).reverse();
        }

        return (
            <Loading
                isLoading={this.props.list.isLoading}
            >
                {this.renderWrapper(
                    entries.map((entry, index) => this.renderItem(entry, index)),
                    entries.length > 0 && this.props.list.hasPagination
                        ? this.renderPagination(this.getCurrentPage(), Math.ceil(this.props.list.totalCount / this.props.pageSize))
                        : null,
                    entries.length === 0 ? this.renderEmpty() : null
                )}
            </Loading>
        );
    }

    renderWrapper(items, pagination, empty) {
        const WrapperComponent = this.props.wrapperComponent;
        if (WrapperComponent) {
            return (
                <WrapperComponent
                    {...this.props.wrapperProps}
                    itemsOrder={this.props.itemsOrder}
                    items={items}
                    pagination={pagination}
                    empty={empty}
                />
            );
        }

        if (this.props.itemsOrder.toLowerCase() === 'desc') {
            return (
                <span>
                    {items}
                    {pagination}
                    {empty}
                </span>
            );
        } else {
            return (
                <span>
                    {pagination}
                    {items}
                    {empty}
                </span>
            );
        }

    }

    renderPagination(currentPage, totalPages) {
        const PaginationComponent = this.props.paginationComponent || (this.props.loadMore ? PaginationMore : Pagination);
        return (
            <PaginationComponent
                {...this.props.paginationProps}
                currentPage={currentPage}
                totalPages={totalPages}
                onSelect={this.selectPage}
            />
        );
    }

    renderEmpty() {
        const EmptyComponent = this.props.emptyComponent;
        if (EmptyComponent) {
            return <EmptyComponent />;
        }
        return null;
    }

    renderItem(item, index) {
        const ItemComponent = this.props.itemComponent;
        return (
            <ItemComponent
                {...this.props.itemProps}
                key={_get(item, this.props.primaryKey) || index}
                item={item}
                index={index}
            />
        );
    }

    selectNextPage() {
        this._fetch(this.getCurrentPage() + 1, this.props.list.params);
    }

    selectPage(page) {
        this._fetch(page, this.props.list.params);
    }

    setQuery(params) {
        this._fetch(1, params);
    }

    _fetch(page, query) {
        // TODO push page to route

        this.props.dispatch(fetch(
            this.props.id,
            this.getMethod(),
            page,
            this.props.pageSize,
            this.props.list.sort,
            this.props.loadMore,
            this.props.primaryKey,
            _merge(this.props.list.params, this.props.query || {}, query)
        ));
    }

}

export default connect(
    (state, props) => ({
        id: props.id,
        method: props.method,
        list: getList(state, props.id),
    })
)(ListView);