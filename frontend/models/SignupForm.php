<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $location_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          ['username', 'trim'],
          ['username', 'required'],
          ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
          ['username', 'string', 'min' => 2, 'max' => 255],

          ['email', 'trim'],
          ['email', 'required'],
          ['email', 'email'],
          ['email', 'string', 'max' => 255],
          ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

          ['password', 'required'],
          ['password', 'string', 'min' => 1],

          ['location_id', 'integer'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account1 was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::create($this->username, $this->email, $this->location_id, $this->password);
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('customer');
        $auth->assign($authorRole, $user->getId());
        return $this->sendEmail($user);

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
          ->mailer
          ->compose(
            ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
            ['user' => $user]
          )
          ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
          ->setTo($this->email)
          ->setSubject('Account registration at ' . Yii::$app->name)
          ->send();
    }
}
