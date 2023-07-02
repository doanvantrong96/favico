<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = $category->name;
// $this->registerJsFile('/js/script.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$domain = Yii::$app->params['domain'];
?>
<div class="d-flex">
	<div class="container">
        <h1 class="heading-page"><?= $category->name ?></h1>
        <p class="des-page"><?= $category->except ?></p>
        <div class="list-course">
			<div class="row">
				<?php 
					foreach($Courses as $row){ 
						$coach_name = '';
						$coach_img  = '';
						if( isset($listCoach[$row->coach_id]) ){
							$coach_name = $listCoach[$row->coach_id]['name'];
							$coach_img  = $listCoach[$row->coach_id]['avatar'];
						}
				?>
				<div class="col-md-4 mb-3 col-course">
					<div class="course-card">
						<a href="<?= Url::to(['product/detail', 'slug' => $row->slug]);?>" style="display: block;">
							<div class="image-course">
								<img src="<?= $row->avatar ?>" alt="<?= $row->name ?>" class="background-image">
							</div>
							<div class="course-card-inner">
								<h3 class="course-title"><?= $row->name ?></h3>
								<div class="bottom-course-card">
									<div class="info-user">
										<img src="<?= $coach_img ?>" alt="<?= $coach_name ?>" class="avatar-image">
										<span><?= $coach_name ?></span>
									</div>	
									<div class="price"><?= number_format($row->price,0,'.','.') ?> <sup>đ</sup></div>
								</div>
							</div>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
    </div>
</div>