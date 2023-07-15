<?php

namespace backend\controllers;

use Yii;
use backend\models\Branch;
use backend\models\BranchSearch; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;
use yii\data\ActiveDataProvider;
use yii\data\CArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\imagine\Image;
use backend\controllers\CommonController;
use backend\models\ActionLog;

/**
 * BranchController implements the CRUD actions for Branch model.
 */
class BranchController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CategoryTags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel    = new BranchSearch();
        $dataProvider   = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    /**
     * Displays a single CategoryTags model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CategoryTags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Branch();
       
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {    
            if( $model->save() ){
                
                Yii::$app->session->setFlash('success', "Thêm mới thành công");
            }
            else
                Yii::$app->session->setFlash('success', "Lỗi!");
                
            return $this->redirect(['update', 'id' => $model->id]);
        }
        if( is_null($model->status) )
            $model->status = 1;
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing CategoryTags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $modelOld      = $model->getAttributes();
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save(false);

            Yii::$app->session->setFlash('success', "Cập nhật thành công");
            return $this->redirect(['update', 'id' => $model->id]);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CategoryTags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Branch::findOne($id);
        if( $model ){
            $modelOld   = $model->getAttributes();
            $model->is_delete = 1;
            $model->save(false);
            Yii::$app->session->setFlash('success', "Xoá chi nhánh thành công");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Finds the CategoryTags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryTags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
