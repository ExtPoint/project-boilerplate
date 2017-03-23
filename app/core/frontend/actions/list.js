export const LIST_BEFORE_FETCH = 'LIST_BEFORE_FETCH';
export const LIST_AFTER_FETCH = 'LIST_AFTER_FETCH';
export const INVALIDATE_LIST = 'INVALIDATE_LIST';

export const init = (id, method, page, size, sort = null, isLoadMore, primaryKey, params = {}) => (dispatch, getState) => { // eslint-disable-line no-unused-vars
    return [];
};

export const fetch = (id, method, page, size, sort = null, isLoadMore, primaryKey, params = {}) => {
    return {
        type: LIST_BEFORE_FETCH,
        id,
        page,
        size,
        sort,
        primaryKey,
        params,
    };
};
