<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MedicalSearch represents the model behind the search form about `backend\models\Medical`.
 */
class GiftCodeSearch extends GiftCode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['code','type_price','course_id'], 'safe'],
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
        $query = GiftCode::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>false
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
            'type_price' => $this->type_price,
        ]);
        
        if( !$this->course_id && isset($_GET['course_id']) && !empty($_GET['course_id']) ){
            $query->andFilterWhere(['or',
                ['is','course_id', NULL],
                ['like','course_id',';' . $_GET['course_id'] . ';']
            ]);
        }else if($this->course_id){
            $query->andFilterWhere(['like','course_id',';' . $_GET['course_id'] . ';']);
        }
        $query->andFilterWhere(['like', 'code', $this->code])->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
