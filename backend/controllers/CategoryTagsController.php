<?php

namespace backend\controllers;

use Yii;
use backend\models\CategoryTags;
use backend\models\CategoryTagsSearch; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use backend\controllers\CommonController;


/**
 * CategoryTagsController implements the CRUD actions for CategoryTags model.
 */
class CategoryTagsController extends Controller
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
                    'delete' => ['GET'],
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
        $searchModel = new CategoryTagsSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new CategoryTags();
        $checkparams = Yii::$app->request->queryParams;

        if ( empty($checkparams) )
            $dataProvider->query->andWhere(['type' => 0]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
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
        $model = new CategoryTags();
        
        if($model->load(Yii::$app->request->post()))
        {
            $model->user_create = Yii::$app->user->identity->id;
            $model->slug        = CommonController::LocDau($model->name);
            if( $model->save() )
                Yii::$app->session->setFlash('message', "Thêm mới " . ($model->type == 0 ? 'chuyên mục' : 'tags') . " thành công");
            else
                Yii::$app->session->setFlash('message', "Lỗi!");
                
            return $this->redirect(['index']);
        }

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
        
        if($model->load(Yii::$app->request->post()))
        {
            $model->slug = CommonController::LocDau($model->slug);
            $model->save(false);
            Yii::$app->session->setFlash('message', "Cập nhật " . ($model->type == 0 ? 'chuyên mục' : 'tags') . " thành công");
            return $this->redirect(['index']);
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
        $model = CategoryTags::findOne($id);
        $model->is_delete = 1;
        $model->save(false);
        Yii::$app->session->setFlash('message', "Xoá dự án thành công");
        return $this->redirect(['index']);
    }

    public function actionPopupViewDetail($id){
        if (($model = CategoryTags::findOne($id)) !== null) {
            return $this->renderAjax('popup_view_detail', [
                        'model' => $model
                    ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        if (($model = CategoryTags::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
