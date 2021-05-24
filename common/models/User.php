<?php
namespace common\models;

use frontend\models\Categories;
use frontend\models\EmailSetting;
use frontend\models\Favorites;
use frontend\models\File;
use frontend\models\Locations;
use frontend\models\Messages;
use frontend\models\Proposal;
use frontend\models\Review;
use frontend\models\Task;
use frontend\models\UsersCategories;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $scype
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    public $scype;
    public $another_messenger;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
          TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['phone', 'scype', 'another_messenger'], 'string'],
            ['phone', 'match', 'pattern' => '/^(8)[(](\d{3})[)](\d{3})[-](\d{2})[-](\d{2})/', 'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
      return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
     * Gets query for [[Location]].
     *
     * @return ActiveQuery
     */
    public function getLocation()
    {
      return $this->hasOne(Locations::class, ['id' => 'location_id']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCategory()
    {
      return $this->hasMany(Categories::class, ['id' => 'category_id'])
        ->viaTable('users_categories', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return ActiveQuery
     */
    public function getFavorites()
    {
      return $this->hasMany(Favorites::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(Messages::class, ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[EmailSettings]].
     *
     * @return ActiveQuery
     */
    public function getEmailSettings()
    {
      return $this->hasMany(EmailSetting::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return ActiveQuery
     */
    public function getFiles()
    {
      return $this->hasMany(File::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Proposals]].
     *
     * @return ActiveQuery
     */
    public function getProposals()
    {
      return $this->hasMany(Proposal::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerReviews]].
     *
     * @return ActiveQuery
     */
    public function getCustomerReview()
    {
      return $this->hasMany(Review::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ExecutorReviews]].
     *
     * @return ActiveQuery
     */
    public function getExecutorReview()
    {
      return $this->hasMany(Review::class, ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerTasks]].
     *
     * @return ActiveQuery
     */
    public function getCustomerTask()
    {
      return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ExecutorTasks]].
     *
     * @return ActiveQuery
     */
    public function getExecutorTask()
    {
      return $this->hasMany(Task::class, ['executor_id' => 'id']);
    }

    public function getAva()
    {
        $urlFile = "../../frontend/web/img/ava/ava" . $this->id;

        if (is_file($urlFile . ".jpg")) {
            return "ava/ava" . $this->id . ".jpg";
        } elseif (is_file($urlFile . ".png")) {
            return "ava/ava" . $this->id . ".png";
        } else {
            return 'new-user.png';
        }
    }

    public static function create($name, $email, $location_id, $password)
    {
      $user = new static();
      $user->username = $name;
      $user->email = $email;
      $user->location_id = $location_id;
      $user->setPassword($password);
      $user->generateAuthKey();
      $user->generateEmailVerificationToken();
      $user->save();
      UsersCategories::fill($user->id);

      return $user;
    }
}
