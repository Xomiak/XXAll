<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//$CI = & get_instance();

function create_images_folder($articles, $folder_name = "images", $path = "./upload/temp/checked/")
{
    $folder_name = iconv('utf-8', 'cp1251', $folder_name);

// Очищаем временную папку
    delete_files($path, true);

    $path_img = $path . $folder_name . '/';
    if (!is_dir($path_img)) mkdir($path_img, 0777);

    if ($articles) {
        $count = count($articles);
        for ($i = 0; $i < $count; $i++) {
            $a = $articles[$i];
            if($a['image_no_logo'] != '' && $a['image_no_logo'] != NULL)
                $a['image'] = $a['image_no_logo'];
            $image = '.' . $a['image'];
            if (file_exists($image)) {

                $pos = strrpos($image, '.');
                $extension = substr($image, $pos);

                $file_name = "";
                if (($i + 1) < 10) $file_name .= "0";
                if (($i + 1) < 100) $file_name .= "0";
                $file_name .= ($i + 1) . "-";
                $file_name .= $a['articul'];
                $file_name .= '-' . $a['name'];
                $file_name .= '-' . $a['color'];


                $file_name = $a['id'].'_1';
                copy($image, $path_img . $file_name . $extension);

            }
            $CI = & get_instance();
            $CI->load->model('images');
            $images = $CI->images->getByShopId($a['id'], 1, 0);
            if(!$images) $images = $CI->images->getByShopId($a['id'], 1, 1);
            if ($images) {
                $icount = count($images);
                for ($i2 = 0; $i2 < $icount; $i2++) {
                    $image = '.' . $images[$i2]['image'];

                    $pos = strrpos($image, '.');
                    $extension = substr($image, $pos);

                    $file_name = "";
                    if (($i + 1) < 10) $file_name .= "0";
                    if (($i + 1) < 100) $file_name .= "0";
                    $file_name .= ($i + 1) . "-";
                    $file_name .= $a['articul'];
                    $file_name .= '-' . $a['name'];
                    $file_name .= '-' . $a['color'];
                    $file_name .= '-' . ($i2 + 2);


                    $file_name = $a['id'].'_'.($i2+2);
                    copy($image, $path_img . $file_name . $extension);
                }
            }
//die();
        }
    }

    return $path;
}

