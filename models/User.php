<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "ps_user".
 *
 * @property integer $userid
 * @property string $username
 * @property string $fullname
 * @property string $displayname
 * @property string $password
 * @property string $phone
 * @property string $email
 * @property string $active
 * @property string $admin
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_user';
    }

    public $varActive;
    public $varConfirmPassword;

    public function getactiveText(){
        if ($this->active == "Y"){
            return "Yes";
        }else{
            return "No";
        }
    }

    public function getadminText(){
        if ($this->admin == "Y"){
            return "Yes";
        }else{
            return "No";
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'fullname', 'displayname', 'password', 'phone'], 'required'],
            [['username'], 'string', 'max' => 20],
            [['fullname', 'password', 'email'], 'string', 'max' => 150],
            [['displayname'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['active', 'admin'], 'string', 'max' => 1],
            [['username'], 'unique'],
            ['email', 'email'],
            ['varConfirmPassword', 'compare', 'compareAttribute' => 'password',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'ID',
            'username' => 'Username',
            'fullname' => 'Full Name',
            'displayname' => 'Display Name',
            'password' => 'Password',
            'phone' => 'Phone',
            'email' => 'Email',
            'active' => 'Active',
            'admin' => 'Is Admin',
            'varActive' => 'Active',
            'activeText' => 'Active',
            'adminText' => 'Is Admin',
            'varConfirmPassword' => 'Confirm Password'
        ];
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findByUsername($username)
    {        
        return static::findOne(['username' => $username, 'active' => 'Y']);
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

     /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return "HOTEL";
    }

     /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

     /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return null;
    }

}
