<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
class SchoolNotice extends Model{
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
    
}

