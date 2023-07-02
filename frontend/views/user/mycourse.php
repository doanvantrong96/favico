<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = 'Danh sách khoá học của bạn';
?>
<div class="d-flex">
	<div class="container">
        <h1 class="heading-page" style="margin-bottom:30px">Danh sách khoá học của bạn</h1>
        <div class="list-course">
			<?php if(!empty($Courses)): ?>
			<div class="row list-course-by-group">
				<?php 
					foreach($Courses as $row){ 
						$coach_name = '';
						$coach_img  = '';
						if( isset($listCoach[$row['coach_id']]) ){
							$coach_name = $listCoach[$row['coach_id']]['name'];
							$coach_img  = $listCoach[$row['coach_id']]['avatar'];
						}
				?>
				<div class="col-md-4 mb-3 col-course">
					<div class="course-card">
						<a href="<?= Url::to(['product/detail', 'slug' => $row['slug']]);?>" style="display: block;">
							<div class="image-course">
								<img src="<?= $row['avatar'] ?>" alt="<?= $row['name'] ?>" class="background-image">
							</div>
							<div class="course-card-inner">
								<h3 class="course-title"><?= $row['name'] ?></h3>
								<div class="bottom-course-card">
									<div class="info-user">
										<img src="<?= $coach_img ?>" alt="<?= $coach_name ?>" class="avatar-image">
										<span><?= $coach_name ?></span>
									</div>
									<div class="price">
                                        Kích hoạt: <?= date('d/m/Y',strtotime($row['date_buy'])) ?>
                                    </div>
								</div>
							</div>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php else: ?>
				<div class="box_register">
					<p>Hiện tại bạn chưa có khoá học nào. Hãy tham khảo các khoá học của BMG Edu <a href="<?= Url::to(['product/index']);?>">tại đây</a></p>
					</br>
					<a class="btn btn-primary primary button is-shade box-shadow-3 box-shadow-5-hover" href="<?= Url::to(['product/index']);?>">Tham gia ngay</a>
				</div>				
			<?php endif; ?>
		</div>
    </div>
</div>