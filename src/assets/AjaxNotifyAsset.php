<?php

namespace kriss\alertNotify\assets;

use yii\web\AssetBundle;

class AjaxNotifyAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/ajax-notify-1.0';

    public $js = [
        'ajax-notify.js',
    ];

    public $depends = [
        'kriss\alertNotify\assets\BootstrapNotifyGrowlAsset',
    ];
}
