<?php 

namespace adlurfm\driverjs;


class DriverJsAsset extends \yii\web\AssetBundle {

    public $sourcePath = __DIR__.'\resources';

    public $css = [
        'css/driver.css',
    ];

    public $js = [
        'js/driver.js.iife.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}

