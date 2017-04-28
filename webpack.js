require('extpoint-yii2/webpack')
    // Index js. Core module at first
    .base('./app/*/client.js')

    // Index css
    .styles('./app/*/style/index.less')

    // Admin css
    .styles('./app/*/admin/style/index.less', 'admin')

    // Other css
    .styles('./app/*/style/index-*.less')

    // Widgets. Only widgets with php file. Filter /path/MY_WIDGET/MY_WIDGET.js
    .widgets('./app/*/widgets')
    .widgets('./app/*/admin/widgets')
    .widgets('./vendor/extpoint/yii2-gii/lib/widgets')
    .widgets('./vendor/extpoint/yii2-file/lib/widgets')

