// Load Jii Framework
window.Jii = require('jii/deps');
Jii.namespaceMoveContext(window);
require('jii-comet/sockjs');
require('jii-comet/neat');

// Load module files
require('./adapter/OrmAdapter');

if (!window.JII_CONFIG) {
    return;
}

Jii.createWebApplication(Jii.mergeConfigs(
    {
        application: {
            basePath: '/',
            components: {
                comet: {
                    className: 'Jii.comet.client.Client'
                },
                neat: {
                    className: 'Jii.comet.client.NeatClient',
                    engine: {
                        className: 'NeatComet.NeatCometClient',
                        createCollection: app.comet.adapter.OrmAdapter.createCollection
                    }
                }
            }
        }
    },
    JII_CONFIG
)).start();