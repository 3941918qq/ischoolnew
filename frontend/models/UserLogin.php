<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\ZfUser;

class UserLogin extends Model
{
    public $username;
    public $password;
    private $_user;
    
    public function rules(){
        // 在这里定义验证规则
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];

    }
    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {            
            $user = $this->getUser();
            if(!$user){
                $this->addError($attribute, '用户名不存在.');
            }else{
                if( $user->password!=md5($this->password)){
                    $this->addError($attribute, '密码不正确.');
                }
                $session = Yii::$app->session;
                $session['uid']= $user->id;
                $session['lifetime'] = time()+3600;         
                $user->last_login_time=date('Y-m-d H:i:s',time());
                $user->save(false); 
            }
            
            
           
        }
    }
    public function attributeLabels(){
        return[
            'username'=>'用户名',
            'password'=>'密码',
           
        ];
    }
    
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return true;
        }        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {            
            $this->_user = ZfUser::findOne(['tel'=>$this->username]);
        }

        return $this->_user;
    }
}

