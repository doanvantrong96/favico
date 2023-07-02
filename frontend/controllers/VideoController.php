<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\CourseLesson;
use  yii\web\Session;
use  frontend\models\VideoTmp;
use backend\models\ContinueLesson;

class VideoController extends Controller {
    private $openssl_encrypt_method  = "aes-256-ecb";
    private $path = "";
    private $stream = "";
    private $buffer = 102400;
    private $start  = -1;
    private $end    = -1;
    private $size   = 0;


    //lưu thời gian xem dở video của user
    public function actionSaveTimeVideo(){
        if(isset($_POST['time'])){
            $lesson_id = $_POST['lesson_id'];
            $course_id = $_POST['course_id'];
            $time = ceil($_POST['time']);
            $user_id = Yii::$app->user->identity->id;

            $check_exit = ContinueLesson::find()
            ->where(['user_id' => $user_id,'lesson_id' => $lesson_id,'course_id' => $course_id])
            ->one();
          
            if(!$check_exit){
                $model = new ContinueLesson();
                $model->user_id = $user_id;
                $model->lesson_id = $lesson_id;
                $model->course_id = $course_id;
                $model->time = $time;
                $model->save(false);
                echo 1;die;
            }else if($check_exit->is_end == 0){
                $lesson = CourseLesson::findOne($lesson_id);
                $duration_lesson = $lesson->duration;
             
                if($duration_lesson > $time){
                    $check_exit->time = $time;
                }else{
                    $check_exit->time = $time;
                    $check_exit->is_end = 1;
                }
                $check_exit->save(false);
                echo 2;die;
            }else{
                echo 3;die;
            }
        }
    }


    public function actionExample(){
        $this->layout = 'payment';
        return $this->render('example');
    }
    
    public function beforeAction($action){
        if( isset($_SERVER["HTTP_ORIGIN"]) && in_array($_SERVER["HTTP_ORIGIN"],['https://yogalunathai.com','https://admin.yogalunathai.com']) )
            header('Access-Control-Allow-Origin: ' . $_SERVER["HTTP_ORIGIN"]); 
        return true;
    }
    /**
     * Open stream
     */
    private function open()
    {
        if (!($this->stream = fopen($this->path, 'rb'))) {
            die('Could not open stream for reading');
        }

    }

    /**
     * Set proper header to serve the video content
     */
    private function setHeader()
    {
        ob_get_clean();
        header("Content-Type: video/mp4");
        // header("Cache-Control: max-age=2592000, public");
        // header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->path)) . ' GMT' );
        $this->start = 0;
        $this->size  = filesize($this->path);
        $this->end   = $this->size - 1;
        header("Accept-Ranges: 0-".$this->end);

        if (isset($_SERVER['HTTP_RANGE'])) {

            $c_start = $this->start;
            $c_end = $this->end;

            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            if ($range == '-') {
                $c_start = $this->size - substr($range, 1);
            }else{
                $range = explode('-', $range);
                $c_start = $range[0];

                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
            }
            $c_end = ($c_end > $this->end) ? $this->end : $c_end;
            if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            $this->start = $c_start;
            $this->end = $c_end;
            $length = $this->end - $this->start + 1;
            fseek($this->stream, $this->start);
            header('HTTP/1.1 206 Partial Content');
            header("Content-Length: ".$length);
            header("Content-Range: bytes $this->start-$this->end/".$this->size);
        }
        else
        {
            header("Content-Length: ".$this->size);
        }  

    }

    /**
     * close curretly opened stream
     */
    private function end()
    {
        fclose($this->stream);
        exit;
    }

    /**
     * perform the streaming of calculated range
     */
    private function stream()
    {
        $i = $this->start;
        set_time_limit(0);
        while(!feof($this->stream) && $i <= $this->end) {
            $bytesToRead = $this->buffer;
            if(($i+$bytesToRead) > $this->end) {
                $bytesToRead = $this->end - $i + 1;
            }
            $data = fread($this->stream, $bytesToRead);
            echo $data;
            flush();
            $i += $bytesToRead;
        }
    }

    /*
    * Function xử lý check dữ liệu video từ client
    * params $vid: Chuỗi đã được mã hoá openssl_encrypt: Đường dẫn thật của file video + Chuỗi số tự động gen (time + random (100000,900000))
    */
    public function actionView($vid = ''){
        $session            = Yii::$app->session;
        if ( !$session->isActive) { $session->open(); }
        if( !empty($vid) ){
            
            $modelVideoTmp = VideoTmp::findOne($vid);
            if( $modelVideoTmp && $modelVideoTmp->status == 0 ){
                $modelVideoTmp->status = 1;
                $modelVideoTmp->save(false);
                $modelCourseLesson = CourseLesson::findOne($modelVideoTmp->course_lesson_id);
                if( $modelCourseLesson ){
                    $link_video = $modelCourseLesson->link_video;
                    $full_path  = $_SERVER['DOCUMENT_ROOT'].$link_video;
                    if(!empty($link_video) && file_exists($full_path)){
                        self::writeLog('video-log-view', 'referral:' . (isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : 'NULL') . ' - IP: ' . $_SERVER['REMOTE_ADDR'] . ' - vid: ' . $vid . ' - link_video : ' . $link_video . ' - sessid: ' . Yii::$app->session->getId());
                        // Another important point here is a session id regeneration
                        // set_time_limit(0);
                        // ini_set('memory_limit', '-1');
                        // ob_clean();
                        // $file           = $full_path;
                        // $file_size      = filesize($file);
                        // $file_pointer   = fopen($file, "rb");
                        // $data           = fread($file_pointer, $file_size);
                        // header("Content-type: video/mp4");
                        // echo $data;
                        // flush();
                        $this->path = $full_path;
                        $this->open();
                        $this->setHeader();
                        $this->stream();
                        $this->end();
                    }else
                        echo "File Does not exists.";
                }else
                    echo "File Does not exists!";
            }
            else{
                self::writeLog('video-log-view-error', 'referral:' . (isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : 'NULL') . ' - IP: ' . $_SERVER['REMOTE_ADDR'] . ' - vid: ' . $vid . ' - sessid: ' . Yii::$app->session->getId());
                echo "File Does not exists!!";
            }
            
        }else
            echo "File Does not exists!!!";
        exit;
    }
    
    public function writeLog($typeLog,$stringlog){
		try{
			$dir =  __DIR__;
			$path = "logs/".$typeLog;
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$timeWrite = date("Y_m_d");
			$fileName = $path."/log.".$timeWrite.".log";
			$fh = fopen($fileName, 'a+') or die("Can't create file");
			fwrite($fh,date('Y-m-d H:i:s',time()).": ". $stringlog."\n");
			fclose($fh);
		}catch(Exception $e){

		}
    } 
    
    public function actionTouch(){
        session_start(); 
        if (Yii::$app->request->isAjax) {
            if( isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) !== false ){
                $length = rand(17,45);
                $token  = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
                $_SESSION['token_ts_video'] = $token;
                $_SESSION['time_ts'] = time();
                return $token;
            }else
                return 'What do you mean?';
        }else{
            return 'What do you mean?';
        }
    }
}