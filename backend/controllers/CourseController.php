<?php

namespace backend\controllers;

use Yii;
use backend\models\Course;
use backend\models\CourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\CourseLessonQuestion;
use backend\models\CourseLesson;
use backend\models\CourseLessonAnswer;
use backend\controllers\CommonController;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
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
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                $resultUpload   = CommonController::uploadFile($_FILES["avatar"],'images/course');
                if( $resultUpload['status'] )
                    $model->avatar = $resultUpload['url'];
            }else{
                $model->avatar  = '';
            }

            if( !isset($_POST['Course']['status']) )
                $model->status = 0;
            $model->description = str_replace('../uploads/','/uploads/',$model->description);
            $model->slug        = CommonController::LocDau($model->name);
            $model->save(false);

            // \backend\models\CourseLessonQuestion::saveQuestionAnswer($model->id, 2);

            Yii::$app->session->setFlash('success', "Thêm mới thành công");
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model->price = 0;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                $resultUpload  = CommonController::uploadFile($_FILES["avatar"],'images/course');
                
                if( $resultUpload['status'] ){
                    if( $model->avatar != '' ){
                        CommonController::removeFile($model->avatar);
                    }
                    $model->avatar = $resultUpload['url'];
                }
            }
            if( !isset($_POST['Course']['status']) )
                $model->status = 0;
            
            if( !isset($_POST['Course']['is_coming']) ){
                $model->is_coming = 0;
                $model->time_coming = NULL;
            }
            
            $model->save(false);
            // $result = \backend\models\CourseLessonQuestion::saveQuestionAnswer($model->id, 2);
            // if( $result['status'] ){
                Yii::$app->session->setFlash('success', "Cập nhật thành công");
                return $this->redirect(['update', 'id' => $model->id]);
            // }else{
            //     Yii::$app->session->setFlash('error', "Lỗi không thể lưu câu hỏi");
            //     return $this->redirect(['update', 'id' => $model->id]);
            // }
        } else {
            if( $model->price > 0 )
                $model->price = number_format($model->price,0,',',',');
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if( $model ){
            $course_name = $model->name;
            //Check if user buy course -> Return error
            $checkBuyCourse = \backend\models\UserCourse::findOne(['course_id' => $id]);
            if( $checkBuyCourse ){
                Yii::$app->session->setFlash('error', "Có lỗi! Không thể xoá khoá học <b>" . $course_name . "</b>. Nguyên do: khoá học ngày đã có học viên đăng ký học");
                return $this->redirect(['index']);
            }
            
            $listLesson = $model->getAllLessonOfCourse();

            $target_dir = $_SERVER['DOCUMENT_ROOT'];

            //Delete lesson of course
            if( !empty($listLesson) ){
                foreach($listLesson as $lesson){
                    if( !empty($lesson->path_file) && file_exists($target_dir . $lesson->path_file) ){
                        unlink($target_dir . $lesson->path_file);
                    }
                    if( !empty($lesson->link_video) ){
                        $link_video = explode('/', $lesson->link_video);
                        unset($link_video[count($link_video) - 1]);

                        $link_video = implode('/', $link_video);
                        if( is_dir($target_dir . $link_video) ){
                            $files = glob($target_dir . $link_video . "/*");
                            foreach($files as $file){
                                if(is_file($file)) {
                                    unlink($file);
                                }
                            }
                        }
                    }

                    $lesson->delete();
                }
            }

            //Delete trailer if exists
            if( !empty($model->trailer) && file_exists($target_dir . $model->trailer) ){
                unlink($target_dir . $model->trailer);
            }
            $model->delete();

            Yii::$app->session->setFlash('success', "Xoá khoá học <b>$course_name</b> thành công");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewDetail($type = 'lesson', $item_id = 0){
        $model = null;
        if( $type == 'lesson' ){
            $model = CourseLesson::findOne($item_id);
        }
        $dataRender = [
            'model'     => $model,
            'item_id'    => $item_id
        ];
        
        return $this->renderAjax("view/_$type", $dataRender);
    }

    /**
     * Function lưu dữ liệu: Tài liệu, hướng dẫn học, Bài học, Câu hỏi bài tập
     */
    public function actionSaveDataOfCourse($course_id, $type = 'document', $item_id = 0){
        $model      = $this->findModel($course_id);
        $request    = Yii::$app->request;
        $modelLesson = null;
        $link_video_old  = null;
        if( $type == 'lesson' ){
            $modelLesson = $item_id > 0 ? CourseLesson::findOne($item_id) : new CourseLesson;
            if( $item_id <= 0 ){
                $modelLesson->course_id = $course_id;
            }else{
                $link_video_old = $modelLesson->link_video;
            }
        }
        if ( $request->isPost ){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post   = Yii::$app->request->post();
            
            $error  = [];
            if( $type == 'lesson' ){
                $modelLesson->load($post);
                $error = $this->validateLesson($post, $modelLesson);
            }
            else if( $type == 'document' )
                $error = $this->validateDocument($post);
            else if( $type == 'guide' )
                $error = $this->validateGuide($post);
            else if( $type == 'question' )
                $error = $this->validateQuestion($post);
            
            if( !empty($error) ){
                return [
                    'status' => false,
                    'error'  => $error
                ];
            }else{
                $dataReturn  = [];
                $msg         = '';
                if( $type == 'lesson' ){
                    $dataReturn = $this->saveLesson($modelLesson, $link_video_old);
                    $msg        = $dataReturn['isNew'] ? 'Thêm bài học thành công' : 'Cập nhật bài học thành công';
                }
                else if( $type == 'document' ){
                    $dataReturn = $this->saveDocument($model, $post, $item_id);
                    $msg        = $item_id <= 0 ? 'Thêm tài liệu thành công' : 'Cập nhật tài liệu thành công';
                }
                else if( $type == 'guide' ){
                    $dataReturn = $this->saveGuide($model, $post, $item_id);
                    $msg        = $dataReturn['isNew'] ? 'Thêm hướng dẫn thành công' : 'Cập nhật hướng dẫn thành công';
                }else if( $type == 'question' ){
                    $dataReturn = $this->saveQuestion($model, $post, $item_id);
                    $msg        = $dataReturn['isNew'] ? 'Thêm câu hỏi thành công' : 'Cập nhật câu hỏi thành công';
                }
                
                if( isset($dataReturn['error']) ){
                    return [
                        'status' => false,
                        'error'  => [$dataReturn['msg']]
                    ];
                }
                return [
                    'status' => true,
                    'msg'    => $msg,
                    'data'   => $dataReturn
                ];
            }
        }
        $dataRender = [
            'model'     => $model,
            'modelLesson' => $modelLesson,
            'item_id'    => $item_id
        ];
        
        return $this->renderAjax("form/_$type", $dataRender);
    }

    /**
     * Xoá tài liệu, hướng dẫn học, bài học, câu hỏi bài tập
     */
    public function actionRemoveDataOfCourse($course_id, $type = 'document', $item_id = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model      = $this->findModel($course_id);
        $msg        = '';
        if( $type === 'document' ){
            $document   = $model->document ? json_decode($model->document, true) : [];
            if( isset($document[$item_id]) )
                unset($document[$item_id]);
            
            $document = !empty($document) ? json_encode($document) : NULL;
            $model->document = $document;
            $model->save(false);
            $msg    = 'Xoá tài liệu thành công';
        }else if( $type === 'guide' ){
            $study_guide   = $model->study_guide ? json_decode($model->study_guide, true) : [];
            if( isset($study_guide[$item_id]) )
                unset($study_guide[$item_id]);
            
            $study_guide = !empty($study_guide) ? json_encode($study_guide) : NULL;
            $model->study_guide = $study_guide;
            $model->save(false);
            $msg    = 'Xoá hướng dẫn thành công';
        }else if( $type === 'question' ){
            $condition_delete_question = 'type = 2 and id = ' . $item_id;
            $condition_delete_question .= ' and course_id = ' . $course_id;
            
            $condition_delete_answer  = 'question_id IN (' . $item_id . ')';

            Yii::$app->db->CreateCommand("UPDATE course_lesson_question SET is_delete = 1 WHERE $condition_delete_question")->execute();

            Yii::$app->db->CreateCommand("UPDATE course_lesson_answer SET is_delete = 1 WHERE $condition_delete_answer")->execute();
            $msg    = 'Xoá câu hỏi thành công';
        }else if( $type === 'lesson' ){
            $modelLesson = CourseLesson::findOne($item_id);
            if( $modelLesson ){
                $course_id = $modelLesson->course_id;
                $modelLesson->delete();
                CourseLesson::updatePositionLesson($course_id);
                Course::updateTotalLesson($course_id);
            }
            $msg    = 'Xoá bài học thành công';
        }
       
        return [
            'status' => true,
            'msg'    => $msg
        ];
    }

    /**
     * Cập nhật vị trí bài học
     */
    public function actionSavePositionOfLesson(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if( isset($_POST['data']) && !empty($_POST['data']) ){
            $data = $_POST['data'];
            foreach($data as $lesson_id=>$position){
                $model = CourseLesson::findOne($lesson_id);
                if( $model ){
                    $model->sort = $position;
                    $model->save(false);
                }
            }
        }
        return [
            'status' => true,
        ];
    }

    private function saveLesson($model, $link_video_old){
        $isNew          = $model->isNewRecord;
        $isEncodeVideo  = false;
        if( $isNew ){
            $model->sort = CourseLesson::find()->where(['course_id' => $model->course_id])->count() + 1;
            if( !empty($model->path_file) ){
                $isEncodeVideo = true;
            }
        }else{
            if( $link_video_old != '' && $link_video_old != $model->link_video ){
                CommonController::removeFile($link_video_old);
            }
        }

        if( isset($_POST['DocumentName']) && !empty($_POST['DocumentName']) ){
            $documentName       = $_POST['DocumentName'];
            $documentImg        = $_POST['DocumentImg'];
            $documentType       = $_POST['DocumentType'];
            $documentLink       = $_POST['DocumentLink'];
            $documentFileLink   = $_POST['DocumentFileLink'];
            $dataDocument       = [];
            $stt = 1;
            foreach($documentName as $key=>$doc_name){
                $dataDocument[$stt] = [
                    'name'      => $doc_name,
                    'img'       => isset($documentImg[$key]) ? $documentImg[$key] : '',
                    'type'      => isset($documentType[$key]) ? $documentType[$key] : 'link',
                    'link'      => isset($documentLink[$key]) ? $documentLink[$key] : '',
                    'file_link' => isset($documentFileLink[$key]) ? $documentFileLink[$key] : '',
                ];
                $stt++;
            }
            $model->document = json_encode($dataDocument);
        }else{
            $model->document = NULL;
        }

        $model->save(false);
        if( $isEncodeVideo  ){
            $model = CommonController::encodeVideoLesson($model, $model->path_file, true);
        }

        CourseLessonQuestion::saveQuestionAnswer($model->id);

        Course::updateTotalLesson($model->course_id);

        return [
            'isNew'     => $isNew,
            'item_id'   => $model->id,
            'name'      => $model->name,
            'path_file' => $model->path_file
        ];
    }
    
    private function saveDocument($model, $data, $item_id){
        $documentName       = $data['DocumentName'];
        $documentImg        = $data['DocumentImg'];
        $documentType       = $data['DocumentType'];
        $documentLink       = $data['DocumentLink'];
        $documentFileLink   = $data['DocumentFileLink'];
        $isNew              = true;
        // if( $model ){
        //     $document           = $model->document ? json_decode($model->document, true) : [];
            
        //     if( isset($document[$item_id]) ){
        //         $isNew          = false;
        //         $document[$item_id] = [
        //             'name'      => $documentName,
        //             'link'      => $documentLink,
        //             'file_link' => $documentFileLink
        //         ];
        //     }else{
        //         $item_id        = count($document) + 1;
        //         $document[$item_id] = [
        //             'name'      => $documentName,
        //             'link'      => $documentLink,
        //             'file_link' => $documentFileLink
        //         ];
        //     }
        //     $model->document = json_encode($document);
        //     $model->save(false);
        // }
        return [
            'isNew'     => $isNew,
            'item_id'   => $item_id,
            'name'      => $documentName,
            'img'       => $documentImg,
            'type'      => $documentType,
            'link'      => $documentType == 'link' ? $documentLink : '',
            'file_link' => $documentType == 'file' ? $documentFileLink : ''
        ];
    }

    private function saveGuide($model, $data, $item_id){
        $guideName          = $data['GuideName'];
        $guideLink          = $data['GuideLink'];
        $guideFileLink      = $data['GuideFileLink'];

        $study_guide        = $model->study_guide ? json_decode($model->study_guide, true) : [];
        $isNew              = true;
        if( isset($study_guide[$item_id]) ){
            $isNew          = false;
            $study_guide[$item_id] = [
                'name'      => $guideName,
                'link'      => $guideLink,
                'file_link' => $guideFileLink
            ];
        }else{
            $item_id        = count($study_guide) + 1;
            $study_guide[] = [
                'name'      => $guideName,
                'link'      => $guideLink,
                'file_link' => $guideFileLink
            ];
        }
        $model->study_guide = json_encode($study_guide);
        $model->save(false);

        return [
            'isNew'     => $isNew,
            'item_id'   => $item_id,
            'name'      => $guideName,
            'link'      => $guideLink,
            'file_link' => $guideFileLink
        ];
    }

    private function saveQuestion($model, $post, $item_id){
        $question_name   = $post['CourseLessonQuestion'];
        $dataAnswer      = $post['CourseLessonAnswer'];
        $answerCorrect   = $post['CheckBoxAnswerCorrect'];
        $flagAdd         = $item_id <= 0;
        $transaction     = Yii::$app->db->beginTransaction();
        try{

            if( $flagAdd ){
                $modelQuestion   = new CourseLessonQuestion;
                $modelQuestion->type = 2;
                $modelQuestion->course_id = $model->id;
            }else{
                $modelQuestion   = CourseLessonQuestion::findOne($item_id);
                if( !$modelQuestion || $modelQuestion->is_delete ){
                    return [
                        'error' => true,
                        'msg'   => "Câu hỏi không tồn tại"
                    ];
                }
            }
            $modelQuestion->question_name = trim($question_name);
            $modelQuestion->save(false);
            $item_id    = $modelQuestion->id;  
            $stt        = 1;
            foreach($dataAnswer as $id_ans => $answer_name){
                if( empty(trim($answer_name)) )
                    continue;
                $isCorrect = $answerCorrect == $stt ? 1 : 0;
                if( $flagAdd ){
                    $modelAns   = new CourseLessonAnswer;
                    
                }else{
                    $modelAns   = CourseLessonAnswer::findOne($id_ans);
                    if( !$modelAns ){
                        $modelAns   = new CourseLessonAnswer;
                    }else if( $modelAns->is_delete )
                        continue;
                }
                $modelAns->question_id = $modelQuestion->id;
                $modelAns->answer_name = trim($answer_name);
                $modelAns->is_correct  = $isCorrect;
                $modelAns->position    = $stt;
                $modelAns->save(false);
                $stt++;
            }

            $transaction->commit();
        }
        catch(\Exception $e){
            $transaction->rollBack();
            return [
                'error' => true,
                'msg'   => $e->getMessage()
            ];
        }

        return [
            'isNew'     => $flagAdd,
            'item_id'   => $item_id,
            'name'      => $question_name,
        ];
    }


    private function validateLesson($data, $model){
        $dataError = [];
        if( !$model->validate() ){
            $listError = $model->getErrors();
            foreach($listError as $error){
                $dataError[] = $error[0];
            }
        }
        if( isset($data['CourseLessonQuestion']) ){
            $courseLessonQuestion       = $data['CourseLessonQuestion'];
            $courseLessonAnswerCorrect  = $data['CourseLessonAnswerCorrect'];
            $courseLessonAnswer         = $data['CourseLessonAnswer'];
            $isErrorQuestion            = false;
            foreach($courseLessonQuestion as $key=>$value){
                if( empty(trim($value)) || !isset($courseLessonAnswer[$key]) || !isset($courseLessonAnswerCorrect[$key]) ){
                    $isErrorQuestion    = true;
                    
                    break;
                }else{
                    if( count(array_filter($courseLessonAnswer[$key])) < 4 || !$courseLessonAnswerCorrect[$key] ){
                        $isErrorQuestion    = true;
                        break;
                    }
                }
            }
            if( $isErrorQuestion ){
                $dataError[] = 'Nhập đầy đủ câu hỏi, câu trả lời và chọn đáp án đúng';
            }
        }
        return $dataError;
    }
    private function validateDocument($data){
        $dataError = [];
        if( !isset($data['DocumentName']) || empty($data['DocumentName']) ){
            $dataError[] = 'Tên tài liệu không được trống';
        }

        if( !isset($data['DocumentImg']) || empty($data['DocumentImg']) ){
            $dataError[] = 'Ảnh không được trống';
        }

        if( $data['DocumentType'] == 'link' ){
            if( (!isset($data['DocumentLink']) || empty($data['DocumentLink'])) )
                $dataError[] = 'Đường dẫn liên kết không được trống';
            else{
                if( strpos($data['DocumentLink'], 'https://') === false && strpos($data['DocumentLink'], 'http://') === false ){
                    $dataError[] = 'Đường dẫn liên kết không hợp lệ.';
                }
            }
        }

        if( $data['DocumentType'] == 'file' && (!isset($data['DocumentFileLink']) || empty($data['DocumentFileLink'])) ){
            $dataError[] = 'File tài liệu không được trống';
        }
        
        
        return $dataError;
    }

    private function validateGuide($data){
        $dataError = [];
        if( !isset($data['GuideName']) || empty($data['GuideName']) ){
            $dataError[] = 'Tên hướng dẫn không được trống';
        }

        if( (!isset($data['GuideLink'])  && !isset($data['GuideFileLink'])) || (isset($data['GuideLink']) && empty($data['GuideLink']) && isset($data['GuideFileLink']) && empty($data['GuideFileLink'])) ){
            $dataError[] = 'Đường dẫn liên kết hoặc file hướng dẫn không được trống';
        }

        if( isset($data['GuideLink']) && !empty($data['GuideLink']) && strpos($data['GuideLink'], 'https://') === false && strpos($data['GuideLink'], 'http://') === false ){
            $dataError[] = 'Đường dẫn liên kết không hợp lệ.';
        }
        return $dataError;
    }

    private function validateQuestion($data){
        $dataError = [];
        if( !isset($data['CourseLessonQuestion']) || empty($data['CourseLessonQuestion']) ){
            $dataError[] = 'Tên câu hỏi không được trống';
        }

        if( !isset($data['CourseLessonAnswer']) || count(array_filter($data['CourseLessonAnswer'])) != 4 ){
            $dataError[] = 'Câu trả lời chưa nhập đầy đủ';
        }else if( count(array_unique($data['CourseLessonAnswer'])) !== 4 ){
            $dataError[] = 'Câu trả lời không được trùng nhau';
        }

        if( !isset($data['CheckBoxAnswerCorrect']) ){
            $dataError[] = 'Chọn 1 đáp án đúng';
        }
        return $dataError;
    }

}
