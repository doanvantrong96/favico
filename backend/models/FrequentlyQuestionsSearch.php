<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FrequentlyQuestionsSearch represents the model behind the search form about `backend\models\FrequentlyQuestions`.
 */
class FrequentlyQuestionsSearch extends FrequentlyQuestions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','status','group_id'], 'integer'],
            [['question'],'safe']
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
        $query = FrequentlyQuestions::find();

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
            'status' => $this->status,
            'group_id' => $this->group_id,
            'is_delete' => 0
        ]);
        
        $query->andFilterWhere(['like', 'question', $this->question]);
        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
