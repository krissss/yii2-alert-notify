<?php

namespace kriss\alertNotify\widgets;

use kriss\alertNotify\assets\AjaxNotifyAsset;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class AjaxNotifyWidget extends Widget
{
    public $enable = true;

    public $url = ['/ajax/notify'];

    public $delay = 2000;

    public function run()
    {
        parent::run();

        $this->registerAssets();

        return Html::tag('span', '', [
            'class' => 'ajax-notify',
            'data-enable' => (int)$this->enable,
            'data-from' => time(),
            'data-url' => Url::to($this->url),
            'data-delay' => $this->delay,
        ]);
    }

    protected function registerAssets()
    {
        AjaxNotifyAsset::register($this->view);
    }
}
