<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $status_name
 * @property int $status_value
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_name', 'status_value'], 'required'],
            [['id', 'status_value'], 'integer'],
            [['status_name'], 'string', 'max' => 45],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
            'status_value' => 'Status Value',
        ];
    }
    
    /**
     * get users
     * 
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['status_id' => 'id']);
    }
}
