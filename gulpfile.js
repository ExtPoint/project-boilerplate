require('gulp-easy')(require('gulp'))
    .config({
        dest: './public/assets/',
        less: {
            minifycss: {
                target: './app/core',
                relativeTo: './'
            }
        },
        js: {
            jsx: true
        }
    })
    .js('app/*/client.js', 'main.js')
    .less(['app/*/less/index.less'], 'main.css')
    .files('node_modules/bootstrap/fonts/*', 'public/fonts/');