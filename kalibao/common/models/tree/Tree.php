<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\tree;

use kalibao\common\components\helpers\Arr;
use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\media\Media;
use kalibao\common\models\treeType\TreeType;
use kalibao\common\models\tree\TreeI18n;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\treeType\TreeTypeI18n;

/**
 * This is the model class for table "tree".
 *
 * @property integer $id
 * @property integer $tree_type_id
 * @property integer $media_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Branch[] $branches
 * @property Media $media
 * @property TreeType $treeType
 * @property TreeI18n[] $treeI18ns
 * @property MediaI18n[] $mediaI18ns
 * @property TreeTypeI18n[] $treeTypeI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class Tree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function ($event) {
                    return date('Y-m-d h:i:s');
                },
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'tree_type_id', 'media_id'
            ],
            'update' => [
                'tree_type_id', 'media_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree_type_id'], 'required'],
            [['tree_type_id', 'media_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'tree_type_id' => Yii::t('kalibao.backend','Tree Type ID'),
            'media_id' => Yii::t('kalibao.backend','Media ID'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeType()
    {
        return $this->hasOne(TreeType::className(), ['id' => 'tree_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeI18ns()
    {
        return $this->hasMany(TreeI18n::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaI18ns()
    {
        return $this->hasMany(MediaI18n::className(), ['media_id' => 'media_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeTypeI18ns()
    {
        return $this->hasMany(TreeTypeI18n::className(), ['tree_type_id' => 'tree_type_id']);
    }

    /**
     * @return Array
     */
    public function buildTree()
    {
        $data = Yii::$app->db->createCommand(
            "SELECT  hi.id AS item,
                build_tree_path('.', hi.id) AS path,
                hi.order,
                concat('branch-', hi.id) as `label`
                FROM    (
                    SELECT  build_tree(id) AS id,
                            @level AS level, tree_id
                    FROM    (
                        SELECT  @start_with := 1,
                            @id := @start_with,
                            @level := 0
                        ) vars, branch

                    ) ho
                JOIN    branch hi
                ON      hi.id = ho.id
                WHERE hi.tree_id = :id
                ORDER BY ho.`level`, hi.`order`",
            [
                "id"    => $this->id,
            ]
        )->queryAll();

        $tree = [];
        foreach ($data as $v) {
            $v['path'] = str_replace('.', '.children.', $v['path']);
            Arr::set($tree, $v['path'], [
                "id"       => 'branch-' . $v['item'],
                "text"     =>
                    $v['label'] .
                    " &nbsp; <i class=\"fa fa-eye\" id=\"view-{$v['item']}\"></i>" .
                    " &nbsp; <i class=\"fa fa-edit\" id=\"edit-{$v['item']}\"></i>"
                ,
                "order"    => $v['order'],
                "children" => []
            ]);
        }

        return $tree;
    }

    public function treeToJson()
    {
        $data = $this->buildTree();
        $data = $this->formatChildren($data['1']['children']);
        return json_encode($data);
    }

    private function formatChildren($data)
    {
        if (empty($data)) return [];
        $data = array_values($data);
        foreach($data as &$d) {
            $d['children'] = $this->formatChildren($d['children']);
        }
        return $data;
    }

    /*  this method seems to be slower than the other one for big trees
    public function treeToJson()
    {
        $data = Branch::findAll(['tree_id' => 1]);
        $tree = '';
        foreach ($data as $d) {
            $tree[] = [
                'id'     => 'branch-' . $d->id,
                'parent' => 'branch-' . $d->parent,
                'text'   => 'branch-' . $d->id,
            ];
        }
        return json_encode($tree);
    }
    */
}
