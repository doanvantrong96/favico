<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CategoryTags;

/**
 * CategoryTagsSearch represents the model behind the search form about `backend\models\CategoryTags`.
 */
class CategoryTagsSearch extends CategoryTags
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'user_create'], 'integer'],
            [['name', 'create_date', 'slug', 'except', 'title_seo'], 'safe'],
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
        $query = CategoryTags::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
            'pagination' => [ 'pageSize' => 15 ]
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
            'type' => $this->type,
            'create_date' => $this->create_date,
            'user_create' => $this->user_create,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'except', $this->except])
            ->andFilterWhere(['like', 'title_seo', $this->title_seo]);
        $query->andWhere(['is_delete' => 0])->orderBy(['id' => SORT_DESC]);
        return $dataProvider;
    }
}
