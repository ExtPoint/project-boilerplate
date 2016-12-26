#!/usr/bin/env node

// Load Jii Framework
global.Jii = require('jii');
const ApplicationException = require('jii/exceptions/ApplicationException');

// Load other packages
const request = require('request');

// Load custom config
const customPath = __dirname + '/../../config.js';
const custom = require('fs').existsSync(customPath) ? require(customPath) : {};

require('jii/workers')
    .setEnvironment(custom.env || 'development')
    .application('comet', Jii.mergeConfigs(
        {
            application: {
                basePath: __dirname,
                inlineActions: {
                    // From php to comet
                    'api': function(context) {
                        const channel = context.request.post('channel');
                        const data = context.request.post('data');

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
                        className: require('jii/request/http/HttpServer'),
                        port: 5200
                    },
                    comet: {
                        className: require('jii/comet/server/Server'),
                        port: 5210,
                        host: '127.0.0.1',
                        transport: {
                            className: require('jii/comet/server/transport/Sockjs'),
                            urlPrefix: '/comet'
                        }
                    },
                    neat: {
                        className: require('jii/comet/server/NeatServer'),
                        configFileName: __dirname + '/../config/cometBindingFiles.json',

                        // From comet to php
                        dataLoadHandler: function(params) {
                            const url = Jii.app.params.phpLoadDataUrl;
                            return new Promise(function(resolve, reject) {
                                request({
                                    method: 'POST',
                                    uri: url,
                                    form: { msg: JSON.stringify(params) }
                                }, function(error, response, body) {
                                    if (error || !response || response.statusCode >= 400) {
                                        console.error('Request to server `' + url + '` failed: ' + error);
                                        throw new ApplicationException('Request to server `' + url + '` failed: ' + error);
                                    }

                                    let data = null;
                                    try {
                                        data = JSON.parse(body);
                                    } catch(e) {
                                        Jii.error('Cannot parse PHP response (url ' + url + '): ' + body);
                                        reject('Cannot parse PHP response (url ' + url + '): ' + body);
                                        return;
                                    }
                                    resolve(data);
                                });
                            });
                        }
                    },
                    urlManager: {
                        className: require('jii/request/UrlManager')
                    }
                }
            },
            params: {
                phpLoadDataUrl: ''
            }
        },
        custom
    ));

