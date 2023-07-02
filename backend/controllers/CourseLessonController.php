<?php

namespace backend\controllers;

use Yii;
use backend\models\CourseLesson;
use backend\models\CourseLessonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;

/**
 * CourseLessonController implements the CRUD actions for CourseLesson model.
 */
class CourseLessonController extends Controller
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
     * Lists all CourseLesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseLessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseLesson model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionPreviewVideo($id)
    {
        return $this->render('preview_video', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new CourseLesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($course_id = 0)
    {
        $model = new CourseLesson();

        if ($model->load(Yii::$app->request->post())) {
            if( $course_id > 0 )
                $model->course_id = $course_id;
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                $resultUpload   = CommonController::uploadFile($_FILES["avatar"],'images/lesson');
                if( $resultUpload['status'] )
                    $model->avatar = $resultUpload['url'];
            }
            $model->sort = CourseLesson::find()->where(['course_id' => $model->course_id])->count() + 1;
            $model->save(false);

            \backend\models\CourseLessonQuestion::saveQuestionAnswer($model->id);

            \backend\models\Course::updateTotalLesson($model->course_id);
            Yii::$app->session->setFlash('success', "Lưu bài học thành công");
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            if( !$model->course_id && $course_id > 0 )
                $model->course_id = $course_id;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CourseLesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $link_video_old  = $model->link_video;
        if ($model->load(Yii::$app->request->post()) ) {
            if( $link_video_old != '' && $link_video_old != $model->link_video ){
                CommonController::removeFile($link_video_old);
            }
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                $resultUpload  = CommonController::uploadFile($_FILES["avatar"],'images/lesson');
                
                if( $resultUpload['status'] ){
                    if( $model->avatar != '' ){
                        CommonController::removeFile($model->avatar);
                    }
                    $model->avatar = $resultUpload['url'];
                }
            }
            $model->save(false);

            \backend\models\Course::updateTotalLesson($model->course_id);

            $result = \backend\models\CourseLessonQuestion::saveQuestionAnswer($model->id);
            if( $result['status'] ){
                Yii::$app->session->setFlash('success', "Lưu bài học thành công");
                return $this->redirect(['update', 'id' => $model->id]);
                // return $this->redirect(['/course/update', 'id' => $model->course_id]);
            }else{
                Yii::$app->session->setFlash('error', "Lỗi không thể lưu câu hỏi");
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CourseLesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if( $model ){
            $course_id = $model->course_id;
            $model->delete();
            \backend\models\Course::updateTotalLesson($course_id);
            Yii::$app->session->setFlash('success', "Xoá bài học thành công");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the CourseLesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseLesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseLesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
