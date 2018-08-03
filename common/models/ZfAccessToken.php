<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_access_token".
 *
 * @property int $id 访问令牌
 * @property string $access_token 访问令牌
 * @property string $last_time 上次请求保存时间，超过2小时重新请求并更新
 */
class ZfAccessToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_access_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['last_time'], 'safe'],
            [['access_token'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'last_time' => 'Last Time',
        ];
    }
}
