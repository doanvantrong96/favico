<?php

namespace backend\models;

use Yii;
use backend\models\Employee;
use backend\models\Category;
use backend\models\Tags;
use yii\helpers\ArrayHelper;

class News extends \yii\db\ActiveRecord
{
    CONST HIDE      = 0;
    CONST PUBLISHED = 1;
    CONST DRAFT     = 2;
    public $listCategory;
    public $listTags;
    public $infoAuthor;
    public $relatedNews;
    public $is_edit_post;
    public $tab;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','slug'],'required','message'=>'Nhập {attribute}'],
            [['title', 'slug'], 'string', 'max' => 255, 'tooLong' => '{attribute} tối đa {max} ký tự'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => '{attribute} không chứa dấu tiếng việt, dấu cách và ký tự đặc biệt như:`!~@#$%^...'],
            [['slug'], 'unique', 'message' => '{attribute} đã tồn tại'],
            [['description','seo_description'], 'string', 'max' => 300, 'tooLong' => '{attribute} tối đa {max} ký tự'],
            [['seo_title'], 'string', 'max' => 200, 'tooLong' => '{attribute} tối đa {max} ký tự'],
            [['slug'], 'unique', 'targetAttribute' => ['slug'], 'message' => '{attribute} đã tồn tại.'],
            [['is_edit_post','date_schedule_publish','reason','tab','seo_title','seo_description','slug','image','description','content','category_id','tag','related_news','source','date_publish','status'],'safe']
        ];
    }

    public function beforeSave($insert){
       
        if( is_array($this->category_id) ){
            // $arrCateId = array_keys(Yii::$app->params['category_news']);
            $this->category_id = ';' . implode(';',$this->category_id) . ';';
        }
        if( is_array($this->related_news) ){
            $this->related_news = ';' . implode(';',$this->related_news) . ';';
        }
        
        if( !$this->isNewRecord ){
            if( $this->is_edit_post )
                $this->user_update = Yii::$app->user->identity->id;
        }else{
            $this->author = Yii::$app->user->identity->id;
            $this->source = Yii::$app->user->identity->fullname;
        }

        if( $this->is_edit_post || $this->isNewRecord )
            $this->last_update = date('Y-m-d H:i:s');

        //Bài viết đã duyệt -> Không lưu slug mới nếu thay đổi
        if( !$this->isNewRecord && in_array($this->status, [self::PUBLISHED]) ){
            unset($this->slug);
        }
        if( $this->date_schedule_publish ){
            $this->date_schedule_publish = date('Y-m-d H:i:s', strtotime($this->date_schedule_publish));
        }
        // if( isset(Yii::$app->params['media_folder']) && isset(Yii::$app->params['domain_media']) ){
        //     $media_folder   = Yii::$app->params['media_folder'];
        //     $domain_media   = Yii::$app->params['domain_media'];
        //     $this->content  = str_replace('src="/media','src="' . $domain_media, $this->content);
        // }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        
        if( $insert || isset($changedAttributes['category_id']) ){
            $arrCateId      = !empty($this->category_id) ? array_filter(explode(';',$this->category_id)) : [];
            CategoryNews::saveData($this->id, $arrCateId);
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Tiêu đề bài viết',
            'description'    => 'Mô tả ngắn gọn',
            'seo_title' => 'Tiêu đề SEO',
            'seo_description' => 'Mô tả SEO',
            'category_id' => 'Chuyên mục',
            'content'   => 'Nội dung',
            'image' => 'Ảnh đại diện',
            'status' => 'Trạng thái',
            'create_at' => 'Ngày đăng',
            'related_news' => 'Bài viết liên quan',
            'date_publish' => 'Ngày xuất bản',
            'reason' => 'Lý do từ chối'
        ];
    }

    public function isOwner($skipCheckAuthor = false, $listCateOfUser = []) {
        if( !Yii::$app->user->identity->is_admin ){
            if( !$skipCheckAuthor && $this->author == Yii::$app->user->identity->id )
                return true;
            // else{
            //     if( empty($listCateOfUser) )
            //         $listCateOfUser = Yii::$app->user->identity->categoryIds();
            //     $listCateNews   = !is_array($this->category_id) ? array_filter(explode(';',$this->category_id)) : $this->category_id;
            //     if( in_array( -1 , $listCateOfUser) || count( array_intersect($listCateOfUser, $listCateNews) ) > 0 )
            //         return true;
            //     else
            //         return false;
            // }
        }else{
            return true;
        }
    }

    public function getCategoryName($getOnlyName = true){
        $listName = [];
        if( !empty($this->category_id) ){
            $category_selected   = array_values(array_filter(explode(';', $this->category_id)));
            if( !empty($category_selected) ){
                $listName = [];
                foreach( $category_selected as $cate_id){
                    if( isset(Yii::$app->params['category_news'][$cate_id]) )
                        $listName[] = Yii::$app->params['category_news'][$cate_id];
                }
                // $listName      = ArrayHelper::map(Category::find()->where(['status'=>1,'is_delete'=>0])->andWhere(['in', 'id', $category_selected ])->all(), 'id', 'name');
                // if( $getOnlyName )
                //     $listName  = array_values($listName);
            }
        }
        return $listName;
    }

    public static function updateHot($arrIds = [], $arrPosition = []){
        $arrUpdate = ['is_hot' => 1];
        
        $arrUpdateReset = ['hot_pos' => 999];
        foreach($arrUpdate as $key=>$value)
            $arrUpdateReset[$key] = 0;
        
        self::updateAll($arrUpdateReset, 'id > 0 and is_hot = 1');

        if( !empty($arrIds) ){
            self::updateAll($arrUpdate, ['id' => $arrIds]);
            if( !empty($arrPosition) ){
                foreach($arrPosition as $id=>$pos){
                    $pos = (int)$pos;
                    self::updateAll(['hot_pos' => $pos], ['id' => $id]);
                }
            }
        }
    }

    public static function getNewsHot($getObject = false){
        $condition = ['is_hot' => 1, 'status' => 1, 'is_delete' => 0];
        $result    = self::find()->where($condition)->orderBy(['hot_pos' => SORT_ASC])->all();
        if( $getObject )
            return $result;
        return \yii\helpers\ArrayHelper::map($result, 'id', 'title');
    }

    public static function saveTotalView($id){
        $query = 'UPDATE ' . self::tableName() . ' set viewed = viewed + 1 where id = :id';
        Yii::$app->db->CreateCommand($query, [':id' => $id])->execute();
    }
}
