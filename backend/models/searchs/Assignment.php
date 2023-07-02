<?php

namespace backend\models\searchs;

use backend\models\Employee;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Userinfo;

/**
 * AssignmentSearch represents the model behind the search form about Assignment.
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Assignment extends Model
{
    public $id;
    public $username;
    public $type_account;
    public $is_active;
    public $account_type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username','account_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac-admin', 'ID'),
            'username' => Yii::t('rbac-admin', 'Username'),
            'name' => Yii::t('rbac-admin', 'Name'),
        ];
    }

    /**
     * Create data provider for Assignment model.
     * @param  array                        $params
     * @param  \yii\db\ActiveRecord         $class
     * @param  string                       $usernameField
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params, $class, $usernameField)
    {
        $query = Userinfo::find()->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
                // 'params'   => $_POST
            ],
            'sort' =>false
        ]);

        if( $this->username != '' ){
            $condition_or = [];
            // if( $this->type_account == 1 )
            //     $condition_or = ['like','userfname',$this->username];
            // else
            //     $condition_or = ['like','userrealname',$this->username];
            $query->andFilterWhere(['or',
                ['like','fullname',$this->username],
                ['like','email',$this->username],
                ['like','phone',$this->username],
            ]);
        }

        if( Yii::$app->controller->id == 'sale-admin' && $this->account_type == Employee::TYPE_SALE_ADMIN ){
            $query->andWhere(['sale_admin_id' => Yii::$app->user->identity->id]);
            $this->account_type = Employee::TYPE_SALE;
        }

        if( !Yii::$app->user->isGuest && !Yii::$app->user->identity->is_admin ){
            $query->andWhere(['is_admin' => 0]);
        }
        if( $this->account_type ){
            $query->andWhere(['account_type' => $this->account_type]);
        }
        if( $this->is_active !== null &&  $this->is_active != "" ){
            $query->andWhere(['is_active' => $this->is_active]);
        }
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        return $dataProvider;
    }
}
