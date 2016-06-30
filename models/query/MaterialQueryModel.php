<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/30 14:34
 */

namespace app\models\query;

use app\components\Pagination;
use yii\base\Model;

/**
 * 素材查询模型
 * Class MaterialQueryModel
 * @package app\models\query]
 */
class MaterialQueryModel extends Model
{
    public $page=1;
    public $pageSize=10;
    public $pagination;

    /**
     * @return Pagination|null 分页组件
     */
    public function getPagination()
    {
        if($this->page && $this->pageSize && is_null($this->pagination)){
            $this->pagination = new Pagination($this->page, $this->pageSize);
        }

        return $this->pagination;
    }
}