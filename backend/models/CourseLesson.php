<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course_lesson".
 *
 * @property integer $id
 * @property string $name
 * @property integer $course_section_id
 * @property string $create_date
 * @property string $link_video
 * @property integer $is_prevew
 */
class CourseLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','description','avatar','path_file'],'required','message' => '{attribute} không được trống'],
            [['course_id'],'required','message' => 'Chọn {attribute}'],
            [['course_id','sort'], 'integer'],
            [['create_date','path_file', 'document'], 'safe'],
            [['link_video','path_file'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã bài học',
            'name' => 'Tên bài học',
            'create_date' => 'Ngày thêm',
            'link_video' => 'Video bài học',
            'avatar'    => 'Ảnh',
            'path_file' => 'Video bài học',
            'course_id' => 'Khoá học',
            'duration' => 'Thời lượng video',
            'sort' => 'Thứ tự bài học',
            'description' => 'Nội dung bài học',
            'total_answer_correct_need' => 'Số câu trả lời đúng'
        ];
    }

    public static function getListLesson($course_id){
        return self::find()->where(['course_id' => $course_id])->orderBy(['sort'=>SORT_ASC])->all();
    }

    public static function updatePositionLesson($course_id){
        $listLesson = self::getListLesson($course_id);
        if( !empty($listLesson) ){
            foreach($listLesson as $stt=>$row){
                $row->sort = $stt;
                $row->save(false);
            }
        }
    }
}
