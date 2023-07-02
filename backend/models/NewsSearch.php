<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\News;
use backend\controllers\CommonController;
use yii\db\Expression;

/**
 * BannerSearch represents the model behind the search form about `backend\models\Banner`.
 */
class NewsSearch extends News
{
    public $date_start;
    public $date_end;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['type','tab','title','date_start','category_id','author','date_end','description','content','status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find()->select('A.id, A.image, A.title, A.slug, A.status, A.category_id, A.description, A.viewed, A.date_publish, A.author, A.source, A.user_publish, A.user_update, A.date_pending, A.create_at, A.user_request_approve, A.user_update, A.date_reject, A.user_reject, A.user_approve, A.date_approved, A.reason')->from(News::tableName() . ' A');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 20 ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // if( !CommonController::checkAccess('/news/show') && !CommonController::checkAccess('/news/hide') )
        if( !Yii::$app->user->identity->is_admin && !CommonController::checkRolePermission('view_all_post_of_category') )
            $this->author = Yii::$app->user->identity->id;
        
        $arrCateQuery  = [];    
        $isFilterCate  = false;
        // if( !Yii::$app->user->identity->is_admin ){
            
        //     $listCate  = Yii::$app->user->identity->categoryIds();
        //     if( is_array($this->category_id) && !empty($this->category_id) ){
        //         if( in_array(-1 , $listCate) ){
        //             $arrCateQuery = $this->category_id;
        //         }else{
        //             $listCate = array_intersect($this->category_id, $listCate);
        //             $isFilterCate = true;
        //         }
        //     }
        //     if( !in_array(-1 , $listCate) ){
        //         if( empty($listCate) ){
        //             $this->id = 0;
        //         }else{
        //             $arrCateQuery = $listCate;
        //         }
        //     }
        // }else{
            if( is_array($this->category_id) && !empty($this->category_id) ){
                $arrCateQuery = $this->category_id;
                $isFilterCate = true;
            }
        // }
        
        if( !empty($arrCateQuery) ){
            // $condition_cate = ['or'];
            // foreach($arrCateQuery as $cate_id){
            //     $condition_cate[] = ['like','category_id',";$cate_id;"];
            // }
            
            $query->innerJoin(CategoryNews::tableName() . ' B', 'A.id = B.news_id');
            $user_id_current = Yii::$app->user->identity->id;
            
            if( !$isFilterCate )
                $query->andWhere(['or', ['in', 'B.category_id', $arrCateQuery], ['author' => $user_id_current]]);
            else{
                $str_cate_in = implode(',', $arrCateQuery);
                $query->andWhere('( B.category_id IN (' . $str_cate_in . ') OR (author = ' . $user_id_current . ' and B.category_id IN (' . $str_cate_in . ')) )');
            }
            
            if( count($arrCateQuery) > 1 )
                $query->groupBy(['A.id']);
        }

        if( $this->tab ){
            switch($this->tab){
                case 'all':
                    $query->orderBy(['create_at' => SORT_DESC]);
                    break;
                case 'published':
                    $this->status = News::PUBLISHED;
                    $query->orderBy(['date_publish' => SORT_DESC]);
                    break;
                case 'approved':
                    $this->status = News::APPROVED;
                    $query->orderBy(['date_approved' => SORT_DESC]);
                    break;
                case 'pending':
                    $this->status = News::PENDING;
                    $query->orderBy(['date_pending' => SORT_DESC]);
                    break;
                case 'reject':
                    $this->status = News::UNAPPROVE;
                    $query->orderBy(['date_reject' => SORT_DESC]);
                    break;
                case 'drafts':
                    $this->status = News::DRAFT;
                    $query->orderBy(['create_at' => SORT_DESC]);
                    break;
                default:
                    break;
            }
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'author' => $this->author,
            'type'   => $this->type,
            'is_delete'=>0
        ]);
        if( $this->date_start )
            $query->andFilterWhere(['>=','create_at',$this->date_start]);
        if( $this->date_end )
            $query->andFilterWhere(['<=','create_at',$this->date_end . ' 23:59:59']);
        
        if( trim($this->title) )
            $query->andFilterWhere(['or',['like', 'title', trim($this->title)]]);
        
        return $dataProvider;
    }

    public function searchStaff($params)
    {
        $column_select = ['B.id',new Expression('B.fullname as author_name'), new Expression('COUNT(A.id) as total_post_publish'), new Expression('SUM(A.viewed) as viewed')];
        $isPopup = isset($params['popup']);
        if( $isPopup )
            $column_select = 'A.id, A.image, A.title, A.slug, A.status, A.category_id, A.tag, A.description, A.viewed, A.source_author as source, A.date_publish, A.author, A.user_publish, A.user_update, A.date_pending, A.create_at, A.user_request_approve, A.user_update, A.date_reject, A.user_reject, A.user_approve, A.date_approved, A.reason';
        $query = News::find()->select($column_select)
        ->from(News::tableName() . ' A');
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 20 ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'A.status' => News::PUBLISHED,
            'A.author' => $this->author,
            'A.type'   => $this->type,
            'A.is_delete'=>0
        ]);
        if( $this->date_start )
            $query->andFilterWhere(['>=','A.create_at',$this->date_start]);
        if( $this->date_end )
            $query->andFilterWhere(['<=','A.create_at',$this->date_end . ' 23:59:59']);
        
        if( $isPopup ){
            $query->orderBy('A.create_at DESC');
        }else{
            $query->innerJoin(Employee::tableName() . ' B', 'A.author = B.id');
            $query->groupBy(['B.id']);

            $query->orderBy('SUM(A.id) DESC');
        }

        return $dataProvider;
    }
}
