<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\modules\profile\models\profile;

use Yii;
use kalibao\common\models\interfaceSetting\InterfaceSetting;
use kalibao\common\models\mailSendingRole\MailSendingRole;
use kalibao\common\models\rbacUserRole\RbacUserRole;
use kalibao\common\models\rbacRole\RbacRole;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_repeat
 * @property string $auth_key
 * @property integer $status
 * @property string $password_reset_token
 * @property integer $active_password_reset
 * @property string $person_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property InterfaceSetting[] $interfaceSettings
 * @property MailSendingRole[] $mailSendingRoles
 * @property RbacUserRole[] $rbacUserRoles
 * @property RbacRole[] $rbacRoles
 *
 * @package kalibao\modules\profile\models\profile
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class User extends \kalibao\common\models\user\User
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'update' => ['password', 'password_repeat'],
        ];
    }
}
