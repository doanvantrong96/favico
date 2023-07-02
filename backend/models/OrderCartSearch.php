<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class OrderCartSearch extends OrderCart
{
    public $date_start;
    public $date_end;
    public $fullname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fullname','user_id', 'type','status','date_start','date_end','affliate_id', 'create_date'], 'safe'],
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
        $query = OrderCart::find();
        
        $query->select(['order_cart.*', new Expression('group_concat(order_cart_product.course_id,"#",order_cart_product.price,"#", order_cart_product.price_discount) as list_course')]);
        $query->innerJoin('order_cart_product', 'order_cart.id = order_cart_product.order_cart_id');
        $query->innerJoin('users', 'order_cart.user_id = users.id');

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

        $query->groupBy('order_cart.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'order_cart.id' => $this->id,
            'order_cart.status' => $this->status,
            'order_cart.type' => $this->type,
            'order_cart.create_date' => $this->create_date,
            'order_cart.user_id' => $this->user_id,
        ]);

        if( $this->affliate_id > 0 || is_array($this->affliate_id) ){
            if( is_array($this->affliate_id) && !empty($this->affliate_id) ){
                $query->andWhere(['in', 'order_cart.affliate_id', $this->affliate_id]);
            }else if( empty($this->affliate_id) && Yii::$app->user->identity->account_type == Employee::TYPE_SALE_ADMIN ){
                $query->andWhere(['order_cart.id' => 0]);
            }else if($this->affliate_id > 0){
                $query->andWhere(['order_cart.affliate_id' => $this->affliate_id]);
            }
        }

        if( !empty($this->date_start) ){
            $query->andFilterWhere(['>=', 'order_cart.create_date', $this->date_start]);
            if( empty($this->date_end) )
                $this->date_end = $this->date_start;
        }
        if( !empty($this->date_end) )
            $query->andFilterWhere(['<=', 'order_cart.create_date', $this->date_end . ' 23:59:59']);

        $query->andFilterWhere(['or',['like', 'users.fullname', $this->fullname],['like', 'users.phone', $this->fullname],['like', 'users.email', $this->fullname]])
        ->orderBy(['order_cart.id' => SORT_DESC]);

        return $dataProvider;
    }


    public function searchSaleAdmin($params)
    {
        $query = OrderCart::find();
        
        $query->select(['order_cart.affliate_id', new Expression('SUM(order_cart.price) as price'), new Expression('employee.commission_percentage as commission_percentage_of_sale'), new Expression('employee.fullname as sale_name')]);
        $query->innerJoin('employee', 'order_cart.affliate_id = employee.affliate_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
            'pagination' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->groupBy('order_cart.affliate_id');

        // grid filtering conditions
        $query->andFilterWhere([
            'order_cart.status' => OrderCart::STATUS_SUCCESS,
        ]);

        if( $this->affliate_id > 0 || is_array($this->affliate_id) ){
            if( is_array($this->affliate_id) && !empty($this->affliate_id) ){
                $query->andWhere(['in', 'order_cart.affliate_id', $this->affliate_id]);
            }else if( empty($this->affliate_id) && Yii::$app->user->identity->account_type == Employee::TYPE_SALE_ADMIN ){
                $query->andWhere(['order_cart.id' => 0]);
            }else if($this->affliate_id > 0){
                $query->andWhere(['order_cart.affliate_id' => $this->affliate_id]);
            }
        }else{
            $query->andWhere(['order_cart.affliate_id' => -1]);
        }

        if( !empty($this->date_start) ){
            $query->andFilterWhere(['>=', 'order_cart.create_date', $this->date_start]);
            if( empty($this->date_end) )
                $this->date_end = $this->date_start;
        }
        if( !empty($this->date_end) )
            $query->andFilterWhere(['<=', 'order_cart.create_date', $this->date_end . ' 23:59:59']);

        return $dataProvider;
    }
}
