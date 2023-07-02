<?php

namespace backend\models;

use Yii;

class ActionLog extends \yii\db\ActiveRecord
{
    const TYPE_CREATE       = 'CREATE';
    const TYPE_UPDATE       = 'UPDATE';
    const TYPE_DELETE       = 'DELETE';
    const TYPE_BLOCK        = 'BLOCK';
    const TYPE_UNBLOCK      = 'UNBLOCK';
    const TYPE_UNLOCK       = 'UNLOCK';
    const TYPE_CANCEL       = 'CANCEL';
    const TYPE_CHANGEPASS   = 'CHANGEPASS';
    const TYPE_RESETPASS    = 'RESETPASS';
    const TYPE_VIEW         = 'VIEW';
    const TYPE_ACTION_NEWS  = 'ACTION_NEWS';
    const TYPE_LOGIN        = 'LOGIN';
    const TYPE_LOGOUT       = 'LOGOUT';

    const MODULE_LOGIN      = 'LOGIN';
    const MODULE_BANNER     = 'BANNER';
    const MODULE_PARTNER    = 'PARTNER';
    const MODULE_STUDENTSTORY    = 'STUDENTSTORY';
    const MODULE_COMMUNITYSTORY = 'COMMUNITYSTORY';
    const MODULE_FREQUENTLY_QUESTION    = 'FREQUENTLY_QUESTION';
    const MODULE_FREQUENTLY_QUESTION_GROUP    = 'FREQUENTLY_QUESTION_GROUP';
    const MODULE_PACKAGE    = 'PACKAGE';
    const MODULE_NEWS       = 'NEWS';
    const MODULE_CONFIGHOME = 'CONFIG_HOME';
    const MODULE_NEWSTYPE   = 'NEWSTYPE';
    const MODULE_CATEGORY   = 'CATEGORY';
    const MODULE_TAG        = 'TAG';
    const MODULE_USER       = 'USER';
    const MODULE_TRANSACTION= 'TRANSACTION';
    const MODULE_COMMENT    = 'COMMENT';
    const MODULE_USERPACKAGE= 'USER_PACKAGE';
    const MODULE_EMPLOYEE   = 'EMPLOYEE';
    const MODULE_ASSIGN_ROLE= 'ASSIGN_ROLE';
    const MODULE_REVOKE_ROLE= 'REVOKE_ROLE';
    
    const MODULE_REPORT     = 'REPORT';
    
    const SOURCE_BACKEND    = 'BACKEND';

    public static function tableName()
    {
        return 'action_log';
    }

    public function rules()
    {
        return [
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID'
        ];
    }

    public static function insertLog($module, $objectCurrent, $type, $userId, $source, $objectArrOld = null, $arrAttr = [])
    {
        
        $objectArr = ( is_object($objectCurrent) )? $objectCurrent->getAttributes() : $objectCurrent;
        
        if( is_array($objectArr) && !empty($arrAttr) ){
            foreach($arrAttr as $key=>$value)
                $objectArr[$key]  = $value;
        }
        $data_change        = [];
        if( !empty($objectArrOld) ){
            
            foreach($objectArrOld as $key=>$value){
                if( isset($objectArr[$key]) ){
                    if( (!is_array($value) && $value != $objectArr[$key]) || (is_array($value) && count($value) != count($objectArr[$key])) )
                    $data_change[] = ['column' => $key, 'old' => $value, 'new' => $objectArr[$key]];
                }
            }
        }
        $log                = new ActionLog;
        $log->module        = $module;
        $log->content_id    = isset($objectArr['id']) ? $objectArr['id'] : null;
        $log->type          = $type;
        $log->detail        = is_array($objectArr) ? json_encode($objectArr) : null;
        $log->user_id       = $userId;
        $log->source        = $source;
        $log->created_at    = date('Y-m-d H:i:s');
        $log->ip            = \backend\controllers\CommonController::getAgentIp();
        $log->url           = Yii::$app->request->getAbsoluteUrl();
        $log->data_change   = !empty($data_change) ? json_encode($data_change) : null;
        $log->user_agent    = $_SERVER['HTTP_USER_AGENT'];
        return $log->save();
    }


}
