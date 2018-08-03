<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfDealDetail;
use common\models\ZfUser;
/**
 * ZfDealDetailSearch represents the model behind the search form of `common\models\ZfDealDetail`.
 */
class DealDetailSearch extends \common\models\ZfDealDetailSearch
{
    public function attributes(){
        return array_merge(parent::attributes(),['receivetime','user_name']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created', 'school_id'], 'integer'],
            [['pos_sn', 'card_no', 'type', 'ser_no','user_name'], 'safe'],
            [['amount', 'balance'], 'number'],
            [['receivetime'],'date','format' => 'php:Y-m-d H:i:s','message'=>'请输入正确的日期格式']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$stuno)
    {
        if($stuno){
            if (preg_match('/[a-zA-Z]/',$stuno)){
                $user_no= substr($stuno,6);
                $sid=substr($stuno,1,5);
            }else{
                $sid='56651';
                $user_no= substr($stuno,2);
            } 
        }
        $query = ZfDealDetail::find()->where(['zf_card_info.user_no'=>$user_no,'zf_card_info.school_id'=>$sid]);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 11,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $this->created=($this->receivetime)? strtotime($this->receivetime):$this->created;
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'balance' => $this->balance,
//            'created' => $this->created,
            'school_id' => $this->school_id,
        ]);
        $query->andFilterWhere(['>=', 'created', $this->created]);
        $query->andFilterWhere(['like', 'pos_sn', $this->pos_sn])
            ->andFilterWhere(['like', 'card_no', $this->card_no])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ser_no', $this->ser_no]);
        $query->join('inner join','zf_card_info','zf_card_info.card_no = zf_deal_detail.card_no and zf_card_info.school_id = zf_deal_detail.school_id');
        $query->andFilterWhere(['like', 'zf_card_info.user_name', $this->user_name]);
        return $dataProvider;
    }
    
    public function getLastStu($uid){
        $result= ZfUser::find()->select('stu_no')->join('inner join','zf_students','zf_students.id=zf_user.last_stuid') ->where(['zf_user.id'=>$uid])->asArray()->one();
        
        return $result;
    }
}


