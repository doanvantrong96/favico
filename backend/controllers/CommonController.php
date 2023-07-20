<?php

namespace backend\controllers;

use Yii;
use backend\models\District;
use backend\models\News;
use backend\models\Product;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\components\EncodeVideo;
use mdm\admin\components\AccessControl;
use yii\helpers\Url;

require_once YII_APP_BASE_PATH . '/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once YII_APP_BASE_PATH . '/vendor/PHPExcel/Classes/PHPExcel.php';
require_once YII_APP_BASE_PATH . '/vendor/PHPExcel/Classes/PHPExcel/Cell.php';

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class CommonController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove-file' => ['POST'],
                    'upload-file' => ['POST'],
                ],
            ],
            // 'corsFilter' => [
            //     'class' => \yii\filters\Cors::className(),
            //     'cors' => [
            //         // restrict access to
            //         'Origin' => ['*'],
            //         'Access-Control-Request-Method' => ['POST', 'GET'],
            //         // Allow only POST and PUT methods
            //         'Access-Control-Request-Headers' => ['*'],
            //         // Allow only headers 'X-Wsse'
            //         'Access-Control-Allow-Credentials' => true,
            //         // Allow OPTIONS caching
            //         'Access-Control-Max-Age' => 3600,
            //         // Allow the X-Pagination-Current-Page header to be exposed to the browser.
            //         'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            //     ],

            // ],

        ];
    }

    public static function encodeVideoLesson($model, $path_file_tmp, $isUpdatePath = false){
        $target_dir     = $_SERVER['DOCUMENT_ROOT'];
        $path_file_tmp  = $target_dir . '/' . $path_file_tmp;
        if( file_exists($path_file_tmp) ){
            $id         = $model->id;
            $folder     = "video-lesson/$id";
            if (!file_exists($target_dir . "/uploads/" . $folder)) {
                mkdir($target_dir . "/uploads/" . $folder, 0777, true);
                chmod($target_dir . "/uploads/" . $folder, 0777);
            }
            $path_org_file = "/uploads/" . $folder . '/' . basename($path_file_tmp);
            rename($path_file_tmp, $target_dir . $path_org_file);

            if( $isUpdatePath ){
                $model->path_file = $path_org_file;
                $model->save(false);
            }

            Yii::$app->queue->push(new EncodeVideo([
                'id'            => $id,
                'path_org_file' => $path_org_file,
                'target_dir'    => $target_dir
            ]));
        }
        return $model;
    }

    public static function uploadFile($file = null, $folder)
    {
        if (!empty($file)) {
            $_FILES["file"] = $file;
        }
        if ($_FILES["file"]["error"]) {
            return (array("message" => 'Có lỗi khi tải file. Vui lòng tải lại file khác', "status" => false));
        }

        $image_type = mime_content_type($_FILES['file']['tmp_name']);

        $target_dir = $_SERVER['DOCUMENT_ROOT'];
        
        if (!file_exists($target_dir . "/uploads/" . $folder)) {
            mkdir($target_dir . "/uploads/" . $folder, 0777, true);
            chmod($target_dir . "/uploads/" . $folder, 0777);
        }
        if( isset(Yii::$app->params['root_foder_upload'])){
            $target_dir_sync = Url::to('@frontend/web');
            
            if (!file_exists($target_dir_sync . "/uploads/" . $folder)) {
                mkdir($target_dir_sync . "/uploads/" . $folder, 0775, true);
            }
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return (array("message" => 'Only method post', "status" => false));
        }

        $target_file    = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk       = 1;
        $extFileType    = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_name      = explode('.' . $extFileType,basename($_FILES["file"]["name"]));
        $checkImage     = true;
        $extFileType    = strtolower($extFileType);
        $name_file      = "/uploads/" . $folder . "/" . time() . '-' . CommonController::LocDau($file_name[0]) . '.' . $extFileType;

        $target_file    = $target_dir . $name_file;
        
        if ($uploadOk == 0) {
            return (array("message" => "", "status" => false));
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                if( isset(Yii::$app->params['root_foder_upload']) && file_exists($target_file) )
                {
                    copy($target_file, Url::to('@frontend/web') . $name_file);
                }
                $message = "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
                if( strpos($folder,'video-lesson') !== false ){
                    $dataFolder = explode('/',$folder);
                    $id_lesson  = end($dataFolder);
                    if( $id_lesson > 0 ){
                        Yii::$app->queue->push(new EncodeVideo([
                            'id'            => $id_lesson,
                            'path_org_file' => $name_file,
                            'target_dir'    => $_SERVER['DOCUMENT_ROOT']
                        ]));
                    }
                }
                
                switch (strtolower($image_type)) {
                    case 'image/png':
                        $image_resource = imagecreatefrompng($target_file);
                        break;
                    case 'image/gif':
                        $image_resource = imagecreatefromgif($target_file);
                        break;
                    case 'image/jpeg':
                    case 'image/pjpeg':
                    case 'image/jpg':
                        $image_resource = imagecreatefromjpeg($target_file);
                        break;
                    default:
                        $image_resource = false;
                }
                if ($image_resource) {
                    // if( $folder == 'news' )
                        self::compressImage($target_file,$target_file, 85);//Nén chất lượng ảnh xuống 85%
                }
                $url = $name_file;
                return (array("message" => $message, "status" => true,'target_file'=>$target_file, 'url' => $url));
            } else {
                $message = "Sorry, there was an error uploading your file.";
                return (array("message" => $message, "status" => false));
            }
        }
    }
    
    private static function compressImage($source, $destination, $quality){
        if( file_exists($source) ){
            $info = getimagesize($source);
            $imageSize = filesize($source);
            if( $imageSize >= 500000 ){
                if( $imageSize >= 1500000 )
                    $quality = 60;
                if ($info['mime'] == 'image/jpeg'){
                    $image = imagecreatefromjpeg($source);
                }
            
                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($source);
            
                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($source);
            
                imagejpeg($image, $destination, $quality);
            }
        }
        return $destination;
    }
    public static function removeFile($file)
    {
        $target_dir = $_SERVER['DOCUMENT_ROOT'];
        if( file_exists($target_dir . $file) ){
            unlink($target_dir . $file);
        }
        if( isset(Yii::$app->params['root_foder_upload']) ){
            $target_dir = Yii::$app->params['root_foder_upload'];
            if( file_exists($target_dir . $file) ){
                unlink($target_dir . $file);
            }
        }
    }

    public function actionUploadFile()
    {
        $request = Yii::$app->request;
        $post = Yii::$app->request->post();
        if (($request->isPost) && !empty($post['folder'])) {
            $res = $this->uploadFile($_FILES["file"], $post['folder']);
            echo json_encode($res);
            die;
        } else {
            echo json_encode(array("status" => false, "message" => 'sorry. only method post'));
            die;
        }
    }

    public function actionRemoveFile()
    {
        $post = Yii::$app->request->post();
        if (!empty($post['file'])) {
            $res = $this->removeFile($_SERVER['DOCUMENT_ROOT'] . $post['file']);
            echo json_encode($res);
            die;
        } else {
            echo json_encode(array("status" => false, "message" => 'Đã có lỗi xảy ra'));
            die;
        }
    }

    public function upload($file, $folder)
    {
        # code...
        if (!empty($file) && !empty($folder)) {
            $res = CommonController::uploadFile($file, $folder);
            return $res;
        } else {
            return array("status" => false, "message" => 'sorry. only method post');
        }
    }

    public static function LocDau($str, $char = '-')
    {
        $str = trim($str);
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|�� �|ặ|ẳ|ẵ|ắ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|�� �|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ợ|Ở|Ớ|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace("/( |'|,|\||\.|\"|\?|\/|\%|–|!|’|‘)/", '-', $str);
        $str = preg_replace("/(\()/", '-', $str);
        $str = preg_replace("/(\))/", '-', $str);
        $str = preg_replace("/(&)/", '', $str);
        $str = preg_replace("/“/", '', $str);
        $str = preg_replace("/”/", '', $str);
        $str = preg_replace("/;/", '', $str);
        $str = preg_replace("/\[/", '', $str);
        $str = preg_replace("/\]/", '', $str);
        $str = preg_replace("/:/", '', $str);
        $str = preg_replace("/(?)/", '', $str);
        $str = str_replace(['`','~','@','#','$','^','*','<','>','{','}'],'',$str);
        $str = array_filter(explode('-', strtolower($str)));

        return implode($char, $str);
    }
    public static function checkAccess($action){
        if( Yii::$app->user->identity->is_admin )
            return true;
        $check = false;
        if( is_array($action) ){
            foreach($action as $act){
                $accessCtroller = new AccessControl;
                $check          = $accessCtroller->checkRouter($act);
                if( $check ){
                    break;
                }
            }
        }else{
            $accessCtroller = new AccessControl;
            $check          = $accessCtroller->checkRouter($action);
        }
        return $check;
    }
    public static function checkRolePermission($model, $isInPermission = true){
        $result         = false;
        $permissions    = [];
        if( $isInPermission ){
            if (is_array($model)) {
                foreach ($model as $m) {
                    $permissions = array_merge($permissions, \Yii::$app->params['permission'][$m]);
                }
            } else {
                $permissions = \Yii::$app->params['permission'][$model];
            }
        }else{
            if( !is_array($model) )
                $permissions = [$model];
        }
        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    public function actionGetRelatedNews(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arrReturn  = [
            'total_count' => 0,
            'incomplete_results' => false,
            'items' => []
        ];
        $request    = $_REQUEST;
        $q          = $request['q'];
        $page       = isset($request['page']) ? $request['page'] : 1;
        $ids_igrs   = isset($request['ids_igrs']) && !empty($request['ids_igrs']) ? $request['ids_igrs'] : [];
        $limit      = 30;
        $offset     = ($page - 1) * $limit;
        if( !empty($q) ){
            $listCate = [];
            // if( !Yii::$app->user->identity->is_admin ){
            //     $listCateOfUser  = Yii::$app->user->identity->categoryIds();
            //     if( empty($listCateOfUser) ){
            //         return $arrReturn;
            //     }else{
            //         if( !in_array(-1, $listCateOfUser) ){
            //             $listCate = $listCateOfUser;
            //         }
            //     }
            // }
            $query = News::find()->select('A.id, A.title as name')->from(News::tableName() . ' A')->where(['or',['like','title',$q],['like','slug',$q]])->andWhere(['status'=>1,'is_delete'=>0]);
            if( !empty($listCate) ){
                $query->innerJoin(\backend\models\CategoryNews::tableName() . ' B', 'A.id = B.news_id');
                $query->andWhere(['in', 'B.category_id', $listCate]);
                if( count($listCate) > 1 )
                    $query->groupBy(['A.id']);
            }
            if( !empty($ids_igrs) ){
                if( !is_array($ids_igrs) ){
                    if( strpos($ids_igrs, ',') !== false ){
                        $ids_igrs = explode(',', $ids_igrs);
                    }else
                        $ids_igrs = [$ids_igrs];
                }
                $query->andWhere(['not in', 'A.id', $ids_igrs ]);
            }
            $arrReturn['total_count']   = $query->count();
            $arrReturn['items']         = $query->limit($limit)->offset($offset)->asArray()->all();
        }
        return $arrReturn;
    }

    public function actionGetRelatedProduct(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arrReturn  = [
            'total_count' => 0,
            'incomplete_results' => false,
            'items' => []
        ];
        $request    = $_REQUEST;
        $q          = $request['q'];
        $page       = isset($request['page']) ? $request['page'] : 1;
        $ids_igrs   = isset($request['ids_igrs']) && !empty($request['ids_igrs']) ? $request['ids_igrs'] : [];
        $limit      = 30;
        $offset     = ($page - 1) * $limit;
        if( !empty($q) ){
            $listCate = [];
            // if( !Yii::$app->user->identity->is_admin ){
            //     $listCateOfUser  = Yii::$app->user->identity->categoryIds();
            //     if( empty($listCateOfUser) ){
            //         return $arrReturn;
            //     }else{
            //         if( !in_array(-1, $listCateOfUser) ){
            //             $listCate = $listCateOfUser;
            //         }
            //     }
            // }
            $query = Product::find()->select('A.id, A.title as name')->from(Product::tableName() . ' A')->where(['or',['like','title',$q],['like','slug',$q]])->andWhere(['status'=>1]);
            // if( !empty($listCate) ){
            //     $query->innerJoin(\backend\models\CategoryNews::tableName() . ' B', 'A.id = B.news_id');
            //     $query->andWhere(['in', 'B.category_id', $listCate]);
            //     if( count($listCate) > 1 )
            //         $query->groupBy(['A.id']);
            // }
            if( !empty($ids_igrs) ){
                if( !is_array($ids_igrs) ){
                    if( strpos($ids_igrs, ',') !== false ){
                        $ids_igrs = explode(',', $ids_igrs);
                    }else
                        $ids_igrs = [$ids_igrs];
                }
                $query->andWhere(['not in', 'A.id', $ids_igrs ]);
            }
            $arrReturn['total_count']   = $query->count();
            $arrReturn['items']         = $query->limit($limit)->offset($offset)->asArray()->all();
        }
        return $arrReturn;
    }

    public static function getAgentIp(){
        $ipString = @getenv("HTTP_X_FORWARDED_FOR");
        if (!empty($ipString)) {
            $addr = explode(",", $ipString);
            return $addr[0];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString);
    }

    public function actionRemoveUnicode(){
        $request = $_REQUEST;
        $text    = $request['text'];
        $char    = $request['char'];

        $text_remove_unicode = self::LocDau($text,$char);
        // if( strpos($text_remove_unicode,'-') !== false ){
        //     $data = explode('-',$text_remove_unicode);
        //     $end_data = end($data);
        //     if( is_numeric($end_data) && $end_data > 0 ){
        //         $text_remove_unicode .= $char . 'ps';
        //     }
        // }
        echo $text_remove_unicode;
        die;
    }

    public static function getStatusName($status_id){
        $statusList = Yii::$app->params['statusList'];
        return isset($statusList[$status_id]) ? $statusList[$status_id] : 'N/A';
    }

    public static function getTypeComment($status_id){
        $statusList = Yii::$app->params['commentTypeList'];
        return isset($statusList[$status_id]) ? $statusList[$status_id] : 'N/A';
    }
    
    public static function getPositionName($status_id){ 
        $statusList = Yii::$app->params['positionList'];
        return isset($statusList[$status_id]) ? $statusList[$status_id] : 'N/A';
    }
    public static function getStatusNameCommunity($status_id){
        $statusList = Yii::$app->params['statusCommunityList'];
        return isset($statusList[$status_id]) ? $statusList[$status_id] : 'N/A';
    }
    public static function getStateNameCommunity($status_id){
        $statusList = Yii::$app->params['stateCommunityList'];
        return isset($statusList[$status_id]) ? $statusList[$status_id] : 'N/A';
    }
    
    public static function getGroupNameFrequentlyQuestions($id){
        $groupList = \backend\models\FrequentlyQuestionsGroup::findOne($id);
        return $groupList ? $groupList->name : 'N/A';
    }

    public static function getStatusNameUser($status_id){
        $statusList = Yii::$app->params['userStatus'];
        return isset($statusList[$status_id]) ? $statusList[$status_id] : 'N/A';
    }
    public static function encryptDecrypt($string, $action = 'encrypt'){
        $encrypt_method = "AES-128-CBC";
        $secret_key     = 'J9SxUpfWDDmWkfAzLCWH9k78fYPQDsLBpXfRswWQ2XmQAyaHgbSFtDq26Lt7qczpSa5wzs2rtjP2sGEWJhaV45B'; // user define private key
        $key            = hash('sha256', $secret_key);
        $ivlen          = openssl_cipher_iv_length($encrypt_method);
        if ($action == 'encrypt') {
            $iv         = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt($string, $encrypt_method, $key, $options=OPENSSL_RAW_DATA, $iv);
            $hmac       = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            $output     = base64_encode( $iv. $hmac . $ciphertext_raw );
        } else if ($action == 'decrypt') {
            $c              = base64_decode($string);
            $iv             = substr($c, 0, $ivlen);
            $hmac           = substr($c, $ivlen, $sha2len=32);
            $ciphertext_raw = substr($c, $ivlen+$sha2len);
            $output         = openssl_decrypt($ciphertext_raw, $encrypt_method, $key, $options=OPENSSL_RAW_DATA, $iv);
            $calcmac        = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            if (!hash_equals($hmac, $calcmac)){
                $output     = "";
            }
        }
        return $output;
    }

    public static function exportDataExcel($header, $data, $file_name)
    {
        if (empty($data)) {
            exit();
        }
        
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('Danh sách');
        $lastColumn = '';
        for($i=1 ,$j='A'; $i <= count($header);$i++,$j++) {
            $excel->getActiveSheet()->getColumnDimension($j)->setAutoSize(true);
            $lastColumn = $j;
        }
       
        $excel->getActiveSheet()->getStyle("A1:" . $lastColumn . "1")->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle("A1:" . $lastColumn . "1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $excel->getActiveSheet()->getStyle("A1:" . $lastColumn . "1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
        for($i=1 ,$j='A'; $i <= count($header);$i++,$j++) {
            $excel->getActiveSheet()->setCellValue($j .'1', $header[$i - 1]);
        }
        $numRow = 2;
       
        foreach ($data as $key => $row) {
            for($i=1 ,$j='A'; $i <= count($row);$i++,$j++) {
                $excel->getActiveSheet()->setCellValue($j . $numRow, $row[$i - 1]);
            }
            
            $numRow++;
        }
       
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $file_name . '.xls"');
        echo '<pre>';
        print_r($excel);
        echo '</pre>';
        die;
        PHPExcel_IOFactory::createWriter($excel, 'Excel5')->save('php://output');
        exit;
    }
    
}