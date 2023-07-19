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
use backend\models\Comment;
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
        $this->view->title = 'Sản phẩm - Phavico';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => "Các sản phẩm của công ty CP thức ăn chăn nuôi Phavico"
        ]);
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
        if(isset($_GET['cat'])){
            $total_product = Product::find()->where(['category_id' => $_GET['cat'], 'status' => 1])->count();
        }else{
            $total_product = Product::find()->where(['status' => 1])->count();

        }
        $total_page = ceil($total_product / $limit);
        $product_tag = ArrayHelper::map($product_tag, 'id','name');
        $arr_data = [];
        foreach($product_tag as $id => $tag){
            if(isset($_GET['cat'])){
                $arr_data[$tag] = Product::find()
                ->where(['status' => 1,'category_id' => $_GET['cat']])
                ->where(['like','tag_id',";$id;"])
                ->limit(6)
                ->asArray()
                ->all();
            }else{
                $arr_data[$tag] = Product::find()
                ->where(['status' => 1])
                ->where(['like','tag_id',";$id;"])
                ->limit(6)
                ->asArray()
                ->all();
            }

        }

        if(!empty($_POST)){
            $page = $_POST['page'];
            $offset = ($page - 1) * $limit;
            $query = Product::find()
            ->where(['status' => 1]);

            if(isset($_GET['cat']) && !isset($_POST['category'])){
                $query->andWhere(['in','category_id',$_GET['cat']]);
            }

            if(isset($_POST['category']) && empty($_POST['q'])){
                $query->andWhere(['in','category_id',$_POST['category']]);
            }
            if(isset($_POST['tag']) && !empty($_POST['tag']) && empty($_POST['q'])){
                $tag  =$_POST['tag'];
                $query->andWhere(['like','tag_id',";$tag;"]);
            }
            if(isset($_POST['q']) && !empty($_POST['q'])){
                $q  =$_POST['q'];
                $query->andWhere(['like','title',"$q"]);
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
                        <a class="flex-center" href="'. Url::to(['/product/detail','slug' => $row['slug'],'id' => $row['id']]) .'">
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
        $this->view->title = 'Sản phẩm - '. $result['title'] .'';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $result['description']
        ]);
        //san pham lien quan
        $product_lq = Product::find()
        ->where(['category_id' => $result->category_id])
        ->andWhere(['<>', 'id', $result->id])
        ->limit(6)
        ->all();

        //comment
        $comment = Comment::find()
        ->where(['status' => 1, 'type' => 0, 'product_id' => $id])
        ->all();
        return $this->render('detail',[
            'result'    => $result,
            'product_lq'    => $product_lq,
            'comment'       => $comment,
        ]);
    }
    
}
