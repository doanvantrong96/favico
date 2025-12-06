<?php
namespace common\components\json;
use Yii;
use Exception;

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

    public static function renderDaiVan($hoTen, $gioiTinh, $namSinh, $ngaySinhDuong, $gioSinh, $noiSinh)
    {
        $sql = "SELECT * FROM settings";
        $results =  Yii::$app->db->createCommand($sql)->queryAll();
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        // Load prompt templates
        $systemPrompt = file_get_contents(Yii::getAlias('@common/data/bat_tu_system.txt'));
        $userPrompt = file_get_contents(Yii::getAlias('@common/data/bat_tu_user.txt'));
        
        // Replace placeholders in user prompt
        $userPrompt = str_replace([
            '{hoTen}', '{gioiTinh}', '{namSinh}', '{ngaySinhDuong}', '{gioSinh}', '{noiSinh}'
        ], [
            $hoTen, $gioiTinh, $namSinh, $ngaySinhDuong, $gioSinh, $noiSinh
        ], $userPrompt);
        
        // Prepare OpenAI API request
        $requestData = [
            'model' => $settings['openai_model'],
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt]
            ],
            'max_tokens' => (int)$settings['openai_max_tokens'],
            'temperature' => (float)$settings['openai_temperature']
        ];
        
        // Call OpenAI API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $settings['openai_api_key']
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($curlError) {
            throw new Exception('CURL Error: ' . $curlError);
        }
        
        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = $errorData['error']['message'] ?? 'Unknown API error';
            throw new Exception("OpenAI API Error ($httpCode): $errorMessage");
        }
        
        $result = json_decode($response, true);
        
        if (!isset($result['choices'][0]['message']['content'])) {
            throw new Exception('Invalid response format from OpenAI API');
        }
        
        $content = $result['choices'][0]['message']['content'];
        $content = json_decode($content,true);
        $content = $content['nhanDinhDaiVan']['content'];
        // $tokensUsed = $result['usage']['total_tokens'] ?? 0;
        
        // Calculate cost based on model
        // $cost = JsonHelper::calculateCost($settings['openai_model'], $tokensUsed);
        
        
        // $arr_return = [
        //     'content' => $content,
        //     'tokens' => $tokensUsed,
        //     'cost' => $cost
        // ];
        return $content;
    }

    public static function  calculateCost($model, $tokens) {
        // Chi phí trung bình (input + output) per 1K tokens
        $costs = [
            // Models mới nhất 2024-2025
            'gpt-4o' => 0.01,              // ($0.005 input + $0.015 output) / 2
            'gpt-4o-mini' => 0.0004,       // ($0.00015 input + $0.0006 output) / 2
            'o1-preview' => 0.0375,        // ($0.015 input + $0.06 output) / 2
            'o1-mini' => 0.0075,           // ($0.003 input + $0.012 output) / 2
            
            // Models cũ
            'gpt-4-turbo' => 0.02,         // ($0.01 input + $0.03 output) / 2
            'gpt-4' => 0.045,              // ($0.03 input + $0.06 output) / 2
            'gpt-3.5-turbo' => 0.00175     // ($0.0015 input + $0.002 output) / 2
        ];
        
        $costPer1K = $costs[$model] ?? 0.01; // Default to gpt-4o cost
        return ($tokens / 1000) * $costPer1K;
    }

    public static function renderProduct($dungthan, $vanhan)
    {
        $jsonUrl = "https://ngonbo.re/8tlm/data/products.json";
        $jsonData = file_get_contents($jsonUrl);
        $allProducts = json_decode($jsonData, true);

        if (!$allProducts || !is_array($allProducts)) {
            throw new Exception("Không đọc được file JSON sản phẩm");
        }

        $filtered = [];
        foreach ($allProducts as $product) {

            $matchHanh = false;
            $matchNienMenh = false;

            // ==== CHECK HÀNH ====
            if (!empty($product['hanh'])) {

                if (in_array('all', $product['hanh'])) {
                    $matchHanh = true;

                } elseif ($dungThan && $dungThan === $product['hanh']) {
                    // foreach ($dungThan as $dt) {
                    //     if (in_array($dt, $product['hanh'])) {
                            $matchHanh = true;
                            break;
                    //     }
                    // }
                }
            }

            // ==== CHECK NIÊN MỆNH ====
            $nienMenh = $product['nienMenh'] ?? ['all'];

            if (in_array('all', $nienMenh)) {
                $matchNienMenh = true;

            } elseif (!empty($vanHan)) {

                $userHan = [];

                if (!empty($vanHan['details']['tamTai'])) {
                    $userHan[] = 'tam_tai';
                }

                if (!empty($vanHan['details']['thaiTue'])) {
                    $userHan[] = 'thai_tue';
                }

                if (!empty($vanHan['details']['cuuDieu']) && 
                    ($vanHan['details']['cuuDieu']['type'] ?? '') === 'hung') {
                    $userHan[] = 'cuu_dieu_hung';
                }

                if (empty($userHan)) {
                    $matchNienMenh = in_array('binh_thuong', $nienMenh);
                } else {
                    foreach ($userHan as $han) {
                        if (in_array($han, $nienMenh)) {
                            $matchNienMenh = true;
                            break;
                        }
                    }
                }
            }

            // ==== MATCH FINAL ====
            if ($matchHanh || $matchNienMenh) {
                $filtered[] = $product;
            }
        }
        $products = $filtered[2] ?? [];
        $unique = [];
        if(!empty($products))
        {
            foreach ($products as $p) {
                $unique[$p['id']] = $p;
            }
            $unique = array_values($unique);
            usort($unique, function($a, $b) {
                return ($b['priority'] ?? 3) <=> ($a['priority'] ?? 3);
            });
        }
        
        return $unique;

    }
}
