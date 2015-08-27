<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
namespace kalibao\backend\modules\authentication\models\authentication;

use Yii;
use yii\base\Model;
use kalibao\backend\components\web\UserIdentity;

/**
 * Class LoginForm
 *
 * @package kalibao\backend\modules\authentication\models\authentication
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $remember_me = true;

    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['remember_me', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('kalibao.backend','login_form:username'),
            'password' => Yii::t('kalibao.backend','login_form:password'),
            'remember_me' => Yii::t('kalibao.backend','login_form:remember_me'),
        ];
    }

    /**
     * Validates the password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('kalibao.backend', 'bad_login_password'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login(
                $this->getUser(),
                $this->remember_me ? 3600 * 24 * Yii::$app->variable->get('kalibao.backend', 'auto_login_duration') : 0
            );
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = UserIdentity::findByUsername($this->username);
        }

        return $this->user;
    }
}
