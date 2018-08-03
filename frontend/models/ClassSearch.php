<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfClass;
use common\models\ZfSchool;
use common\models\ZfClassSearch;
/**
 * ZfClassSearch represents the model behind the search form of `common\models\ZfClass`.
 */
class ClassSearch extends ZfClassSearch
{
    public function attributes(){
        return array_merge(parent::attributes(),['nianji','banji']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'class', 'sid'], 'integer'],
            [['name', 'created','school_name','nianji','banji'], 'safe'],
        ];
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$sid)
    {
        $query = ZfClass::find()->where(['zf_class.sid'=>$sid]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 11,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $this->level=($this->nianji)? $this->string2level($this->nianji):$this->level;
        $this->class=($this->banji)? $this->string2class($this->banji):$this->class;
        $query->andFilterWhere([
            'zf_class.id' => $this->id,
            'zf_class.level' => $this->level,
            'zf_class.class' => $this->class,
            'zf_class.sid' => $this->sid,
            'zf_class.created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'zf_class.name', $this->name]);
        $query->join('inner join','zf_school','zf_school.id=zf_class.sid');
        $query->andFilterWhere(['like','zf_school.name',$this->school_name]);
        return $dataProvider;
    }
    /**
     * 
     * @param type $nianji
     * @return 字符串年级转换数字年级
     */
    public function string2level($nianji){
        $level=$this->getLevel();
        foreach($level as $key=>$value){
           if($nianji==$value){
               return $key;
           }
        }
    }
    /**
     * 
     * @param type $nianji
     * @return 字符串班级转换数字班级
     */
    public function string2class($banji){
       $banji= preg_replace('/[班]/i', '', $banji);
       $level=$this->getClassnumber();
       foreach($level as $key=>$value){
           if($banji==$value){
               return $key;
           }
       }
   }
}


