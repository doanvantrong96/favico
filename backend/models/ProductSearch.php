<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['status'], 'number'],
            [['is_most','tag_id','title','category_id','status'], 'safe'],
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
        $query = Product::find();

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
            'create_date' => $this->create_date,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'is_most' => $this->is_most,
        ]);

        if( trim($this->title) )
            $query->andFilterWhere(['or',['like', 'title', trim($this->title)]]);
        
        if( is_array($this->tag_id) && !empty($this->tag_id) ){
            $arrTagId = $this->tag_id;
            $condition_cate = ['or'];
            foreach($arrTagId as $cate_id){
                $condition_cate[] = ['like','tag_id',";$cate_id;"];
            }
            $query->andWhere($condition_cate);
        }
        
        $query->orderBy(['id' => SORT_DESC]);
        return $dataProvider;
    }
}
