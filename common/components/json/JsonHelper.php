<?php
namespace common\components\json;
use Yii;

class JsonHelper
{
    public static function readBTDT($nguhanh)
    {
        $path = Yii::getAlias('@common/data/botrodungthan.json');
        if (!file_exists($path)) {
            return null;
        }

        $content = file_get_contents($path);

        // Tránh lỗi khi JSON không hợp lệ
        $data = json_decode($content, true);
        if(isset($data['dungThan'][$nguhanh])){
            $data = $data['dungThan'][$nguhanh];
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        return $data;
    }
}
