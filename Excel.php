<?php
/**
 * User: Roc.xu
 * Date: 2017/4/18
 * Time: 12:05
 */

namespace RocExcel;

use RocExcel\vendor\PHPExcelReadFilter;

require_once __DIR__.'/vendor/PHPExcel/Classes/PHPExcel.php';

class Excel
{


    public static function getExcel($path){
        $excel_type = \PHPExcel_IOFactory::identify($path);
        $excel_reader = \PHPExcel_IOFactory::createReader($excel_type);
        $worksheetNames = $excel_reader->listWorksheetNames($path);
        return $worksheetNames;
    }

    public function readExcel($path,$sheet='',$start_row=1,$end_row=50){
        $end_row += $start_row;
        if (empty($path)||!file_exists($path)){
            return [
                'error' => 'excel路径不能为空'
            ];
        }
        //返回文件的小写后缀名
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension,['xlsx','xls'])){
            $excel_type = \PHPExcel_IOFactory::identify($path);
            $excel_reader = \PHPExcel_IOFactory::createReader($excel_type);
            $worksheetNames = $excel_reader->listWorksheetNames($path);

            $excel_reader->setReadDataOnly(true);
            $excel_reader->setLoadSheetsOnly([$worksheetNames[$sheet]]);

            $excel_filter = new PHPExcelReadFilter();
            $excel_filter->startRow = $start_row;
            $excel_filter->endRow = $end_row;
            $excel_reader->setReadFilter($excel_filter);

            $php_excel = $excel_reader->load($path);
            $active_sheet = $php_excel->getActiveSheet();

            $highestColumn = $active_sheet->getHighestColumn();
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

            $data = [];
            for ($row = $start_row;$row <= $end_row;$row++){
                for ($col = 0; $col < $highestColumnIndex; $col++){
                    $data[$row][] = (string)$active_sheet->getCellByColumnAndRow($col,$row)->getValue();
                }
                if (implode($data[$row],'')==''){
                    unset($data[$row]);
                }
            }
            unset($php_excel);
            return $data;
        }else{
            return [
                'error' => '无法识别的文件（仅支持xlsx，xls等文件格式）'
            ];
        }
    }



}