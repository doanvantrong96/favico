<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = 'Danh sách khoá học';
// $this->registerJsFile('/js/script.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$domain = Yii::$app->params['domain'];
?>
<div class="d-flex">
	<div class="container">
        <h1 class="heading-page">Danh sách khoá học</h1>
        <p class="des-page">Đăng ký ngay để bắt đầu truy cập hàng trăm lớp học ở nhiều lĩnh vực khác nhau: kinh doanh, kỹ năng lãnh đạo, nhiếp ảnh, nấu ăn, kỹ năng viết, diễn xuất, âm nhạc, thể thao & hơn thế nữa.</p>
        <div class="list-course">
			<?php 
				foreach($Courses as $row){ 
					$cate = $row['cate'];
					$listCourse = $row['course'];
			?>
			<h3 class="title-group-course"><?= $cate->name ?> <a href="<?= Url::to(['product/index', 'slug' => $cate->slug]);?>" class="view-more-course">Xem tất cả <i class="fa fa-angle-right"></i></a></h3>
			<div class="row list-course-by-group">
				<?php 
					foreach($listCourse as $row){ 
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
								<img src="<?= $row['avatar'] ?>" alt="<?= $row->name ?>" class="background-image">
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
			<?php } ?>
		</div>
    </div>
</div>