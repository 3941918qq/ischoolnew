<?php

namespace frontend\models;

use Yii;
use common\models\ZfUser;
use common\models\ZfRole;
use common\models\ZfStudents;
class User extends ZfUser{
    /**
     * @inheritdoc
     */
    public $name; 
    public $tel;
    public function rules()
    {
        return [
            [['name'], 'string','max'=>255],
            [['tel'], 'string', 'max' => 20],    
        ];
    }
    
    
    public function toggleRole($role_id,$uid){
        $role=ZfRole::findOne($role_id);
        $role_type=($role['name']=='家长') ? 'parent' : 'teacher';
        $user=ZfUser::findOne($uid);
        $user->role_type=$role_type;
        if($user->save(false)){
           $session = \Yii::$app->session;        
           $session['role_id']=$role_id;
           switch ($role['name']){
                case '家长':
                    $return_role_type='parent';
                    break;
                case '校长':
                    $return_role_type='manage';
                    break;
                default:
                    $return_role_type='teacher';
            }
            return $return_role_type;
        } else return false;
    }
    
    public function toggle($post){
        $type=$post['type'];
        $uid=$post['uid'];
        $user=ZfUser::findOne($uid);
        if($type=='parent'){
            $last_stuid=$post['last_stuid'];
            $stu=ZfStudents::findOne($last_stuid);
            $user->last_sid=$stu['school_id'];
            $user->last_stuid=$last_stuid;
        }else{
            $last_sid=$post['last_sid'];
            $user->last_sid=$last_sid;
        }
        return ($user->save(false)) ? true : false;
    }
}
    
