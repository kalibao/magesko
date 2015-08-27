<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

/**
 * Interface ModelFilterInterface
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
interface ModelFilterInterface
{
    /**
     * Search
     * @param array $requestParams Request parameters
     * @param string|array|null $language Language
     * @param int $pageSize Page size
     * @return \yii\data\ActiveDataProvider
     */
    public function search($requestParams, $language = null, $pageSize = 10);

}

