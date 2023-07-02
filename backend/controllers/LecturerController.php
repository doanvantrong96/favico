<?php

namespace backend\controllers;

use Yii;
use backend\models\Lecturer;
use backend\models\LecturerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;

/**
 * LecturerController implements the CRUD actions for Lecturer model.
 */
class LecturerController extends Controller
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
     * Lists all Lecturer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LecturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lecturer model.
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
     * Creates a new Lecturer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lecturer();

        if ($model->load(Yii::$app->request->post()) ) {
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                $resultUpload  = CommonController::uploadFile($_FILES["avatar"],'images/lecturer');
                if( $resultUpload['status'] )
                    $model->avatar = $resultUpload['url'];
            }else{
                $model->avatar  = '';
            }
           
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->status = 1;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lecturer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                $resultUpload  = CommonController::uploadFile($_FILES["avatar"],'images/lecturer');
                
                if( $resultUpload['status'] ){
                    if( $model->avatar != '' ){
                        CommonController::removeFile($model->avatar);
                    }
                    $model->avatar = $resultUpload['url'];
                }
            }
            
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lecturer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $countCourse = \backend\models\Course::find()->where(['is_delete' => 0, 'lecturer_id' => $id])->count();
        if( $countCourse <= 0 ){
            $model->is_delete = 1;
            $model->save(false);

            Yii::$app->session->setFlash('success', "Xoá giảng viên thành công");
        }else{
            Yii::$app->session->setFlash('error', "Lỗi! Không thể xoá giảng viên do có khoá học liên quan");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lecturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lecturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lecturer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
