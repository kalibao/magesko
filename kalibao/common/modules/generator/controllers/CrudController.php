<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\modules\generator\controllers;

use Yii;
use kalibao\backend\components\web\Controller;
use kalibao\common\modules\generator\models\Generator;

/**
 * Class CrudController
 *
 * @package kalibao\common\modules\generator\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CrudController extends Controller
{
    public $layout = '/simple/simple';

    /**
     * Main action
     * @return string
     * @throws \yii\base\ErrorException
     */
    public function actionIndex()
    {
        $model = new Generator();
        $request = Yii::$app->request;

        if ($model->load($request->post()) && $model->validate()) {
            if ($request->post('build', false)) {
                $model->generate(
                    $request->post('column', false),
                    $request->post('position', false),
                    $request->post('relation', [])
                );
                $tableList = $model->getTableNames();

                return $this->render('main', ['model' => $model, 'tableList' => $tableList, 'success' => true]);
            } else {
                $requestRelation = [];
                $relations = $model->generateRelations($requestRelation);
                $columns = $model->getConfigColumns($model->generateClassName($model->table), $requestRelation);
                $tableLinks = $model->getTableLinks($requestRelation);

                return $this->render(
                    'columns',
                    [
                        'model' => $model,
                        'columns' => $columns,
                        'relations' => $relations,
                        'tableLinks' => $tableLinks,
                    ]
                );
            }
        } else {
            $tableList = $model->getTableNames();
            return $this->render('main', ['model' => $model, 'tableList' => $tableList]);
        }
    }
} 