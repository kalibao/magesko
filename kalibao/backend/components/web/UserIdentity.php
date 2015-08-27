<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\components\web;

use Yii;
use yii\base\NotSupportedException;
use yii\caching\TagDependency;
use yii\web\IdentityInterface;
use kalibao\common\components\web\User as UserComponent;

/**
 * Class UserIdentity
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class UserIdentity extends \kalibao\common\models\user\User implements IdentityInterface
{
    public $first_name;
    public $last_name;
    public $email;
    public $language;

    /**
     * @var int Cache duration
     */
    public static $cacheDuration = 86400;

    /**
     * Get cache key
     * @param integer $id User id
     * @return string
     */
    public static function getCacheKey($id)
    {
        return 'user:' . $id;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $cacheKey = self::getCacheKey($id);

        $userData = Yii::$app->commonCache->get($cacheKey);
        if ($userData === false) {
            $user = self::find()->with('person')->where(['id' => $id, 'status' => self::STATUS_ENABLED])->one();

            if ($user === null) {
                return null;
            }

            $userData = [
                'id' => $user->id,
                'password' => $user->password,
                'username' => $user->username,
                'email' => $user->person->email,
                'first_name' => $user->person->first_name,
                'last_name' => $user->person->last_name,
                'auth_key' => $user->auth_key,
                'language' =>  $user->person->default_language,
            ];

            // save user data
            Yii::$app->commonCache->set(
                $cacheKey,
                $userData,
                self::$cacheDuration,
                new TagDependency([
                    'tags' => [UserComponent::getCacheTag(), UserComponent::getCacheTag($id)],
                ])
            );
        }

        return new self($userData);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()->with('person')->where(['username' => $username, 'status' => self::STATUS_ENABLED])->one();
        if ($user === null) {
            return null;
        }

        $userData = [
            'id' => $user->id,
            'password' => $user->password,
            'username' => $user->username,
            'email' => $user->person->email,
            'first_name' => $user->person->first_name,
            'last_name' => $user->person->last_name,
            'auth_key' => $user->auth_key,
            'language' =>  $user->person->default_language
        ];

        // save user data
        Yii::$app->commonCache->set(
            self::getCacheKey($user->id),
            $userData,
            self::$cacheDuration,
            new TagDependency([
                'tags' => [UserComponent::getCacheTag(), UserComponent::getCacheTag($user->id)],
            ])
        );

        return new self($userData);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return Yii::$app->security->compareString($this->auth_key, $authKey);
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
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
}
