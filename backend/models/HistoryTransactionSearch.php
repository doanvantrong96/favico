<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HistoryTransaction;

/**
 * HistoryTransactionSearch represents the model behind the search form about `backend\models\HistoryTransaction`.
 */
class HistoryTransactionSearch extends HistoryTransaction
{
    public $input_search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'user_id', 'status'], 'integer'],
            [['create_date', 'note','input_search'], 'safe'],
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
        $query = HistoryTransaction::find();

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
            'course_id' => $this->course_id,
            'user_id' => $this->user_id,
            'create_date' => $this->create_date,
            'price' => $this->price,
            'status' => $this->status,
        ]);
        if( $this->input_search != '' ){
            
        }
        $query->andFilterWhere(['like', 'note', $this->note])->orderBy(['id' => SORT_DESC]);;

        return $dataProvider;
    }
}
