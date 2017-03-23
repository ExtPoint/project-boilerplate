const webpack = require('webpack');
const webpackEasy = require('webpack-easy');

Promise.all([
    // Index js. Core module at first
    webpackEasy.glob(`./app/*/client.js`)
        .then(files => files.sort(file => file.indexOf('app/core/') !== -1 ? -1 : 1)),

    // Index css
    webpackEasy.glob(`./app/*/style/index.less`),

    // Widgets. Only widgets with php file. Filter /path/MY_WIDGET/MY_WIDGET.js
    webpackEasy.glob(`./app/*/widgets/*/*.+(js|jsx|php)`)
        .then(files => {
            let phpWidgets = files
                .filter(file => file.match(/\.php$/))
                .map(file => file.match(/([^\/]+)\.php$/)[1]);

            return files
                .filter(file => file.match(/\.jsx?$/))
                .filter(file => phpWidgets.indexOf(file.match(/([^\/]+)\.jsx?$/)[1]) !== -1)
                .filter(file => file.match(/([^\/]+)\.jsx?$/)[1] === file.match(/([^\/]+)\/[^\/]+?$/)[1]);
        })
])
    .then(result => {
        webpackEasy
            .entry(Object.assign(
                {
                    index: result[0],
                },
                result[1].reduce((obj, file) => {
                    const name = file.match(/([^\/]+)\.less$/)[1].replace(/^index/, 'style');
                    obj[name] = obj[name] || [];
                    obj[name].push(file);
                    return obj;
                }, {}),
                result[2].reduce((obj, file) => {
                    obj[file.match(/([^\/]+)\.jsx?$/)[1]] = file;
                    return obj;
                }, {})
            ))
            .config({
                resolve: {
                    root: __dirname + '/app',
                    alias: {
                        actions: 'core/frontend/actions',
                        components: 'core/frontend/components',
                        reducers: 'core/frontend/reducers',
                        shared: 'core/frontend/shared',
                    },
                    extensions: ['', '.js']
                },
            })
            .output({
                path: `${__dirname}/public/`,
                filename: 'assets/bundle-[name].js',
                chunkFilename: 'assets/bundle-[name].js',
            })
            .loaderLess({
                loaders: [
                    'style',
                    'css',
                    'less?' + JSON.stringify({
                        modifyVars: {
                            'bem-namespace': '',
                        }
                    })
                ]
            })
            .loaderJs({
                exclude: /node_modules(\/|\\+)(?!jii)/
            })
            .serverConfig({
                contentBase: './public',
                proxy: {
                    '**': 'http://localhost',
                },
                staticOptions: {
                    '**': 'http://localhost',
                },
            })
            .plugin(new webpack.optimize.CommonsChunkPlugin('index', 'assets/bundle-index.js'))

    })
    .catch(e => console.log(e));
