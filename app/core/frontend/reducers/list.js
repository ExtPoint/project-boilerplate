import {LIST_BEFORE_FETCH, LIST_AFTER_FETCH, INVALIDATE_LIST} from '../actions/list';

const initialState = {
    lists: {},
};

export default (state = initialState, action) => {
    switch (action.type) {
        case LIST_BEFORE_FETCH:
            return {
                lists: {
                    ...state.lists,
                    [action.id]: {
                        isFetched: !!state.lists[action.id],
                        isLoading: true,
                        page: action.page,
                        size: action.size,
                        sort: action.sort,
                        params: action.params,
                        primaryKey: action.primaryKey,
                        metadata: state.lists[action.id] && state.lists[action.id].metadata || {},
                        entries: state.lists[action.id] && state.lists[action.id].entries || [],
                        totalCount: state.lists[action.id] && state.lists[action.id].totalCount || 0,
                        hasPagination: state.lists[action.id] && state.lists[action.id].hasPagination || false,
                    }
                }
            };

        case LIST_AFTER_FETCH:
            let entries = [];
            if (action.isLoadMore && state.lists[action.id] && state.lists[action.id].entries) {
                entries = [].concat(state.lists[action.id].entries);
                action.entries.forEach((entry, i) => {
                    const index = (action.page * action.size) + i;
                    entries[index] = entry;
                });
            } else {
                entries = action.entries;
            }


            return {
                lists: {
                    ...state.lists,
                    [action.id]: {
                        isFetched: true,
                        isLoading: false,
                        page: action.page,
                        size: action.size,
                        sort: action.sort,
                        params: action.params,
                        primaryKey: action.primaryKey,
                        totalCount: action.totalCount,
                        hasPagination: action.hasPagination,
                        metadata: action.metadata,
                        entries: entries,
                    }
                }
            };

        case INVALIDATE_LIST:
            return {
                lists: {
                    ...state.lists,
                    [action.id]: null
                }
            };
    }

    return state;
};

export const getList = (state, id) => state.list.lists[id] || {};
export const getEntry = (state, listId, entryId) => {
    const list = state.list.lists[listId];
    if (!list) {
        return null;
    }
    return list.entries.find(entry => entry[list.primaryKey] === entryId) || null;
};