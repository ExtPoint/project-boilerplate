<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $sourcePath = __DIR__;
    public $baseUrl = '@web';

    public $css = [
        'less/index.less',
    ];

    public $js = [
        'js/main.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        // Skip by extensions
        $this->publishOptions['beforeCopy'] = function($from, $to) {
            return preg_match("/(less|css|map|js)$/i", $from) === 1;
        };
    }

}
