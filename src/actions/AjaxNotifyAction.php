<?php

namespace kriss\alertNotify\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\Response;

class AjaxNotifyAction extends Action
{
    public $generateInfo;

    public function run($from)
    {
        $time = time();

        if (is_string($this->generateInfo)) {
            $info = call_user_func([$this->controller, $this->generateInfo], $from);
        } elseif (is_callable($this->generateInfo)) {
            $info = call_user_func($this->generateInfo, $from);
        } else {
            throw new InvalidConfigException("generateInfo must be set");
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'time' => $time,
            'info' => $info,
        ];
    }
}