function create_price_xls($articles, $path = "./upload/temp/checked/", $filename = "price.xls", $save_to_file = true, $date_in_name = false)
{
    $CI = & get_instance();
    $CI->load->library('excel');
    //activate worksheet number 1
    $CI->excel->setActiveSheetIndex(0);
    //name the worksheet
    $CI->excel->getActiveSheet()->setTitle('Price');
    //set cell A1 content with some text
    $CI->excel->getActiveSheet()->setCellValue('A1', '№');
    $CI->excel->getActiveSheet()->setCellValue('B1', 'Бренд');
    $CI->excel->getActiveSheet()->setCellValue('C1', 'Номенклатура поставщика');
    $CI->excel->getActiveSheet()->setCellValue('D1', 'Код');
    $CI->excel->getActiveSheet()->setCellValue('E1', 'Код цвета');
    $CI->excel->getActiveSheet()->setCellValue('F1', 'Размер');
    $CI->excel->getActiveSheet()->setCellValue('G1', 'Размер - Украина');
    $CI->excel->getActiveSheet()->setCellValue('H1', 'Раздел Сайта');
    $CI->excel->getActiveSheet()->setCellValue('I1', 'Пол');
    $CI->excel->getActiveSheet()->setCellValue('J1', 'Тип');
    $CI->excel->getActiveSheet()->setCellValue('K1', 'Состав');
    $CI->excel->getActiveSheet()->setCellValue('L1', 'Страна произв.');
    $CI->excel->getActiveSheet()->setCellValue('M1', 'Количество');
    $CI->excel->getActiveSheet()->setCellValue('N1', 'Цена покупки');
    $CI->excel->getActiveSheet()->setCellValue('O1', 'Цена начальная');
    $CI->excel->getActiveSheet()->setCellValue('P1', 'Штрихкод');
    $CI->excel->getActiveSheet()->setCellValue('Q1', 'Короткое описание');
    $CI->excel->getActiveSheet()->setCellValue('R1', 'Полное описание');
    $CI->excel->getActiveSheet()->setCellValue('S1', 'Имена фото');
    $CI->excel->getActiveSheet()->setCellValue('T1', 'Размер на фото');
    //change the font size
    //$CI->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    //make the font become bold
    $CI->excel->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
    $CI->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    $CI->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);

    //merge cell A1 until D1
    //$CI->excel->getActiveSheet()->mergeCells('A1:D1');
    //set aligment to center for that merged cell (A1 to D1)
    $CI->excel->getActiveSheet()->getStyle('A1:Z1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $CI->excel->getActiveSheet()->getStyle('F:H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    // ЗАПОЛНЯЕМ ЗНАЧЕНИЯМИ

    if($articles)
    {
        $ii = 0;
        $CI->load->model('images');

        $currensy_grn = $CI->model_options->getOption('usd_to_uah');
        $currensy_rub = $CI->model_options->getOption('usd_to_rur');

        $count = count($articles);
        $j = 0;
        for($i = 0; $i < $count; $i++)
        {
            $a = $articles[$i];
            if($a['discount'] > 0) $a['price'] = getNewPrice($a['price'], $a['discount']);

            $create_price_percents = getOption('create_price_percents');
            if($create_price_percents)
            $a['price'] = $a['price'] + ($a['price'] * $create_price_percents/100);

            //vdd($a['price']);
            $cat = $CI->model_categories->getCategoryById($a['category_id']);
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$cat['url'].'/'.$a['url'].'/';

            //$a['razmer'] = str_replace('*',', ', $a['razmer']);
            $sizes = explode('*', $a['razmer']);
            $warehouse = json_decode($a['warehouse'],true);
            $images = $a['id'].'_1';


            $imgs = $CI->images->getByShopId($a['id'], 1);
            $img_i = 1;
            foreach ($imgs as $img)
            {
                $img_i++;
                $images .= ", ".$a['id']."_".$img_i;
            }

           // vdd($sizes);
            foreach ($sizes as $size) {
           //     vd($size);

                if($size != '' && isset($warehouse[$size]) && $warehouse[$size] != 0) {

                    //echo $a['id'].': Size: '.$size.' Kolvo'.$warehouse[$size].'<br />';
                    $n = $ii + 2;
                    $no = "";
                    if (($j + 1) < 10) $no .= "0";
                    if (($j + 1) < 100) $no .= "0";
                    $no .= ($j + 1);
                    $price1 = $a['price'] * $currensy_grn;
                    //vd($price1);
                    $price1 = round($price1, 2);
                    //vd($price1);
                    $price2 = round($price1 + 300, -1);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('A' . $n, $no, PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('B' . $n, "PEONY", PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('C' . $n, $a['name'] . ' (' . $a['color'] . ')', PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('D' . $n, "", PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('E' . $n, $a['color'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('F' . $n, $size, PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('G' . $n, $size, PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('H' . $n, "взрослое", PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('I' . $n, "женский", PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('J' . $n, $cat['name'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('K' . $n, $a['sostav'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('L' . $n, "Украина", PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('M' . $n, $warehouse[$size], PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('N' . $n, $price1, PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('O' . $n, $price2, PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('P' . $n, "", PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('Q' . $n, strip_tags($a['content']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('R' . $n, strip_tags($a['content']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('S' . $n, $images, PHPExcel_Cell_DataType::TYPE_STRING);
                    $CI->excel->getActiveSheet()->setCellValueExplicit('T' . $n, '50', PHPExcel_Cell_DataType::TYPE_STRING);

                    $ii++;
                    $j++;
                }
            }
        }
    }


    if($date_in_name) $filename = date("Y-m-d").'_'.$filename;




    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');



    if($save_to_file)
    {
        $objWriter->save($path.$filename);
    }
    else
    {
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        $objWriter->close();
    }

    return $filename;
}

function create_zip_file($path = "./upload/temp/checked/", $xlsfile = "price.xls", $folder_name = "images")
{
    $zip = new ZipArchive();
    $name = "checked_".date("YmdHi");
    $filename = "./upload/export/".$name.".zip";
    copy("./upload/temp/checked/price.xls", "./upload/export/".$name.".xls");
    if(is_file($filename))
        @unlink($filename);

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("Невозможно открыть <$filename>\n");
    }

    $zip->addFile($path.$xlsfile, $xlsfile);

    $files = get_filenames($path.$folder_name);

    $count = count($files);
    for($i = 0; $i < $count; $i++)
    {
        $f = $files[$i];
        $file = $path.$folder_name.'/'.$f;
        $zip->addFile($file, $folder_name.'/'.$f);
    }

    echo "Добавлено файлов в архив: " . $zip->numFiles;
    $zip->close();

    return $name;
}