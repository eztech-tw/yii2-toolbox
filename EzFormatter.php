<?php
namespace eztechtw\toolbox;
use yii\helpers\Json;

class EzFormatter extends \yii\i18n\Formatter
{
    public function asArrayjson($value)
    {
        return Json::encode($value,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
