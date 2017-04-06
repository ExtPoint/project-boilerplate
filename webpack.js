const webpack = require('webpack');
const webpackEasy = require('webpack-easy');

const filterPhpWidgets = files => {
    let phpWidgets = files
        .filter(file => file.match(/\.php$/))
        .map(file => file.match(/([^\/]+)\.php$/)[1]);

    return files
        .filter(file => file.match(/\.jsx?$/))
        .filter(file => phpWidgets.indexOf(file.match(/([^\/]+)\.jsx?$/)[1]) !== -1)
        .filter(file => file.match(/([^\/]+)\.jsx?$/)[1] === file.match(/([^\/]+)\/[^\/]+?$/)[1]);
};

Promise.all([
    // Index js. Core module at first
    webpackEasy.glob(`./app/*/client.js`)
        .then(files => files.sort(file => file.indexOf('app/core/') !== -1 ? -1 : 1)),

    // Index css
    webpackEasy.glob(`./app/*/style/index.less`),

    // Admin css
    webpackEasy.glob(`./app/*/admin/style/index.less`),

    // Other css
    webpackEasy.glob(`./app/landing/style/index-*.less`),

    // Widgets. Only widgets with php file. Filter /path/MY_WIDGET/MY_WIDGET.js
    webpackEasy.glob(`./app/*/widgets/*/*.+(js|jsx|php)`).then(filterPhpWidgets),
    webpackEasy.glob(`./app/*/admin/widgets/*/*.+(js|jsx|php)`).then(filterPhpWidgets)
])
    .then(result => {
        webpackEasy
            .entry(Object.assign(
                {
                    index: result[0],
                    'style': result[1],
                    'style-admin': result[2],
                },
                result[3].reduce((obj, file) => {
                    const name = file.match(/([^\/]+)\.less$/)[1].replace(/^index/, 'style');
                    obj[name] = obj[name] || [];
                    obj[name].push(file);
                    return obj;
                }, {}),
                result[4].reduce((obj, file) => {
                    obj[file.match(/([^\/]+)\.jsx?$/)[1]] = file;
                    return obj;
                }, {}),
                result[5].reduce((obj, file) => {
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
                filename: (webpackEasy.isProduction() ? '' : '1.0/') + 'assets/bundle-[name].js',
                chunkFilename: (webpackEasy.isProduction() ? '' : '1.0/') + 'assets/bundle-[name].js',
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
            .plugin(new webpack.optimize.CommonsChunkPlugin('index', (webpackEasy.isProduction() ? '' : '1.0/') + 'assets/bundle-index.js'))

    })
    .catch(e => console.log(e));
