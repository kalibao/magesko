<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\message\models\message\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\message\Message;

/**
 * This is the model filter class for controller "Message".
 *
 * @property integer $id
 * @property string $message_group_i18n_title
 * @property integer $message_group_id
 * @property string $source
 * @property string $message_i18n_translation
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\message\models\message\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends Message
{
    public $message_group_i18n_title;
    public $message_i18n_translation = [];
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
                'id', 'message_group_id', 'message_i18n_translation', 'created_at_start', 'created_at_end',
                'updated_at_start', 'updated_at_end', 'message_group_i18n_title', 'source'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'message_group_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['message_group_i18n_title', 'source'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['message_group_i18n_title'] = Yii::t('kalibao','message:message_group_id');
        $attributeLabels['message_i18n_translation'] = Yii::t('kalibao','message_i18n:translation');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $languageGroupLanguages, $language = null, $pageSize = 10)
    {
        $select = ['message.id', 'message.message_group_id', 'message_group_i18n.message_group_id', 'source', 'created_at', 'updated_at'];
        foreach ($languageGroupLanguages as $languageGroupLanguage) {
            $languageId = $languageGroupLanguage->language_id;
            $select[] = 'message_i18n_'.$languageId.'.translation as message_i18n_'.$languageId.'_translation';
            $select[] = 'message_i18n_'.$languageId.'.message_id as message_i18n_'.$languageId.'_message_id';
        }

        $query = (new \yii\db\Query())
            ->select($select)
            ->from('message')
            ->join(
                'LEFT JOIN',
                'message_group_i18n',
                'message.message_group_id = message_group_i18n.message_group_id AND message_group_i18n.i18n_id = :language'
            )
            ->addParams(
                [':language' => $language]
            );

        foreach ($languageGroupLanguages as $languageGroupLanguage) {
            $languageId = $languageGroupLanguage->language_id;
            $query
                ->join(
                    'LEFT JOIN',
                    'message_i18n as message_i18n_'.$languageId,
                    'message.id = message_i18n_'.$languageId.'.message_id AND message_i18n_'.$languageId.'.i18n_id = :language_'.$languageId
                )
                ->addParams(
                    [':language_'.$languageId => $languageId]
                );
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'message_group_i18n_title' => [
                        'asc' => ['message_group_i18n.title' => SORT_ASC],
                        'desc' => ['message_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('message_group_i18n_title')
                    ],
                    'message_group_id',
                    'source' => [
                        'label' => $this->getAttributeLabel('source')
                    ],
                    'message_i18n_translation' => [
                        'asc' => ['message_i18n.translation' => SORT_ASC],
                        'desc' => ['message_i18n.translation' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('message_i18n_translation')
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


        $query->andFilterWhere(['>=', 'message.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'message.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'message.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'message.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['message.id' => $this->id])
            ->andFilterWhere(['like', 'message_group_i18n.title', $this->message_group_i18n_title])
            ->andFilterWhere(['message.message_group_id' => $this->message_group_id])
            ->andFilterWhere(['like', 'message.source', $this->source]);
        foreach ($languageGroupLanguages as $languageGroupLanguage) {
            if (isset($this->message_i18n_translation[$languageGroupLanguage->language_id])) {
                $query->andFilterWhere([
                        'like',
                        'message_i18n_'.$languageGroupLanguage->language_id.'.translation',
                        $this->message_i18n_translation[$languageGroupLanguage->language_id]
                    ]);
            }
        }

        return $dataProvider;
    }
}
