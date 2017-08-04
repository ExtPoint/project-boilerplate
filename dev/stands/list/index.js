import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';

import store from 'app/core/frontend/store';
import ListExample from './views/ListExample';

// Render application
render(
    <Provider store={store}>
        <ListExample />
    </Provider>,
    document.getElementById('root')
);
