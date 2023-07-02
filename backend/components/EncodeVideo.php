<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\BaseObject;
use yii\queue\Job;
use backend\models\CourseLesson;
use backend\models\Course;

class EncodeVideo extends BaseObject implements Job
{
    public $id;//Mã bài học
    public $path_org_file;//Đường dẫn gốc video mp4
    public $target_dir;//Đường dẫn xử lý encode

    public function execute($queue){
        echo '-------------Start Encode Video-------------' . PHP_EOL;
        $time_start     = microtime(true);
        $target_dir     = $this->target_dir;
        $path_org_file  = $target_dir . $this->path_org_file;
        $path_save      = Yii::$app->params['path_save_encode'];
        $path_ffmpeg    = Yii::$app->params['path_ffmpeg'];
        $cmd_info       = 'ffprobe -v error -select_streams v:0 -show_entries stream=duration,width,height,bit_rate -of default=noprint_wrappers=1 ';
        $cmd_info_run   = $path_ffmpeg . $cmd_info . $path_org_file;

        // $cmd_encode     = 'ffmpeg -i "path_video" -vf "scale=scale_video" -c:v libx264 -preset medium -profile:v main -level 3.1 -x264opts "bitrate=2400:vbv-maxrate=2400:vbv-bufsize=2400:min-keyint=30:keyint=60:scenecut=0" -pix_fmt yuv420p -f hls -hls_time 20 -hls_list_size 0 path_save_m3u8/video.m3u8';
        $cmd_encode     = 'ffmpeg -i path_video -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls path_save_m3u8/video.m3u8';
        $cmd_encode_run = $path_ffmpeg . $cmd_encode;

        echo "CMD INFO:" . $cmd_info_run . PHP_EOL;

        $infoFile       = shell_exec($cmd_info_run);
        $infoFile       = explode("\n", $infoFile);
        $width_video    = 0;
        $height_video   = 0;
        $duration_video = 0;
        if (count($infoFile) >= 2) {
            foreach ($infoFile as $line) {
                if (strpos($line, 'width=') !== false) {
                    $width_video = (int)str_replace('width=', '', $line);
                } elseif (strpos($line, 'height=') !== false) {
                    $height_video = (int)str_replace('height=', '', $line);
                }
                elseif (strpos($line, 'duration=') !== false) {
                    $duration_video = round(str_replace('duration=', '', $line));
                }
            }
        }
        if( $height_video > 0 && $width_video > 0 ){
            echo 'Width/Height video: '. $width_video . '-' . $height_video . PHP_EOL;
            $arrPathVideo   = explode('/', $path_org_file);
            unset($arrPathVideo[count($arrPathVideo) - 1]);
            $path_save_m3u8 = implode('/', $arrPathVideo);
            $scale_video    = $width_video.':' . $height_video;
            $cmd_encode_run = str_replace(['path_video', 'scale_video', 'path_save_m3u8'],[$path_org_file, $scale_video, $path_save_m3u8], $cmd_encode_run);
            
            echo "CMD ENCODE:" . $cmd_encode_run . PHP_EOL;
            $info_encode    = shell_exec($cmd_encode_run);
            $id             = $this->id;
            $modelLesson    = CourseLesson::findOne($id);
            if( $modelLesson ){
                $modelLesson->duration = $duration_video;
                $modelLesson->link_video = "/uploads/video-lesson/$id/video.m3u8";
                $modelLesson->save(false);

                Course::updateTotalDuration($modelLesson->course_id);
                unlink($path_org_file);
            }

            $time_end     = microtime(true);
            echo '-------------End Encode Video-------------' . PHP_EOL;

            echo 'Total time endcode: ' . ($time_end - $time_start) . PHP_EOL;
        }
        
    }
}
