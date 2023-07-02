<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course_section".
 *
 * @property integer $id
 * @property string $name
 * @property string $create_date
 * @property integer $course_id
 */
class Customer extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const BANNED = 0;
    const LOCKED = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date'], 'safe'],
            [['fullname'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Họ tên',
            'create_date' => 'Ngày đăng ký',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'fb_id' => 'ID Facebook',
            'gg_id' => 'ID Google',
        ];
    }

    public function getCourseBuy($user_id){
        $sql = '
            SELECT C.name,A.percent_complete,A.course_id,A.id FROM user_course A
            INNER JOIN users B ON A.user_id = B.id
            INNER JOIN course C ON C.id = A.course_id
            WHERE B.id = ' . $user_id . '
        ';
        $data   = '';
        $result =  Yii::$app->db->CreateCommand($sql)->queryAll();
        if( !empty($result) ){
            foreach($result as $row){
                // $data[] = '<a href="/course/view?id=' . $row['course_id'] . '" target="_blank">' . $row['name'] . ' (' . $row['percent_complete'] . '% hoàn thành)</a>';
                $data .= ' <li class="select2-search-choice"><a href="/course/view?id=' . $row['course_id'] . '" target="_blank">' . $row['name'] . '</a>'.($row['type'] == 1 ? '<a href="/user-course/delete?id='.$row['id'].'&cust_id='.$user_id.'" class="select2-search-choice-close" tabindex="-1"></a>':'').'</li>';
            }
        }
        // var_dump($data);die;
        if( $data != ''){

                $text = '<div class="select2-container-multi"><ul class="select2-choices">'.$data.'</ul></div>';
        }else{
            $text = '---';
        }
        return $text;
    }
}
