<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/PHPExcel.php";
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }

    function getExcelArray($filepath)
    {

        $ar = array(); // инициализируем массив

        $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
        $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив

        return $ar; //возвращаем массив
    }
    
    function setExcelArray($arr, $file_path = false)
    {

        $count = count($arr);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $active_sheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->createSheet();

        //Ориентация страницы и  размер листа
        $active_sheet->getPageSetup()
            ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $active_sheet->getPageSetup()
            ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
//Поля документа
        $active_sheet->getPageMargins()->setTop(1);
        $active_sheet->getPageMargins()->setRight(0.75);
        $active_sheet->getPageMargins()->setLeft(0.75);
        $active_sheet->getPageMargins()->setBottom(1);
//Название листа
        $active_sheet->setTitle("Прайс-лист");
//Шапа и футер
        $active_sheet->getHeaderFooter()->setOddHeader("&CШапка нашего прайс-листа");
        $active_sheet->getHeaderFooter()->setOddFooter('&L&B'.$active_sheet->getTitle().'&RСтраница &P из &N');
//Настройки шрифта
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
        
        // Добавляем поля
        $first = $arr[0];
        $i = 0;
        foreach ($first as $item)
        {
            if($item == 'category_id')
            {
                $active_sheet->getStyle(getLetterByNum($i))->getNumberFormat()->
                setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            }
            if($i == 0) $active_sheet->getColumnDimension(getLetterByNum($i))->setWidth(4);
            else $active_sheet->getColumnDimension(getLetterByNum($i))->setWidth(40);
            $active_sheet->setCellValue(getLetterByNum($i).'1',$item);
            $i++;
        }

        for($i = 1; $i < $count; $i++){
            $row = $arr[$i];
            $j = 0;
            foreach ($row as $item)
            {
                $active_sheet->setCellValue(getLetterByNum($j).($i+1),$item);
                $j++;
            }
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // Проверяем, сохранить в файл или вывести
        if($file_path){
            $objWriter->save('./upload/temp/import.xlsx');
        }else{
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="export.xlsx"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
//            $objWriter->close();
        }
//        header("Content-Type:application/vnd.ms-excel");
//        header("Content-Disposition:attachment;filename='simple.xls'");





    }
}