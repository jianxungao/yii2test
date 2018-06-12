<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthday
 * @property int $gender_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gender $gender
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id'], 'required'],
            [['user_id', 'gender_id'], 'integer'],
            [['first_name', 'last_name'], 'string'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender_id' => 'id']],
            [['gender_id'],'in', 'range'=>array_keys($this->getGenderList())],
            [['birthdate'], 'date', 'format'=>'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthday' => 'Birthday',
            'gender_id' => 'Gender ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
 
     public function getGenderName() 
     {
        return $this->gender->gender_name;
     }
    
    /**
     * get list of genders for dropdown
     */
 
    public static function getGenderList()
    {
            
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'gender_name');
        
    }
 
    /**
     * @return \yii\db\ActiveQuery
     */
   
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
 
    /**
     * @get Username
     */
         
    public function getUsername() 
    {
        return $this->user->username;
    }
 
    /**
     * @getUserId
     */
       
    public function getUserId() 
    {
        return $this->user ? $this->user->id : 'none';
    }
 
    /**
     * @getUserLink
     */
 
    public function getUserLink() 
    {
        $url = Url::to(['user/view', 'id'=>$this->UserId]); 
        $options = []; 
        return Html::a($this->getUserName(), $url, $options); 
    }
    
    /**
     * @getProfileLink
     */
 
     public function getProfileIdLink() 
     {
        $url = Url::to(['profile/update', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->id, $url, $options); 
     }
}
