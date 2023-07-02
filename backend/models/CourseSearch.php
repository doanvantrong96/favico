<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Course;

/**
 * CourseSearch represents the model behind the search form about `backend\models\Course`.
 */
class CourseSearch extends Course
{
    public $date_start;
    public $date_end;
    public $is_sell;
    public $is_trending;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lecturer_id'], 'integer'],
            [['is_sell','date_start','date_end','name', 'avatar', 'category_id', 'create_date', 'is_coming','status'], 'safe'],
            [['price'], 'number'],
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
        $query = Course::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
            'pagination' => [ 'pageSize' => 15 ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lecturer_id' => $this->lecturer_id,
            'create_date' => $this->create_date,
            'price' => $this->price,
            'status' => $this->status,
            'is_coming' => $this->is_coming,
            'is_delete' => 0
        ]);
        if( $this->is_sell ){
            $query->andWhere(['>', 'price', 0]);
            $query->andWhere(['status' => 1]);
        }
        
        if( $this->category_id ){
            $query->andWhere(['like','category_id', ';' . $this->category_id . ';']);
        }
        if( !empty($this->date_start) ){
            $query->andFilterWhere(['>=', 'create_date', $this->date_start]);
            if( empty($this->date_end) )
                $this->date_end = $this->date_start;
        }
        if( !empty($this->date_end) )
            $query->andFilterWhere(['<=', 'create_date', $this->date_end . ' 23:59:59']);
        $query->andFilterWhere(['like', 'name', $this->name]);

        if( $this->is_trending ){
            $query->andWhere(['status' => 1]);
            $query->andWhere(['>','total_view', 0]);
            $query->orderBy(['total_view' => SORT_DESC]);
            $dataProvider->setTotalCount(10);
            $dataProvider->pagination->pageSize = 10;
        }else{
            $query->orderBy(['id' => SORT_DESC]);
        }

        return $dataProvider;
    }

    public function searchSale($params)
    {
        $query = Course::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
            'pagination' => [ 'pageSize' => 15 ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_delete' => 0
        ]);

        $query->andWhere(['>', 'price', 0]);
        $query->andWhere(['status' => 1]);
        
        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
