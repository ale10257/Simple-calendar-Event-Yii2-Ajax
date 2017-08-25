<?php
namespace app\modules\calendar\assets;

class CalendarAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/calendar/assets';
    public $css = [
        'calendar.css',
    ];
    public $js = [
        'calendar.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
