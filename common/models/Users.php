<?php

namespace common\models;

use app\models\Favorites;
use frontend\models\Categories;
use frontend\models\ChatMessages;
use frontend\models\EmailSettings;
use frontend\models\File;
use frontend\models\Locations;
use frontend\models\Proposal;
use frontend\models\Reviews;
use frontend\models\Tasks;
use frontend\models\UsersCategories;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use \yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $location_id
 * @property string|null $birthday
 * @property string|null $info
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $another_messenger
 * @property string|null $avatar
 * @property string|null $task_name
 * @property int|null $show_contacts_for_customer
 * @property int|null $hide_profile
 * @property string|null $last_visit_time
 * @property int $count_orders
 * @property int $popularity
 * @property int|null $now_free
 * @property int|null $has_reviews
 * @property int|null $is_executor
 * @property int|null $count_reviews
 * @property int|null $rating
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $verification_token
 *
 * @property ChatMessages[] $chatMessages
 * @property EmailSettings[] $emailSettings
 * @property Favorites[] $favorites
 * @property Favorites[] $favorites0
 * @property File[] $files
 * @property Proposal[] $proposals
 * @property Reviews[] $reviews
 * @property Reviews[] $reviews0
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UsersCategories[] $usersCategories
 */
class Users extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_INACTIVE = 9;
	const STATUS_ACTIVE = 10;


	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'users';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'auth_key', 'password_hash', 'email'], 'required'],
			[['location_id', 'show_contacts_for_customer', 'hide_profile', 'count_orders', 'popularity', 'now_free', 'has_reviews', 'is_executor', 'count_reviews', 'rating', 'status'], 'integer'],
			[['birthday', 'last_visit_time', 'created_at', 'updated_at'], 'safe'],
			[['info'], 'string'],
			[['name', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
			[['auth_key'], 'string', 'max' => 32],
			[['phone', 'skype', 'another_messenger', 'avatar', 'task_name'], 'string', 'max' => 128],
			[['name'], 'unique'],
			[['email'], 'unique'],
			[['password_reset_token'], 'unique'],
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'auth_key' => 'Auth Key',
			'password_hash' => 'Password Hash',
			'password_reset_token' => 'Password Reset Token',
			'email' => 'Email',
			'location_id' => 'Location ID',
			'birthday' => 'Birthday',
			'info' => 'Info',
			'phone' => 'Phone',
			'skype' => 'Skype',
			'another_messenger' => 'Another Messenger',
			'avatar' => 'Avatar',
			'task_name' => 'Task Name',
			'show_contacts_for_customer' => 'Show Contacts For Customer',
			'hide_profile' => 'Hide Profile',
			'last_visit_time' => 'Last Visit Time',
			'count_orders' => 'Count Orders',
			'popularity' => 'Popularity',
			'now_free' => 'Now Free',
			'has_reviews' => 'Has Reviews',
			'is_executor' => 'Is Executor',
			'count_reviews' => 'Count Reviews',
			'rating' => 'Rating',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'verification_token' => 'Verification Token',
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
	 * Finds user by name
	 *
	 * @param string $name
	 * @return static|null
	 */
	public static function findByUsername($name)
	{
		return static::findOne(['name' => $name, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by email
	 *
	 * @param string $email
	 * @return static|null
	 */
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
	 * Gets query for [[Favorites]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getFavorites()
	{
		return $this->hasMany(Favorites::class, ['user_id' => 'id']);
	}

	/**
	 * Gets query for [[ChatMessages]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getChatMessages()
	{
		return $this->hasMany(ChatMessages::class, ['writer_id' => 'id']);
	}

	/**
	 * Gets query for [[EmailSettings]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEmailSettings()
	{
		return $this->hasMany(EmailSettings::class, ['user_id' => 'id']);
	}

	/**
	 * Gets query for [[Files]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getFiles()
	{
		return $this->hasMany(File::class, ['user_id' => 'id']);
	}

	/**
	 * Gets query for [[Proposals]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProposals()
	{
		return $this->hasMany(Proposal::class, ['user_id' => 'id']);
	}

	/**
	 * Gets query for [[CustomerReviews]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getCustomerReviews()
	{
		return $this->hasMany(Reviews::class, ['customer_id' => 'id']);
	}

	/**
	 * Gets query for [[ExecutorReviews]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getExecutorReviews()
	{
		return $this->hasMany(Reviews::class, ['executor_id' => 'id']);
	}

	/**
	 * Gets query for [[CustomerTasks]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getCustomerTasks()
	{
		return $this->hasMany(Tasks::class, ['customer_id' => 'id']);
	}

	/**
	 * Gets query for [[ExecutorTasks]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getExecutorTasks()
	{
		return $this->hasMany(Tasks::class, ['executor_id' => 'id']);
	}

	/**
	 * Gets query for [[Location]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getLocation()
	{
		return $this->hasOne(Locations::class, ['id' => 'location_id']);
	}

	/**
	 * Gets query for [[UsersCategories]].
	 *
	 * @return \yii\db\ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getCategories()
	{
		return $this->hasMany(Categories::class, ['id' => 'category_id'])
			->viaTable('users_categories', ['user_id' => 'id']);
	}
}