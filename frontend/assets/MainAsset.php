<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@frontend';

    public $css = [
	'css/normalize.css',
        'css/style.css',
    ];
    public $js = [
        'js/main.js'
    ];
}
