Yii2 Alert Notify
=================
Yii2 Alert Notify

Installation
------------

```
composer require kriss/yii2-alert-notify -vvv
```

Usage Ajax Notify
-----

1. Create a controller like: `AjaxController`, then add action:

```php
public function actions()
{
    $actions = parent::actions();

    $actions['notify'] = [
        'class' => AjaxNotifyAction::class,
        'generateInfo' => 'generateNotifyInfo',
    ];

    return $actions;
}
```

2. Write `generateNotifyInfo` in controller, this is example:

```php
public function generateNotifyInfo($from)
{
    $info = [];
    // get info from db or other storage
    // example
    if (random_int(0, 999) > 300) {
        $info[] = [
            'notifyOptions' => [
                'message' => date('H:i:s') . '：Has New Message',
                'url' => Url::to(['site/index']),
                'target' => '_self',
            ],
            'notifySettings' => [
                'delay' => 0,
                'type' => 'info',
                'offset' => [
                    'x' => 20,
                    'y' => 70,
                ],
            ],
            'audioConfig' => [
                'url' => Yii::getAlias('@web/audio/sound1.mp3'),
                'count' => 1,
                'delay' => 1000,
            ],
        ];
    }
    // example End
    return $info;
}
```

3. Use Widget in View, like `layouts/main.php`

```html
<?= AjaxNotifyWidget::widget() ?>
```

4. After refresh browser, you will see: 

![preview1](https://github.com/krissss/yii2-alert-notify/raw/master/preview/preview1.jpg)

Ajax Notify `generateInfo` Result Description
-----

- notifyOptions: see [bootstrap-notify Options](http://bootstrap-growl.remabledesigns.com/)

- notifySettings: see [bootstrap-notify Settings](http://bootstrap-growl.remabledesigns.com/)

- audioConfig: 

    - url: audio src
    
    - count: audio play count
    
    - delay: how long between audio play ended and play next, unit `ms`

Usage Flush Notify
-----

1. Use Widget in View, like `layouts/main.php`

```html
<?= FlushNotifyWidget::widget() ?>
```

2. Add flush message in controller or service:

```php
Yii::$app->session->addFlash('success', 'Operate Success');
Yii::$app->session->addFlash('danger', 'Operate danger');
Yii::$app->session->addFlash('error', 'Operate error');
```

3. After refresh browser, you will see: 

![preview1](https://github.com/krissss/yii2-alert-notify/raw/master/preview/preview2.jpg)
