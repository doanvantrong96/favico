<?php

namespace backend\models;
use Yii;
date_default_timezone_set("Asia/Bangkok");
class Util extends \yii\base\Model
{
	private function sendPostoOneSignnal($fields){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic MzUzNWUwMWEtNjM5Mi00NzRiLTliNDctNjhjMTQ2ZTkyZTkz'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
	public static function sendOneSignal($custid,$title,$content,$evt='no_event',$data = []){
		if(empty($data)){
			$data = ['evt'=>$evt];
		}
		else
			$data['evt'] = $evt;
		$fields = array(
            'app_id' => "9b72c222-832e-4323-917d-d4e81ab01d57",
            'contents' =>  array(
                "en" =>  $content
            ),

            'tags'=> array(
                array(
                    'key' => 'cid',
                    'relation' =>'=',
                    'value'=> $custid
                )
            ),
            'headings'=> array(
                'en' => $title
            ),
            "data"  => $data
            // 'url'=>$url,
            // 'send_after'=>$obj['notischetime']." GMT+0700"
        );

        $response = self::sendPostoOneSignnal(json_encode($fields));
	}

	public function sendNotify($cartid,$custid){
		try{

			$cartstatus = 2;
			$cartstatusdesc = 'Completed';
			//$cartid = $arr['cartid'];
			$text = 'Thank you! Have a good time.';
			$evt = 'updatecartstatus';

			// gui cho customer qua gcm
			// $post_data['content_available'] = true;
			// $post_data['data'] = array (
			//   'evt' => 'updatecartstatus',
			// 	'carid' => $cartid,
			// 	'text' => $text,
			// 	'status' => $cartstatus,
			// 	'statusdes' => $cartstatusdesc,
			// 	'custid' => $custid
			// );

			// //send OneSignal
			// $api_url1 = "http://mycafe.co:3000/sendOnesignal";
			// $data_string1 = json_encode($post_data['data']);
			// $payload1 = $this->httpPostGCM($api_url1, $data_string1);

			// $returndata = array(
			// 	'post_data' => $post_data
			// );
			return $this->sendOnesignal($cartid,$custid,$cartstatusdesc,$text,$cartstatus,$evt);

		} catch(PDOException $e){
			echo 'execute failed: ' . $e->getMessage();
			return array ("error"=>"PDOException");
		}
	}


	public function httpPostGCM($url, $data_string)
	{
		$ch = curl_init($url);
		$data = json_decode($data_string);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_CAINFO, "cacert.pem");
		//curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json',
		  'Authorization: key=AIzaSyBwp4zEWL2-H_CZoTuobIZBuW3_d6kGneE',
		  'Content-Length: ' . strlen($data_string))
		);
		$result = curl_exec($ch);

		$err = "";
		if (curl_errno($ch)) {
		   print curl_error($ch);
		   $err = curl_error($ch);
		}

		curl_close($ch);
		// $obj = array(
		// 	"result" => $result,
		// 	"err" => $err
		// );
		$obj = json_decode($result);
		return $obj;
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


}