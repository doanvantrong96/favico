<?php

use mdm\admin\AnimateAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Assignment */
/* @var $fullnameField string */

$this->title = 'Thông tin tài khoản ' . $model->fullname;
$this->params['breadcrumbs'][] = 'Quản trị hệ thống';
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="assignment-index">
    <div class="card mb-g">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [                      // the owner name of the model
                        'label' => 'Mã tài khoản',
                        'value' => $model->id,
                    ],
                    [                      // the owner name of the model
                        'label' => 'Tài khoản',
                        'value' => $model->username,
                    ],
                    [                      // the owner name of the model
                        'label' => 'Điện thoại',
                        'value' => $model->phone,
                    ],
                    [                      // the owner name of the model
                        'label' => 'Email',
                        'value' => $model->email,
                    ],
                    [                      // the owner name of the model
                        'label' => 'Thời gian tạo',
                        'value' => date('H:i:s d/m/Y',$model->created_at),
                    ],
                    [                      // the owner name of the model
                        'label' => 'Trạng thái tài khoản',
                        'value' => ($model->is_active == 1 ) ? 'Active' : 'InActive',
                    ],
                    [                      // the owner name of the model
                        'label' => 'Nhóm quyền',
                        'value' => ($model->is_admin == 0 ) ? $model->userRole : 'All quyền',
                    ]
                ],
            ]) ?>

            <div class="text-center">
                <a href="/assignment/update?id=<?= $model->id ?>" class="btn btn-primary"><i class="fal fa-save"></i> Cập nhật</a>
            </div>
        </div>
    </div>
   
</div>
