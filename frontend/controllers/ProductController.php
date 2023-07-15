<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

use backend\models\Product;
use backend\models\ProductCategory;
use backend\models\ProductTag;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthFb'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function beforeAction($action)
    {
        // if ( !Yii::$app->user->identity ) {
        //     $url_access = Yii::$app->request->url;
        //     if( strpos($url_access, 'chi-tiet-khoa-hoc') !== false )
        //         Yii::$app->session->set('url_access', $url_access);
        // }
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //thương hiệu
        $product_cat = ProductCategory::find()
        ->where(['status' => 1])
        ->all();
        $product_cat = ArrayHelper::map($product_cat, 'id','name');
        //Con giống
        $product_tag = ProductTag::find()
        ->where(['status' => 1])
        ->all();

        //san pham noi bat
        $most = Product::find()
        ->where(['is_most' => 1])
        ->all();

        $limit = 6;
        $total_product = Product::find()->count();
        $total_page = ceil($total_product / $limit);
        $product_tag = ArrayHelper::map($product_tag, 'id','name');
        $arr_data = [];
        foreach($product_tag as $id => $tag){
            $arr_data[$tag] = Product::find()
            ->select(['id','image','title','tag_id'])
            ->where(['status' => 1])
            ->where(['like','tag_id',";$id;"])
            ->limit(6)
            ->asArray()
            ->all();
        }

        if(!empty($_POST)){
            $page = $_POST['page'];
            $offset = ($page - 1) * $limit;
            $query = Product::find()
            ->select(['id','image','title','tag_id','category_id'])
            ->where(['status' => 1]);

            if(isset($_POST['category'])){
                $query->andWhere(['in','category_id',$_POST['category']]);
            }
            if(isset($_POST['tag']) && !empty($_POST['tag'])){
                $tag  =$_POST['tag'];
                $query->andWhere(['like','tag_id',";$tag;"]);
            }
            
            foreach($product_tag as $id => $tag){
                $arr_data[$tag] = $query
                ->limit($limit)
                ->offset($offset)
                ->asArray()
                ->all();
            }

            $total_product = $query->count();
            $total_page = ceil($total_product / $limit);
          
            if(!empty($arr_data)){
                $res = '';
                foreach($arr_data as $name_tag => $item_product){
                    $html_product = '';
                    foreach($item_product as $row) { 
                        $html_product .= '<div class="item_product">
                        <a class="flex-center" href="'. Url::to(['/product/detail','id' => $row['id']]) .'">
                            <img src="'. $row['image'] .'" alt="">
                            <p>'. $row['title'] .'</p>
                            <span>Chi tiết</span>
                        </a>
                    </div>';
                    }
                    $res .= '<div class="result_product_gr">
                                <div class="cat_result">
                                    <h6>'. $name_tag .'</h6>
                                    <div class="line_tit"></div>
                                </div>
                                <div class="list_product">
                                        '. $html_product .'
                                </div>
                            </div>';
                }
                if(!empty($res)){
                    $data['res'] = $res;
                    $data['total_page'] = $total_page;
                    echo json_encode( $data );
                    exit;
                }
            }
        }

        return $this->render('index',[
            'arr_data'    => $arr_data,
            'product_cat' => $product_cat,
            'product_tag' => $product_tag,
            'total_page' => $total_page,
            'most'      => $most,
        ]);
        
    }

    public function actionDetail($id)
    {
        $result = Product::findOne($id);

        //san pham lien quan
        $product_lq = Product::find()
        ->where(['category_id' => $result->category_id])
        ->andWhere(['<>', 'id', $result->id])
        ->limit(6)
        ->all();
     
        return $this->render('detail',[
            'result'    => $result,
            'product_lq'    => $product_lq
        ]);
    }
    

    public function actionSearch(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query  = strip_tags(Yii::$app->request->get('q'));
        $type   = Yii::$app->request->get('type');
        $arr_data = [];
        if( $type == 'all' ){ //tên giáo viên, khoá học, bài học
            $course  = Course::find()
            ->where(['status'=>1,'is_delete' => 0])
            ->andWhere(['like','name',$query])
            ->orderBy(['create_date'=>SORT_DESC])
            ->asArray()
            ->all();

            $lecturer = Lecturer::find()
            ->where(['status'=>1,'is_delete' => 0])   
            ->andWhere(['like','name',$query])
            ->asArray()
            ->all();

            $course_lesson = CourseLesson::find()
            ->select(['A.id','A.name','A.avatar','A.course_id','A.description','A.duration','A.link_video','B.slug AS slug_course'])
            ->from(CourseLesson::tableName() . ' A')
            ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
            ->where(['like','A.name',$query])
            ->asArray()
            ->orderBy(['id' => SORT_DESC])
            ->all();

            if(!empty($course)){
                foreach($course as $item){
                    $arr_data[] = [
                        'link'  => Url::to(['/course/course-overview','slug_course' => $item['slug']]),
                        'avatar' => 'https://elearning.abe.edu.vn' . $item['avatar'],
                        'name'  => $item['name'],
                        'description' => $item['description'],
                    ];
                }
            }
            if(!empty($lecturer)){
                foreach($lecturer as $item){
                    $arr_data[] = [
                        'link'  => Url::to(['/lecturers/detail','slug' => $item['slug']]),
                        'avatar' => 'https://elearning.abe.edu.vn' . $item['avatar'],
                        'name'  => $item['name'],
                        'description' => $item['level'],
                    ];
                }
            }
            if(!empty($course_lesson)){
                foreach($course_lesson as $item){
                    $arr_data[] = [
                        'link'  => Url::to(['/course/index','slug_detail' => $item['slug_course']]),
                        'avatar' => 'https://elearning.abe.edu.vn' . $item['avatar'],
                        'name'  => $item['name'],
                        'description' => $item['description'],
                    ];
                }
            }
        }
        return [
            'status' => 1,
            'data' => $arr_data
        ];
    }
    public function actionRating(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id     = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
        $star   = isset($_REQUEST['star']) ? (int)$_REQUEST['star'] : 0;
        $data   = [
            'status' => 0,
            'star'   => 0,
            'msg'    => ''
        ];
        if( !Yii::$app->user->isGuest ){
            if( $id > 0 && $star > 0 ){
                $model_lession      = CourseLesson::findOne($id);
                if( !empty($model_lession) ){
                    $user_id            = Yii::$app->user->id;
                    $check_isset        = UserCourse::findOne(['course_id'=>$model_lession->course_id,'user_id'=>$user_id]);
                    if( $model_lession->is_prevew == 1 || $check_isset ){
                        //10/50/5
                        $dataRating     = explode('/',$model_lession->rating);
                        $dataRating[0]  = $dataRating[0] + 1;
                        $dataRating[1]  = $dataRating[1] + $star;
                        $dataRating[2]  = round($dataRating[1]/$dataRating[0]);

                        $model_lession->rating = implode('/', $dataRating);
                        $model_lession->save(false);

                        $data['status'] = 1;
                        $data['star']   = $dataRating[2];
                        $data['msg']    = "Đánh giá thành công";
                    }
                }else{
                    $data['msg']    = "Thông tin không hợp lệ";
                }
            }else{
                $data['msg']    = "Thông tin không hợp lệ";
            }
        }else{
            $url_login      = Url::to(['site/login']);
            $data['msg']    = "Vui lòng đăng nhập để đánh giá. <a style='text-decoration: underline;color:#fff' href='$url_login'>Đăng nhập ngay</a>";
        }
        return $data;
    }
}
