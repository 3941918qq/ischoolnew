<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_card_library".
 *
 * @property int $id
 * @property string $cardno 卡号
 * @property string $epcno EPC
 * @property string $telno 电话号
 * @property string $created
 */
class ZfCardLibrary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_card_library';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cardno', 'epcno', 'telno'], 'required'],
            [['created'], 'safe'],
            [['cardno', 'epcno', 'telno'], 'string', 'max' => 50],
            [['cardno'], 'unique'],
            [['epcno'], 'unique'],
            [['telno'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cardno' => '卡号',
            'epcno' => 'EPC',
            'telno' => '电话卡号',
            'created' => '创建时间',
        ];
    }

}
