<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\models\mailTemplate\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\mailTemplate\MailTemplate;

/**
 * This is the model filter class for controller "MailTemplate".
 *
 * @property integer $id
 * @property string $mail_template_group_i18n_title
 * @property integer $mail_template_group_id
 * @property integer $html_mode
 * @property string $sql_request
 * @property string $sql_param
 * @property string $mail_template_i18n_object
 * @property string $mail_template_i18n_message
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\mail\models\mailTemplate\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends MailTemplate implements ModelFilterInterface
{
    public $mail_template_group_i18n_title;
    public $mail_template_i18n_object;
    public $mail_template_i18n_message;
    public $created_at_start;
    public $created_at_end;
    public $updated_at_start;
    public $updated_at_end;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id', 'mail_template_group_i18n_title', 'mail_template_group_id', 'html_mode', 'sql_request', 'sql_param', 'mail_template_i18n_object', 'mail_template_i18n_message', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mail_template_group_id'], 'integer'],
            [['html_mode'], 'in', 'range' => [0, 1]],
            [['sql_request', 'sql_param', 'mail_template_i18n_message'], 'string'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['mail_template_group_i18n_title', 'mail_template_i18n_object'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['mail_template_group_i18n_title'] = Yii::t('kalibao','mail_template:mail_template_group_id');
        $attributeLabels['mail_template_i18n_object'] = Yii::t('kalibao','mail_template_i18n:object');
        $attributeLabels['mail_template_i18n_message'] = Yii::t('kalibao','mail_template_i18n:message');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();

        $query->joinWith([
            'mailTemplateGroupI18ns' => function ($query) use ($language) {
                $query->select(['mail_template_group_id', 'title'])->onCondition(['mail_template_group_i18n.i18n_id' => $language]);
            },
            'mailTemplateI18ns' => function ($query) use ($language) {
                $query->select(['mail_template_id', 'object', 'message'])->onCondition(['mail_template_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'mail_template_group_i18n_title' => [
                        'asc' => ['mail_template_group_i18n.title' => SORT_ASC],
                        'desc' => ['mail_template_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('mail_template_group_i18n_title')
                    ],
                    'mail_template_group_id',
                    'html_mode',
                    'sql_request',
                    'sql_param',
                    'mail_template_i18n_object' => [
                        'asc' => ['mail_template_i18n.object' => SORT_ASC],
                        'desc' => ['mail_template_i18n.object' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('mail_template_i18n_object')
                    ],
                    'mail_template_i18n_message' => [
                        'asc' => ['mail_template_i18n.message' => SORT_ASC],
                        'desc' => ['mail_template_i18n.message' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('mail_template_i18n_message')
                    ],
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'id' => SORT_DESC
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

        $query->andFilterWhere(['>=', 'mail_template.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'mail_template.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'mail_template.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'mail_template.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['mail_template.id' => $this->id])
            ->andFilterWhere(['like', 'mail_template_group_i18n.title', $this->mail_template_group_i18n_title])
            ->andFilterWhere(['mail_template.mail_template_group_id' => $this->mail_template_group_id])
            ->andFilterWhere(['mail_template.html_mode' => $this->html_mode])
            ->andFilterWhere(['like', 'mail_template.sql_request', $this->sql_request])
            ->andFilterWhere(['like', 'mail_template.sql_param', $this->sql_param])
            ->andFilterWhere(['like', 'mail_template_i18n.object', $this->mail_template_i18n_object])
            ->andFilterWhere(['like', 'mail_template_i18n.message', $this->mail_template_i18n_message]);

        return $dataProvider;
    }
}
