<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommunityStorySearch represents the model behind the search form about `backend\models\CommunityStory`.
 */
class CommunityStorySearch extends CommunityStory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','status','is_active'], 'integer'],
            [['content'],'safe']
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
        $query = CommunityStory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['position']],
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
            'is_active' => $this->is_active,
            'is_delete' => 0
        ]);
        
        $query->andFilterWhere(['or', ['like', 'fullname', $this->content], ['like', 'email', $this->content], ['like', 'content', $this->content]]);
        if( !isset($params['sort']) )
            $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
