// Load Jii Framework
window.Jii = require('jii/deps');
Jii.namespaceMoveContext(window);

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
                    className: require('jii/comet/client/Client'),
                    transport: {
                        className: require('jii/comet/client/transport/Sockjs')
                    },
                    plugins: {
                        autoReconnect: {
                            className: require('jii/comet/client/plugin/AutoReconnect')
                        }
                    }
                },
                neat: {
                    className: require('jii/comet/client/NeatClient'),
                    engine: {
                        className: 'NeatComet.NeatCometClient',
                        //createCollection: app.comet.adapter.OrmAdapter.createCollection
                    }
                }
            }
        }
    },
    JII_CONFIG
)).start();