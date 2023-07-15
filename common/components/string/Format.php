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
class Format
{
	static function currencyFormat($value) {
        if ($value != '' and is_numeric($value))
            $value = number_format($value, 0, ',', '.');
        return $value;
    }

    public static function formatPrice($price, $decimal = 0) {
        if ($price == '' || $price == 0)
            return '0';
        return number_format($price, $decimal, '.', ',');
    }

    public static function convertToInteger($string){
        $str = explode(',', $string);
        $str = implode('', $str);
        $param = (int)$str;
        return $param;
    }

    public static function convertToDate($string){
        return date("d-m-Y H:i:s", $string);
    }

    public static function genarateImage($url, $view)
    {
        if(!empty($url) && $view == 'view'){
            return '<img src="'.Yii::$app->params['baseUrl'].$url.'" style="width:200px" class="img-rounded"/>';
        }elseif(!empty($url) && $view == 'index'){
            return '<img src="'.Yii::$app->params['baseUrl'].$url.'" style="padding:5px;display:block;margin:0 auto;width:80px"/>';
        }elseif(empty($url)){
            return ' ';
        }
    }

    public static function genarateImagesFromJoson($json)
    {
        if(!empty($json)){
            $decode = json_decode($json);
            $images = '';

            foreach ($decode as $key => $value) {
                $images .= '
                            <div class="col-lg-2">
                                <div class="thumbnail">
                                    <div class="thumb">
                                        <img src="'.Yii::$app->params['baseUrl'].$value.'" style="width:100px" >
                                        <div class="caption-overflow">
                                            <span>
                                                <a href="'.Yii::$app->params['baseUrl'].$value.'" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            }
            return $images;
        }else{
            return ' ';
        }
    }

    public static function convertDateToInt($date)
    {
        return strtotime($date);
    }

    public static function convertIntToDate($int)
    {
        return date("d-m-Y", $int);
    }


}