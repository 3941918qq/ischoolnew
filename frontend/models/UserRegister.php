<?php
namespace frontend\models;

use yii\base\Model;
use common\models\ZfUser;

/**
 * Signup form
 */
class UserRegister extends Model
{
    public $tel;
    public $password;
    public $repassword;
    public $role;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['tel','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>"请输入正确的手机号码"],
            ['tel', 'required'],
            ['tel', 'unique', 'targetClass' => '\common\models\ZfUser', 'message' => '改号码已经被注册.'],
            ['tel', 'string', 'min' => 10, 'max' => 12],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'required'],
            ['repassword', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！'],
            ['role', 'string'],
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }       
        $user = new ZfUser();
        $user->tel = $this->tel;
        $user->password= md5($this->password);
        $user->role_type= $this->role;
        $user->register_time= date('Y-m-d H:i:s',time());
        return $user->save() ? $user : null;
    }
    
     public function attributeLabels(){
        return[
            'tel'=>'用户名',
            'password'=>'密码',
            'repassword'=>'重复密码',
            'role'=>'身份',
        ];
    }
}


