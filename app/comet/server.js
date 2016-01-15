#!/usr/bin/env node

// Load Jii Framework
global.Jii = require('jii');
require('jii-urlmanager');
require('jii-httpserver');
require('jii-comet');

// Load other packages
var request = require('request');

// Load custom config
var customPath = __dirname + '/../../config.js';
var custom = require('fs').existsSync(customPath) ? require(customPath) : {};

require('jii-workers')
    .setEnvironment(custom.env || 'development')
    .application('comet', Jii.mergeConfigs(
        {
            application: {
                basePath: __dirname,
                inlineActions: {
                    // From php to comet
                    'api': function(context) {
                        var channel = context.request.post('channel');
                        var data = context.request.post('data');

                        if (context.request.post('method') === 'publish' && channel && data) {
                            Jii.app.comet.sendToChannel(channel, JSON.parse(data));
                            return 'ok';
                        } else {
                            context.response.setStatusCode(400);
                            return 'Wrong api method.';
                        }
                    }
                },
                components: {
                    http: {
                        className: 'Jii.httpServer.HttpServer',
                        port: 5200
                    },
                    comet: {
                        className: 'Jii.comet.server.Server',
                        port: 5210,
                        host: '127.0.0.1',
                        transport: {
                            className: 'Jii.comet.server.transport.SockJs',
                            urlPrefix: '/comet'
                        }
                    },
                    neat: {
                        className: 'Jii.comet.server.NeatServer',
                        configFileName: __dirname + '/bindings.json',

                        // From comet to php
                        dataLoadHandler: function(params) {
                            var url = Jii.app.params.phpLoadDataUrl;
                            return new Promise(function(resolve) {
                                request({
                                    method: 'POST',
                                    uri: url,
                                    form: { msg: JSON.stringify(params) }
                                }, function(error, response, body) {
                                    if (error || !response || response.statusCode >= 400) {
                                        throw new Jii.exceptions.ApplicationException('Request to server `' + url + '` failed: ' + error);
                                    }

                                    var data = null;
                                    try {
                                        data = JSON.parse(body);
                                    } catch(e) {
                                        Jii.error('Cannot parse PHP response (url ' + url + '): ' + body);
                                    }
                                    if (data) {
                                        resolve(data);
                                    }
                                });
                            });
                        }
                    },
                    urlManager: {
                        className: 'Jii.urlManager.UrlManager'
                    }
                }
            },
            params: {
                phpLoadDataUrl: ''
            }
        },
        custom
    ));

