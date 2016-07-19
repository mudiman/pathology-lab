<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\validators\EmailValidator;
use \nkovacs\datetimepicker\DateTimePicker;
use app\models\BaseModel;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $dob
 * @property string $phone_no
 * @property string $Address
 * @property string $passcode
 * @property string $visited_on
 * @property string $created_at
 * @property string $type
 * @property integer $delete
 * @property integer $status
 * @property string $update_at
 * @property integer $created_by
 * @property string $remark
 *
 * @property Report[] $reports
 * @property Report[] $reports0
 * @property ReportResult[] $reportResults
 * @property ReportTemplate[] $reportTemplates
 * @property Test[] $tests
 * @property User $createdBy
 * @property User[] $users
 */
class User extends BaseModel implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name','password_hash', 'email'], 'required', 'on' => 'user'],
            [['username', 'name','email', 'passcode'], 'required', 'on' => 'patient'],
            [['delete', 'status', 'created_by'], 'integer'],
            [['dob', 'visited_on', 'created_at', 'update_at'], 'safe'],
            [['remark'], 'string'],
            [['username'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['name', 'surname', 'phone_no', 'type'], 'string', 'max' => 45],
            [['Address'], 'string', 'max' => 1000],
            [['username'], 'unique'],
            [['phone_no'], 'number'],
            [['passcode'], 'string', 'max' => 10],
            [['email'], 'unique'],
            [['email'], 'email'],
            //[['visited_on'], 'datetime'],
            [['password_reset_token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'username' => 'User Name',
            'name' => 'Name',
            'surname' => 'SurName',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'dob' => 'Date of Birth',
            'phone_no' => 'Phone No',
            'Address' => 'Address',
            'passcode' => 'Passcode',
            'visited_on' => 'Visited On',
            'created_at' => 'Created Date Time',
            'type' => 'User Type',
            'delete' => 'soft delete',
            'status' => 'Account Status',
            'update_at' => 'Updated On',
            'created_by' => 'Created By User',
            'remark' => 'Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['patient_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports0()
    {
        return $this->hasMany(Report::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportResults()
    {
        return $this->hasMany(ReportResult::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportTemplates()
    {
        return $this->hasMany(ReportTemplate::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAge()
    {
        $date = new \DateTime($this->dob);
        $now = new \DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * Before save pre hook
     * @param $insert
     * @return mixed
     */
    public function beforeSave($insert)
    {
        $return = parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomKey($length = 255);
            if ($this->getScenario() == 'patient') {
                $this->type = 'patient';
            } else {
                $this->type = 'user';
            }
        }
        if ($this->getScenario() != 'patient') {
            $this->password_hash = MD5($this->password_hash);
        }
        return $return;
    }

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
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string     $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_hash === MD5($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string     $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = MD5($password);
    }

    /**
     * Passcode loginPassCode
     *
     * @param string $password
     */
    public function loginPassCode($passcode)
    {
        return $this->passcode == $passcode;
    }

}
