<?php

namespace common\models;

use Yii;
use common\models\ZfCardInfo;
/**
 * This is the model class for table "zf_deal_detail".
 *
 * @property int $id
 * @property string $pos_sn 消费机的序列号
 * @property string $card_no 餐卡的序列号
 * @property string $amount 消费金额
 * @property string $balance 余额
 * @property int $created 创建时间
 * @property string $type 消费类型
 * @property string $ser_no
 * @property int $school_id
 */
class ZfDealDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zf_deal_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pos_sn', 'card_no', 'amount', 'balance', 'created', 'ser_no'], 'required'],
            [['amount', 'balance'], 'number'],
            [['created', 'school_id'], 'integer'],
            [['type'], 'string'],
            [['pos_sn', 'card_no', 'ser_no'], 'string', 'max' => 50],
            [['created', 'ser_no', 'card_no'], 'unique', 'targetAttribute' => ['created', 'ser_no', 'card_no']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pos_sn' => '消费地点',
            'card_no' => '卡号',
            'amount' => '消费金额',
            'balance' => '余额',
            'created' => '消费时间',
            'type' => 'Type',
            'ser_no' => 'Ser No',
            'school_id' => 'School ID',
        ];
    } 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(ZfCardInfo::className(), ['card_no' => 'card_no','school_id'=>'school_id']);
    }
       //返回消费机地点
    function getPositon($sid, $pos_no) {
        $config = \yii::$app->params['canka_positon'];
        if (isset($config[$sid]) && isset($config[$sid][$pos_no])) {
            return $config[$sid][$pos_no];
        } else {
            return "餐厅";
        }

    }
   
}
