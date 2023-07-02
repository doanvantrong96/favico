<?php

namespace backend\controllers;

use Yii;
use backend\models\UserRegisterEmail;
use backend\models\UserRegisterEmailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;

/**
 * UserRegisterEmailController implements the CRUD actions for UserRegisterEmail model.
 */
class UserRegisterEmailController extends Controller
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
     * Lists all UserRegisterEmail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserRegisterEmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (isset(Yii::$app->request->queryParams['_export'])) {
            $dataProvider->pagination->pageSize=0;
            $this->exportData($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    private function exportData($dataProvider){
        if( !empty($dataProvider->getModels()) ){
            $header = [
                'Email',
                'Ngày đăng ký'
            ];
            $data       = [];
            foreach($dataProvider->getModels() as $row){
                $data[] = [
                    trim($row->email),
                    date('H:i:s d/m/Y', strtotime($row->create_date))
                ];
            }
            $file_name  = 'Khach_hang_dang_ky_nhan_uu_dai_' . date('his') . '_' . date('dmY');
            CommonController::exportDataExcel($header, $data, $file_name);
        }
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xoá email khách hàng đăng ký thành công');
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserRegisterEmail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserRegisterEmail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserRegisterEmail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
