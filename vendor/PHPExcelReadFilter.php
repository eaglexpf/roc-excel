<?php
/**
 * User: Roc.xu
 * Date: 2017/6/15
 * Time: 10:29
 */
namespace RocExcel\vendor;

class PHPExcelReadFilter implements \PHPExcel_Reader_IReadFilter
{
    public $startRow = 1;
    public $endRow;

    public function readCell($column, $row, $worksheetName = '') {
        //如果endRow没有设置表示读取全部
        if (!$this->endRow) {
            return true;
        }
        //只读取指定的行
        if ($row >= $this->startRow && $row <= $this->endRow) {
            return true;
        }

        return false;
    }

}