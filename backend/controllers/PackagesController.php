<?php

namespace backend\controllers;

use Yii;
use backend\models\Packages;
use backend\models\PackagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;


class PackagesController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Packages::find(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Packages();

        if ($model->load(Yii::$app->request->post())) {

            // Lấy file upload
            $model->qr_code = UploadedFile::getInstance($model, 'qr_code');

            if ($model->qr_code) {
                $path = Yii::getAlias('@backend/web/img/qr');

                // Tạo thư mục nếu chưa có
                $this->createDirectoryIfNotExists($path);

                // Tạo tên file
                $filename = time() . '_' . uniqid() . '.' . $model->qr_code->extension;

                // Upload file
                $model->qr_code->saveAs($path . '/' . $filename);

                // Lưu tên file vào DB
                $model->qr_code = $filename;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->qr_code;

        if ($model->load(Yii::$app->request->post())) {

            $model->qr_code = UploadedFile::getInstance($model, 'qr_code');

            if ($model->qr_code) {
                $path = Yii::getAlias('@backend/web/img/qr');
                $this->createDirectoryIfNotExists($path);

                $filename = time() . '_' . uniqid() . '.' . $model->qr_code->extension;

                $model->qr_code->saveAs($path . '/' . $filename);
                $model->qr_code = $filename;
            } else {
                // Nếu không upload ảnh mới → giữ file cũ
                $model->qr_code = $oldFile;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Packages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Không tìm thấy dữ liệu.');
    }

    private function createDirectoryIfNotExists($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
    }
}
