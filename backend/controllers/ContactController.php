<?php

namespace backend\controllers;

use Yii;
use backend\models\Contact;
use backend\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;
use yii\helpers\ArrayHelper;
use backend\models\ActionLog;
use yii\data\ActiveDataProvider;
/**
 * MedicalController implements the CRUD actions for Medical model.
 */
class ContactController extends Controller
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
     * Lists all Medical models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        
        $params         = Yii::$app->request->queryParams;
        $dataProvider   = $searchModel->search($params);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Medical model.
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
     * Creates a new Medical model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();
       
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {            
            if( $model->save() ){                
                Yii::$app->session->setFlash('success', "Thêm mới thành công");
            }
            else
                Yii::$app->session->setFlash('success', "Lỗi!");
            
            return $this->redirect(['index']);
        }
        if( is_null($model->status) )
            $model->status = 1;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save(false);

            Yii::$app->session->setFlash('success', "Cập nhật thành công");
            return $this->redirect(['index']);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Contact::findOne($id);
        if( $model ){
            $modelOld   = $model->getAttributes();
            $model->status = 0;
            $model->save(false);
            Yii::$app->session->setFlash('success', "Ẩn banner thành công");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExport()
    {
        $data = Contact::find()->all();
        
        $file_name  = 'contact.xls';
        
        $fields     = ['Name', 'Phone', 'Email', 'Notes', 'Create'];

        $excelData  = implode("\t", array_values($fields)) . "\n";

        foreach($data as $row)
        {
            $time       = date('H:i d-m-Y', strtotime($row['create']));
            $lineData   = array($row['name'], $row['phone'], $row['email'], $row['note'], $time);
            // array_walk($lineData, 'filterData');
            $excelData  .= implode("\t", array_values($lineData)) . "\n";
        }

        echo '<pre>';
        print_r($excelData);
        echo '</pre>';
        die;
    }

}
