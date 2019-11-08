<?php

namespace kriss\alertNotify\widgets;

use kriss\alertNotify\assets\BootstrapNotifyGrowlAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class FlushNotifyWidget extends Widget
{
    public $pluginOptions = [];
    public $pluginSettings = [];

    public $typeMap = [
        'error' => 'danger',
        'danger' => 'danger',
        'success' => 'success',
        'info' => 'info',
        'warning' => 'warning',
        'primary' => 'primary',
    ];

    public function run()
    {
        parent::run();

        $this->registerAssets();

        $flushMessages = $this->getFlushMessages();
        $notifyInfo = [];
        foreach ($flushMessages as $flushMessage) {
            $notifyInfo[] = [
                'options' => ArrayHelper::merge(
                    ['target' => '_self'],
                    $this->pluginOptions,
                    ['message' => $flushMessage['message']]
                ),
                'settings' => ArrayHelper::merge(
                    [
                        'placement' => [
                            'from' => 'top',
                            'align' => 'center',
                        ],
                        'mouse_over' => 'pause',
                        'offset' => [
                            'y' => 70,
                        ]
                    ],
                    $this->pluginSettings,
                    ['type' => $flushMessage['type']]
                ),
            ];
        }
        $notifyInfo = Json::encode($notifyInfo);
        $js = <<<JS
var notifyInfo = {$notifyInfo};
$.each(notifyInfo, function(k, v) {
  $.notify(v.options, v.settings);
})
JS;
        $this->view->registerJs($js);
    }

    protected function registerAssets()
    {
        BootstrapNotifyGrowlAsset::register($this->view);
    }

    protected function getFlushMessages()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        $result = [];

        foreach ($flashes as $type => $flash) {
            if (!isset($this->typeMap[$type])) {
                continue;
            }
            $showType = $this->typeMap[$type];

            foreach ((array)$flash as $i => $message) {
                $result[] = [
                    'type' => $showType,
                    'message' => $message
                ];
            }

            $session->removeFlash($type);
        }

        return $result;
    }
}
