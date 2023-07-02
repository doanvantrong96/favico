<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property integer $coach_id
 * @property string $create_date
 * @property integer $category_id
 * @property string $category_name
 * @property string $description
 * @property integer $total_learn
 * @property integer $total_hours_learn
 * @property integer $total_lessons
 * @property string $level
 * @property double $price
 * @property double $promotional_price
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lecturer_id', 'category_id', 'description', 'total_todo_question', 'questions_per_lesson'], 'required', 'message' => '{attribute} không được trống'],
            [['lecturer_id'], 'integer'],
            [['create_date','total_answer_correct_need','certificate','promotional_price','price','is_coming','time_coming','avatar', 'trailer'], 'safe'],
            [['description'], 'string'],
            [['status'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['avatar','certificate'], 'string', 'max' => 300],
            [['promotional_price'],'validatePromotionPrice'],
            [['total_todo_question'],'validateTotalTodoQuestion'],
            [['questions_per_lesson'],'validateQuestionPerLesson'],
        ];
    }

    public function validateTotalTodoQuestion($attribute){
        if( $this->$attribute <= 0 )
            $this->addError($attribute, 'Tổng câu hỏi cần làm bài tập lớn phải lớn hơn 0');
    }

    public function validateQuestionPerLesson($attribute){
        if( $this->$attribute > 0 && $this->total_todo_question > 0 && $this->$attribute >= $this->total_todo_question )
            $this->addError($attribute, 'Số câu hỏi lấy ở mỗi bài tập phải nhỏ hơn Tổng câu hỏi cần làm bài tập lớn');
        else if( !empty($this->$attribute) && $this->$attribute <= 0 ){
            $this->addError($attribute, 'Số câu hỏi lấy ở mỗi bài tập phải là số');
        }
    }

    public function validatePromotionPrice($attribute){
        $price              = $this->price ? str_replace([',','.'],'',trim($this->price)) : 0;
        $promotional_price  = $this->promotional_price ? str_replace([',','.'],'',trim($this->promotional_price)) : 0;
        if( $price > 0 && $promotional_price > 0 && $promotional_price > $price )
            $this->addError('promotional_price', 'Giá khuyến mại không hợp lệ');
        
    }

    public function beforeSave($insert){
        $this->price       = $this->price ? str_replace([',','.'],'',trim($this->price)) : 0;
        $this->promotional_price       = $this->promotional_price ? str_replace([',','.'],'',trim($this->promotional_price)) : 0;
        
        if( !empty($this->category_id) && is_array($this->category_id) )
            $this->category_id = ';' . implode(';', $this->category_id) . ';';
        if( $this->time_coming && strpos($this->time_coming, '/') !== false ){
            $time_coming = explode('/', $this->time_coming);
            $this->time_coming = $time_coming[2] . '-' . $time_coming[1] . '-' . $time_coming[0];
        }
        // $this->total_answer_correct_need = $this->total_todo_question;
        return parent::beforeSave($insert);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã khoá học',
            'name' => 'Tên khoá học',
            'avatar' => 'Ảnh đại diện',
            'lecturer_id' => 'Giảng viên',
            'create_date' => 'Ngày tạo',
            'category_id' => 'Danh mục',
            'description' => 'Mô tả',
            'total_lessons' => 'Số bài học',
            'trailer' => 'Video Trailer',
            'price' => 'Giá',
            'status' => 'Trạng thái',
            'is_coming' => 'Sắp diễn ra',
            'time_coming' => 'Thời gian diễn ra',
            'certificate' => 'Phôi ảnh chứng chỉ',
            'questions_per_lesson' => 'Số câu hỏi lấy ở mỗi bài tập',
            'total_todo_question'  => 'Tổng câu hỏi cần làm bài tập lớn'
        ];
    }

    public static function updateTotalLesson($id){
        $total_lessons = CourseLesson::find()->where(['course_id' => $id])->count();
        self::updateAll(['total_lessons' => $total_lessons], ['id' => $id]);
    }

    public static function updateTotalDuration($id){
        $total_duration = Yii::$app->db->CreateCommand('SELECT SUM(duration) FROM course_lesson WHERE course_id = :course_id', [':course_id' => $id])->queryScalar();
        self::updateAll(['total_duration' => $total_duration], ['id' => $id]);
    }

    public static function updateHot($type = 1, $arrIds = [], $arrPosition = []){
        $arrUpdate = [];
        $flagUpdateHotPos = false;
        if( $type == 1 )//Khoá học nổi bật (Big)
            $arrUpdate = ['is_hot_big' => 1];
        else if( $type == 2 ){//Khoá học nổi bật (danh sách)
            $arrUpdate = ['is_hot' => 1];
            $flagUpdateHotPos = true;
        }
        else if( $type == 3 )//Khoá học sắp diễn ra
            $arrUpdate = ['is_coming' => 1];

        $arrUpdateReset = [];
        $condition_reset= [];
        foreach($arrUpdate as $key=>$value){
            $condition_reset[] = "$key = $value"; 
            $arrUpdateReset[$key] = 0;
        }

        if( $flagUpdateHotPos ){
            self::updateAll(['hot_pos' => 999], 'id > 0 and ' . implode(' and ', $condition_reset));
        }
        
        self::updateAll($arrUpdateReset, 'id > 0 and ' . implode(' and ', $condition_reset));

        if( !empty($arrIds) ){
            self::updateAll($arrUpdate, ['id' => $arrIds]);
            if( $flagUpdateHotPos && !empty($arrPosition) ){
                foreach($arrPosition as $id=>$pos){
                    $pos = (int)$pos;
                    self::updateAll(['hot_pos' => $pos], ['id' => $id]);
                }
            }
        }
    }

    public static function getHotConfig($type = 1, $getObject = false){
        $condition = [];
        if( $type == 1 )//Khoá học nổi bật (Big)
            $condition = ['is_hot_big' => 1];
        else if( $type == 2 )//Khoá học nổi bật (danh sách)
            $condition = ['is_hot' => 1];
        else if( $type == 3 )//Khoá học sắp diễn ra
            $condition = ['is_coming' => 1];
            
        $condition['status'] = 1;
        $condition['is_delete'] = 0;
        
        $query = self::find()->where($condition);
        if( $type == 2 ){
            $query->orderBy(['hot_pos' => SORT_ASC]);
        }
        if( $getObject )
            return $query->all();
        return \yii\helpers\ArrayHelper::map($query->all(), 'id', 'name');
    }

    public static function saveTotalView($id){
        $query = 'UPDATE ' . self::tableName() . ' set total_view = total_view + 1 where id = :id';
        Yii::$app->db->CreateCommand($query, [':id' => $id])->execute();
    }

    public function getDataRegisterAndStudyCourse($type = null){
        $totalRegister  = 0;
        $totalStudy     = 0;
        if( $type == 1 || !$type ){
            $query_register = '
                SELECT count(A.id) as total FROM order_cart A
                INNER JOIN order_cart_product B ON A.id = B.order_cart_id
                WHERE B.course_id = :course_id and A.status IN (0, 1);
            ';

            $totalRegister = Yii::$app->db->CreateCommand($query_register, [':course_id' => $this->id])->queryScalar();
        }
        if( $type == 2 || !$type ){
            $query_study = '
                SELECT count(A.id) as total FROM order_cart A
                INNER JOIN order_cart_product B ON A.id = B.order_cart_id
                WHERE B.course_id = :course_id and A.status = 1;
            ';

            $totalStudy = Yii::$app->db->CreateCommand($query_study, [':course_id' => $this->id])->queryScalar();
        }
        return [
            'totalRegister' => $totalRegister,
            'totalStudy'    => $totalStudy,
        ];

    }

    public function getAllLessonOfCourse(){
        return CourseLesson::find()->where(['course_id' => $this->id])->all();
    }
}
