import _trimStart from 'lodash/trimStart';
import _trimEnd from 'lodash/trimEnd';
import axios from 'axios';

export default class HttpComponent {

    constructor() {
        this.apiUrl = '//' + location.host;
        this._lazyRequests = {};
    }

    get(method, params = {}, options = {}) {
        return this._send(method, {
            method: 'get',
            params: params,
        }, options);
    }

    post(method, params = {}, options = {}) {
        return this._send(method, {
            method: 'post',
            data: params,
        }, options);
    }

    put(method, params = {}, options = {}) {
        return this._send(method, {
            method: 'put',
            data: params,
        }, options);
    }

    del(method, params = {}, options = {}) {
        return this._send(method, {
            method: 'delete',
            data: params,
        }, options);
    }

    _send(method, config, options) {
        const axiosConfig = {
            ...config,
            url: `${_trimEnd(this.apiUrl, '/')}/${_trimStart(method)}`,
            withCredentials: true,
            headers: {
                'Content-Type': 'application/json',
            },
        };

        if (options.lazy) {
            if (this._lazyRequests[method]) {
                clearTimeout(this._lazyRequests[method]);
            }

            return new Promise((resolve, reject) => {
                const timeout = options.lazy !== true ? options.lazy : 200;
                this._lazyRequests[method] = setTimeout(() => {
                    this._sendAxios(axiosConfig)
                        .then(result => resolve(result))
                        .catch(result => reject(result));
                }, timeout);
            });
        }

        return this._sendAxios(axiosConfig);
    }

    _sendAxios(config) {
        return axios(config).then(response => response.data);
    }

}