<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customer;

/**
 * CoachSectionSearch represents the model behind the search form about `backend\models\CoachSection`.
 */
class CustomerSearch extends Customer
{
    public $date_start;
    public $date_end;
    public $date_start_banned;
    public $date_end_banned;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fullname','date_start_banned', 'date_end_banned','date_start','status','date_end','email','phone', 'create_date'], 'safe'],
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
        $query = Customer::find();

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
        ]);
        if( !empty($this->status) && is_array($this->status) ){
            $query->andWhere(['in', 'status', $this->status]);
        }

        if( !empty($this->date_start) ){
            $query->andFilterWhere(['>=', 'create_date', $this->date_start]);
            if( empty($this->date_end) )
                $this->date_end = $this->date_start;
        }
        if( !empty($this->date_end) )
            $query->andFilterWhere(['<=', 'create_date', $this->date_end . ' 23:59:59']);
        $query->andFilterWhere(['or',['like', 'fullname', $this->fullname],['like', 'phone', $this->fullname],['like', 'email', $this->fullname]])
        ->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
