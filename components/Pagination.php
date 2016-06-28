<?php
namespace app\components;

use yii\base\Component;

/**
 * 分页组件
 * Class Pagination
 * @package app\components
 */
class Pagination extends Component
{
    private $page;
    private $size;
    private $total;

    public function __construct($page=null, $size=10, $total=0, $config=[])
    {
        $this->setPage($page);
        $this->setSize($size);
        $this->setTotal($total);

        parent::__construct($config);
    }

    /**
     * 转为数组格式
     * @return array
     */
    public function toArray()
    {
        return [
            'pageNo' => $this->page,
            'pageSize' => $this->size,
            'total' => $this->total
        ];
    }

    public function getOffset()
    {
        return ($this->page - 1) * $this->getLimit();
    }

    public function getLimit()
    {
        return $this->size;
    }
    
    /**
     * @return int|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int|null $page
     */
    public function setPage($page)
    {
        $this->page = $page>0 ? $page : 1;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size>0 ? $size : 10;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total>0 ? $total : 0;
    }
    
}