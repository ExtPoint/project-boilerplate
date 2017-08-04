import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';

import store from 'app/core/frontend/store';
import GameForm from './views/GameForm';

// Render application
render(
    <Provider store={store}>
        <GameForm />
    </Provider>,
    document.getElementById('root')
);
