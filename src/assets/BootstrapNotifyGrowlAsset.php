<?php

namespace kriss\alertNotify\assets;

use yii\web\AssetBundle;

/**
 * @link http://bootstrap-growl.remabledesigns.com/
 */
class BootstrapNotifyGrowlAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/bootstrap-notify-3.1.3';

    public $js = [
        'bootstrap-notify.min.js'
    ];
}
