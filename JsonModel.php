<?php

namespace eztechtw\toolbox;

use Yii;
use yii\helpers\Json;
/**
 * 避免將 Json 字串再次編碼的 Model
 */
class JsonModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        //若資料庫欄位為json格式，但模型儲存時裡面存放為字串而非物件時，將字串解開為物件，Yii2會將物件自動編碼為Json再儲存
        foreach ($this::getTableSchema()->columns as $col){
            if($col->dbType=='json') {
                $colNm=$col->name;
                if (is_string($this->$colNm)) {
                    json_decode($this->$colNm);
                    if(json_last_error() == JSON_ERROR_NONE){
                        $this->$colNm = Json::decode($this->$colNm);
                    }
                }
            }
        }
        return true;
    }
}
