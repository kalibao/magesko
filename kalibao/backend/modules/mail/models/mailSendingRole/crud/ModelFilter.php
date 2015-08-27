<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\models\mailSendingRole\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\mailSendingRole\MailSendingRole;

/**
 * This is the model filter class for controller "MailSendingRole".
 *
 * @property string $person_first_name
 * @property integer $person_id
 * @property integer $mail_template_id
 * @property integer $mail_send_role_id
 *
 * @package kalibao\backend\modules\mail\models\mailSendingRole\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends MailSendingRole implements ModelFilterInterface
{
    public $person_full_name;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'person_full_name', 'person_id', 'mail_template_id', 'mail_send_role_id'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'mail_template_id', 'mail_send_role_id'], 'integer'],
            [['person_full_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['person_full_name'] = Yii::t('kalibao','person:full_name');
        $attributeLabels['mail_send_role_id'] = Yii::t('kalibao','mail_send_role:id');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();

        $query->joinWith([
            'person' => function ($query) use ($language) {
                $query->select(['id', 'first_name', 'last_name']);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'person_full_name' => [
                        'asc' => ['person.first_name' => SORT_ASC],
                        'desc' => ['person.first_name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('person_full_name')
                    ],
                    'person_id',
                    'mail_template_id',
                    'mail_send_role_id' => [
                        'label' => $this->getAttributeLabel('mail_send_role_id')
                    ],
                ],
                'defaultOrder' => [
                    'person_id' => SORT_DESC
                ]
            ],
            'pagination' => [
                'defaultPageSize' => $pageSize,
                'pageSize' => $pageSize,
            ]
        ]);

        $this->load($requestParams);

        if (! $this->validate()) {
            return $dataProvider;
        }


        $query
            ->andFilterWhere(['like', 'person.first_name', $this->person_full_name])
            ->andFilterWhere(['mail_sending_role.person_id' => $this->person_id])
            ->andFilterWhere(['mail_sending_role.mail_template_id' => $this->mail_template_id])
            ->andFilterWhere(['mail_sending_role.mail_send_role_id' => $this->mail_send_role_id]);

        return $dataProvider;
    }
}
