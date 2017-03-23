import React, {PropTypes} from 'react';
import _get from 'lodash/get';

import {html} from 'components';
import ListView from './ListView';

import './GridView.less';
const bem = html.bem('GridView');

export default class GridView extends React.Component {

    static propTypes = {
        id: PropTypes.string.isRequired,
        method: PropTypes.oneOfType([
            PropTypes.string,
            PropTypes.func,
        ]).isRequired,
        primaryKey: PropTypes.string,
        pageSize: PropTypes.number,
        loadMore: PropTypes.bool,
        columns: PropTypes.arrayOf(PropTypes.shape({
            title: PropTypes.string,
            field: PropTypes.string,
            sortable: PropTypes.bool,
            headerComponent: PropTypes.func,
            valueComponent: PropTypes.func,
        })),
        wrapperComponent: PropTypes.func,
        tableComponent: PropTypes.func,
        emptyComponent: PropTypes.func,
        paginationComponent: PropTypes.func,
        paginationProps: PropTypes.object,
        disableCache: PropTypes.bool,
    };

    static defaultProps = {
        columns: [],
    };

    render() {
        return (
            <ListView
                id={this.props.id}
                method={this.props.method}
                pageSize={this.props.pageSize}
                loadMore={this.props.loadMore}
                disableCache={this.props.disableCache}
                paginationComponent={this.props.paginationComponent}
                paginationProps={this.props.paginationProps}
                wrapperComponent={({items, pagination, empty}) => (
                    this.renderWrapper(
                        this.renderTable(
                            items,
                            empty
                        ),
                        pagination,
                    )
                )}
                emptyComponent={() => this.renderEmpty()}
                itemComponent={({item, index}) => this.renderRow(item, index)}
            />
        );
    }

    renderWrapper(table, pagination) {
        const WrapperComponent = this.props.wrapperComponent;
        if (WrapperComponent) {
            return (
                <WrapperComponent
                    className={bem.block()}
                    table={table}
                    pagination={pagination}
                />
            );
        }

        return (
            <div className={bem.block()}>
                {table}
                {pagination}
            </div>
        );
    }

    renderTable(body, empty) {
        const TableComponent = this.props.tableComponent;
        if (TableComponent) {
            return (
                <TableComponent
                    body={body}
                    empty={empty}
                    columns={this.props.columns}
                />
            );
        }

        return (
            <div className='table-responsive'>
                <table className={bem.element('table')}>
                    <thead className={bem.element('table-head')}>
                    <tr className={bem(bem.element('table-row', 'head'), bem.element('table-row'))}>
                        {this.props.columns.map((column, index) => this.renderHeaderCell(column, index))}
                    </tr>
                    </thead>
                    <tbody className={bem.element('table-body')}>
                    {body}
                    {empty}
                    </tbody>
                </table>
            </div>
        );
    }

    renderEmpty() {
        const EmptyComponent = this.props.emptyComponent;
        if (EmptyComponent) {
            return (
                <tr className={bem(bem.element('table-row', 'body'), bem.element('table-row'))}>
                    <EmptyComponent />
                </tr>
            );
        }
        return null;
    }

    renderRow(item, rowIndex) {
        return (
            <tr className={bem(bem.element('table-row', 'body'), bem.element('table-row'))}>
                {this.props.columns.map((column, cellIndex) => this.renderBodyCell(column, item, rowIndex, cellIndex))}
            </tr>
        );
    }

    renderHeaderCell(column, index) {
        let title = '';
        if (column.headerComponent) {
            const HeaderComponent = column.headerComponent;
            title = (
                <HeaderComponent
                    column={column}
                    index={index}
                />
            );
        } else if (column.title) {
            title = column.title;
        } else if (column.field) {
            title = column.field;
        }

        return (
            <th
                key={index}
                className={bem(
                    bem.element('cell'),
                    bem.element('cell', 'with-padding')
                )}
            >
                {column.sortable && (
                    <span className={bem.element('sortable-column')}>
            {title}
                        <span className={bem(bem.element('sort-caret'), 'glyphicon', 'glyphicon-triangle-bottom')}/>
          </span>
                )}
                {!column.sortable && (
                    <span>
            {title}
          </span>
                )}
            </th>
        );
    }

    renderBodyCell(column, item, rowIndex, cellIndex) {
        let value = '';
        if (column.valueComponent) {
            const ValueComponent = column.valueComponent;
            value = (
                <ValueComponent
                    item={item}
                    column={column}
                    rowIndex={rowIndex}
                    cellIndex={cellIndex}
                />
            );
        } else if (column.field) {
            value = _get(item, column.field) || '';
        }

        return (
            <td
                key={cellIndex}
                className={bem(
                    bem.element('cell'),
                    bem.element('cell', 'with-padding'),
                )}
            >
                {value}
            </td>
        );
    }

}
