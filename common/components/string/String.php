<?php
/**
 * Created by JetBrains PhpStorm.
 * User: phamviet
 * Date: 21/09/2016
 * Time: 10:46 AM
 * To change this template use File | Settings | File Templates.
 */
namespace common\components\string;
use Yii;

class String
{
    /**
     * Remove non-numeric, non-alphabet character.
     * @param $string
     * @param string $replace
     * @return mixed
     */
    public static function removeNonAlphaNumberic($string, $replace = "")
    {
        return preg_replace("/[^a-zA-Z0-9]/", $replace, $string);
    }

    /**
     * Remove accents character
     * @param $str
     * @return mixed
     */
    public static function stripAccents($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace('/[^\w\d_ -]/si', '', $str);
        $str = preg_replace('/ /', '-', $str);
        return strtolower($str);
    }


    public static function getDateName()
    {
        $index = date('w');
        $arr = array(
            0 => 'Chủ Nhật',
            1 => 'Thứ Hai',
            2 => 'Thứ Ba',
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy',
        );
        return $arr[$index];
    }

    public static function cutContent($str, $length)
    {
        $tmp1 = explode(' ', $str);
        $res = "";
        foreach ($tmp1 as $word) {
            if ((strlen($res) + strlen($word) + 1) < $length) {
                $res = $res . " " . $word;
            }
        }
        return $res;
    }
	
    public static function getTimeScriptStartAt($date)
    {
    	$now = date_create($date);
    	$day = date('z', strtotime($date));
    	$interval = 1 + ($day+1) % 2;//2 + ($day+1) % 2;
    	$res = date_add($now, new DateInterval('P'.$interval.'D'));
    	return $res->format("Y-m-d 00:00:00");
    }

    public static function getConvertDateTimeText($datetime)
    {
        $current_text = '';
        $now = time();
        $time = $datetime;
        $seconds = $now - $time;
        if($seconds == 0){
            $current_text = Yii::t('backend/app', 'Just now');
        }elseif($seconds < 60){
            $current_text = $seconds.' '.Yii::t('backend/app', 'secs');
        }elseif($seconds >= 60 && $seconds < 3600){
            $current_text = round($seconds/60).' '.Yii::t('backend/app', 'mins');
        }elseif($seconds >= 3600 && $seconds < 86400){
            $current_text = round($seconds/3600).' '.Yii::t('backend/app', 'hours');
        }elseif($seconds >= 86400 && $seconds < 31557600){
            $current_text = round($seconds/86400).' '.Yii::t('backend/app', 'days');
        }elseif($seconds >= 31557600){
            $current_text = date('d-m-Y', $datetime);
        }
        
        return $current_text;
    }

    public static function getStatusName($status){
        if($status == 10){
            $string = '<span class="label label-success">'.Yii::t('backend/app', 'Active').'</span>';
        }elseif($status == 1){
            $string = '<span class="label label-success">'.Yii::t('backend/app', 'Active').'</span>';
        }else{
            $string = '<span class="label label-danger">'.Yii::t('backend/app', 'Hidden').'</span>';
        }
        return $string;
    }

    public static function getStatusUser($status){
        if($status == 10){
            $string = '<span class="label label-success">'.Yii::t('backend/app', 'Active').'</span>';
        }else{
            $string = '<span class="label label-danger">'.Yii::t('backend/app', 'Blocked').'</span>';
        }
        return $string;
    }

    public static function getForcusName($status){
        if($status == 1){
            $string = '<span class="label label-success">'.Yii::t('backend/app', 'Yes').'</span>';
        }else{
            $string = '<span class="label label-danger">'.Yii::t('backend/app', 'No').'</span>';
        }
        return $string;
    }

    public static function getGender($gender){
        if($gender == 1){
            return Yii::t('backend/app', 'Male');
        }elseif($gender == 2){
            return Yii::t('backend/app', 'Female');
        }else{
            return Yii::t('backend/app', 'Undefined');
        }
    }
    
}
