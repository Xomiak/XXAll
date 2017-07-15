<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include X_PATH.'/ResizeImage.php';
include X_PATH.'/ImageResize.php';


function testCrop($image_path, $width, $height,  $directory = false)
{
    $image= $_SERVER['DOCUMENT_ROOT'].$image_path;
    $size = getimagesize ($image);
    $w = $size[0];
    $h = $size[1];
    $dir = "/upload/thumbs/";

    if ( $w == $width && $h == $height) return $image_path;
    else
    {
        $center = new CropCenter($_SERVER['DOCUMENT_ROOT'].$image_path);
        $center->resizeAndCrop($width, $height);
        $b = explode('/', $image);
        $c = array_pop($b);

        if($directory == false)
        {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$dir."/".$width."x".$height))
                mkdir($_SERVER['DOCUMENT_ROOT'].$dir."/".$width."x".$height, 0777, true);
            $center->writeimage($_SERVER['DOCUMENT_ROOT'].$dir."/".$width."x".$height."/".$c);  // r - resised

            return $dir.$width."x".$height."/".$c;
        }
        else
        {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$directory))
                mkdir($_SERVER['DOCUMENT_ROOT'].$directory, 0777, true);
            $center->writeimage($_SERVER['DOCUMENT_ROOT'].$directory."/".$c);
            return $directory."/".$c;
        }
    }
}

function resizeImage($image_path, $width, $height,  $directory = false)// ресайзит по отношению сторон
{
    $image= $_SERVER['DOCUMENT_ROOT'].$image_path;
    $size = getimagesize ($image);
    $w = $size[0];
    $h = $size[1];
    $dir = "/upload/thumbs/";

    if ( $w == $width && $h == $height) return $image_path;
    else
    {
        $resize = new ResizeImage($_SERVER['DOCUMENT_ROOT'].$image_path);
        $resize->resizeTo($width, $height);
        $b = explode('/', $image);
        $c = array_pop($b);

        if($directory == false)
        {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$dir."/".$width."x".$height))
                mkdir($_SERVER['DOCUMENT_ROOT'].$dir."/".$width."x".$height, 0777, true);
            $resize->saveImage($_SERVER['DOCUMENT_ROOT'].$dir."/".$width."x".$height."/".$c);  // r - resised

            return $dir.$width."x".$height."/".$c;
        }
        else
        {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$directory))
                mkdir($_SERVER['DOCUMENT_ROOT'].$directory, 0777, true);
            $resize->saveImage($_SERVER['DOCUMENT_ROOT'].$directory."/".$c);
            return $directory."/".$c;
        }
    }
}

function cropImage($image_path, $width, $height,  $directory = false) // выдает картинку по заданным параметрам, обрезая лишнее (от центра)
{
    $image= $_SERVER['DOCUMENT_ROOT'].$image_path;
    $size = getimagesize ($image);
    $w = $size[0];
    $h = $size[1];
    $dir = "/upload/thumbs";

    if ( $w == $width && $h == $height) return $image_path;
    else
    {
        $crop = new \Eventviva\ImageResize($image);
        $crop->crop($width, $height);
        $b = explode('/', $image);
        $c = array_pop($b);

        if($directory == false)
        {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$width."x".$height))
                mkdir($_SERVER['DOCUMENT_ROOT'].$dir.$width."x".$height, 0777, true);
            $crop->save($_SERVER['DOCUMENT_ROOT'].$dir.$width."x".$height."/".$c);  // c - cropped
            return $dir.$width."x".$height."/".$c;
        }
        else
        {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$directory))
                mkdir($_SERVER['DOCUMENT_ROOT'].$directory, 0777, true);
            $crop->save($_SERVER['DOCUMENT_ROOT'].$directory."/".$c);  // c - cropped
            return $directory."/".$c;
        }
    }

}

function createOgImage($config = false, $toFile = false){

    $CI = & get_instance();

    if(!isset($config['name'])) $config['name'] = '';
    if(!isset($config['nameFont'])) $config['nameFont'] = "/fonts/OswaldBold.ttf";
    if(!isset($config['nameFontSize'])) $config['nameFontSize'] = 30;
    if(!isset($config['nameColor'])) $config['nameColor'] = array(2,158,207);
    if(!isset($config['description'])) $config['description'] = '';
    if(!isset($config['descriptionFont'])) $config['descriptionFont'] = "/fonts/RobotoRegular.ttf";
    if(!isset($config['descriptionFontSize'])) $config['descriptionFontSize'] = 22;
    if(!isset($config['descriptionColor'])) $config['descriptionColor'] = array(0,91,187);
    if(!isset($config['date'])) $config['date'] =  '';
    if(!isset($config['dateFont'])) $config['dateFont'] =  "/fonts/RobotoRegular.ttf";
    if(!isset($config['dateFontSize'])) $config['dateFontSize'] =  16;
    if(!isset($config['dateColor'])) $config['dateColor'] =  array(150,150,150);
    if(!isset($config['domain'])) $config['domain'] = $_SERVER['SERVER_NAME'];
    if(!isset($config['domainFont'])) $config['domainFont'] = "/fonts/OswaldBold.ttf";
    if(!isset($config['domainFontSize'])) $config['domainFontSize'] = 16;
    if(!isset($config['domainShow'])) $config['domainShow'] = false;
    if(!isset($config['domainColor'])) $config['domainColor'] = array(71,71,71);
    if(!isset($config['bgImage'])) $config['bgImage'] = getOption('og_backgroud_image');
    if(!$config['bgImage']) $config['bgImage'] = '/img/og_fon_white.jpg';
    if(!isset($config['saveToFile'])) $config['saveToFile'] = false;
    if(!$config['saveToFile']) $config['saveToFile'] = $toFile;
    if(!isset($config['type'])) $config['type'] = 'articles';
    if(!isset($config['fileName'])) $config['fileName'] = '';

    if(isset($config['article_id']) && $config['name'] == ''){
        $CI->load->model('Model_articles','articles');
        $article = $CI->articles->getArticleById($config['article_id']);
        if($article){
            if(!isset($config['category_id'])) $config['category_id'] = $article['category_id'];
            $config['name'] = getLangText($article['name']);
        }
    }
    if(isset($config['product_id']) && $config['name'] == ''){
        $CI->load->model('Model_products','products');
        $product = $CI->products->getProductById($config['product_id']);
        if($product){
            if(!isset($config['category_id'])) $config['category_id'] = $product['category_id'];
            $config['name'] = getLangText($product['name']);
        }
    }
    if(isset($config['category_id']) && $config['description'] == ''){
        $category = $CI->model_categories->getCategoryById($config['category_id']);
        if($category)
            $config['description'] = getLangText($category['name']);
    }


    $im = imageCreateFromPNG('.'.$config['bgImage']);

    $nameColor = $config['nameColor'];
    $descriptionColor = $config['descriptionColor'];
    $dateColor = $config['dateColor'];
    $domainColor = $config['domainColor'];
    $colorName = ImageColorAllocate($im, $nameColor[0], $nameColor[1], $nameColor[2]);
    $colorDescription = ImageColorAllocate($im, $descriptionColor[0], $descriptionColor[1], $descriptionColor[2]); //получаем идентификатор цвета RGB
    $colorDate = imagecolorallocate($im, $dateColor[0], $dateColor[1], $dateColor[2]);
    $colorDomain = imagecolorallocate($im, $domainColor[0], $domainColor[1], $domainColor[2]);

    $textName = $config['name'];
    $textDescription = $config['description'];
    if($textName == '' && $textDescription != '') {
        $textName = $textDescription;
        $textDescription = '';
    }
    $textDate = $config['date'];
    $textDomain = '';
    if($config['domainShow'])
        $textDomain = $config['domain'];

    ////////////////////////////////
    // РАЗБИВАЕМ ТЕКСТ НА СТРОКИ
    $arr = explode(' ', $textName);
    // Возращенный текст с нужными переносами строк, пока пустая
    $ret = "";
    $width_text = imagesx($im) - 100;
    $height_text = 150;
    $font_size = $config['nameFontSize'];
    $rowsCount = 1;
// Перебираем наш массив слов
    $arrCount = count($arr);
    for($i = 0; $i < $arrCount; $i++)
        //foreach($arr as $word)
    {
        $word = $arr[$i];
        // Временная строка, добавляем в нее слово
        $tmp_string = $ret.' '.$word;

        // Получение параметров рамки обрамляющей текст, т.е. размер временной строки
        $textbox = imagettfbbox($config['nameFontSize'], 0, $_SERVER['DOCUMENT_ROOT'].$config['nameFont'], $tmp_string);

        // Если временная строка не укладывается в нужные нам границы, то делаем перенос строки, иначе добавляем еще одно слово
        if($textbox[2] > $width_text) {
            $ret .= ($ret == "" ? "" : "\n") . $word;
            $rowsCount++;
        }
        else
            $ret.=($ret==""?"":" ").$word;

        // Проверяем высоту
        if($textbox[3] > $height_text){
            $font_size = $font_size - 2;
            //      vd($textbox[3]);
            $ret = "";
            $i = -1;
        }
    }
    //vdd($font_size);
    $textName = $ret;

    $startY = 60;
    if ($rowsCount == 1)
        $startY = 150;
    elseif ($rowsCount >= 2)
        $startY = 130;


    imageTTFText($im, $config['nameFontSize'], 0, 20, $startY, $colorName, $_SERVER['DOCUMENT_ROOT'].$config['nameFont'], $textName);
    if($textDescription != '')
        imageTTFText($im, $config['descriptionFontSize'], 0, 160, 75, $colorDescription, $_SERVER['DOCUMENT_ROOT'].$config['descriptionFont'], $textDescription);
    if($textDate != '')
        imageTTFText($im, $config['dateFontSize'], 0, 460, 30, $colorDate, $_SERVER['DOCUMENT_ROOT'].$config['dateFont'], $textDate);
    if($textDomain != '')
        imageTTFText($im, $config['domainFontSize'], 0, 20, 300, $colorDomain, $_SERVER['DOCUMENT_ROOT'].$config['domainFont'], $textDomain);


    //vdd($im);
    if($config['saveToFile']) {
        $path = '';
        if(isset($config['path'])) $path = '.'.$config['path'];
        else {
            $path = '/upload/' . $config['type'] . '/';
            if (!file_exists($path))
                mkdir($path);
            if ($textDate != '') $path .= $textDate . '/';
            else $path .= 'no_date' . '/';
            if (!file_exists($path))
                mkdir($path);
            $ext = '.png';

            $fileName = $config['fileName'];
            if($fileName == ''){
                $CI->load->helper('translit_helper');
                $fileName = translitRuToEn($textName);

                while(!file_exists('.'.$path.$fileName.$ext)){
                    $fileName .= '-1';
                }
            }
            if (!file_exists($path))
                mkdir($path);

            $path = $path . $fileName . $ext;
        }



        if(file_exists($path)) {
            $ret = Imagepng($im, $path);

            $filePath = substr($path, 1);

            imageDestroy($im);

            //echo $filePath;
            if ($ret) return $filePath;
        }

        return false;
    } else {
        header('Content-Type: image/png');
        Imagepng($im);
        imageDestroy($im);
    }
}

function createImageForArticle($article, $bgImage = false, $saveToFile = true){
    if(!$bgImage) $bgImage = getOption('og_backgroud_image');
    if($bgImage[0] == '/') $bgImage = substr($bgImage,1);


    $im = imageCreateFromPNG($bgImage);

    $color0 = ImageColorAllocate($im, 2, 158, 207);
    $color1 = ImageColorAllocate($im, 0, 91, 187); //получаем идентификатор цвета RGB
    $color2 = imagecolorallocate($im, 150, 150, 150);
    $color3 = imagecolorallocate($im, 71, 71, 71);

    $CI = & get_instance();

    $cat = $CI->model_categories->getCategoryById($article['category_id']);

    $text1 = $cat['name'];
    $text1 = $text1;

//    $darr = false;
//    $tarr = false;
//    $arr = explode(' ', $article['date']);
//    if(is_array($arr)){
//        if(isset($arr[0]))
//            $darr = explode('-', $arr[0]);
//        if(isset($arr[1]))
//            $tarr = explode(':', $arr[1]);
//    }

    $text2 = $article['date'];
    $text3 = $article['name'];
    ////////////////////////////////
    // РАЗБИВАЕМ ТЕКСТ НА СТРОКИ
    $arr = explode(' ', $text3);
    // Возращенный текст с нужными переносами строк, пока пустая
    $ret = "";
    $width_text = imagesx($im) - 100;
    $height_text = 150;
    $font_size = 30;
    $rowsCount = 1;
// Перебираем наш массив слов
    $arrCount = count($arr);
    for($i = 0; $i < $arrCount; $i++)
    //foreach($arr as $word)
    {
        $word = $arr[$i];
        // Временная строка, добавляем в нее слово
        $tmp_string = $ret.' '.$word;

        // Получение параметров рамки обрамляющей текст, т.е. размер временной строки
        $textbox = imagettfbbox($font_size, 0, $_SERVER['DOCUMENT_ROOT']."/fonts/Bebas/Bebas Neue Bold.ttf", $tmp_string);

        // Если временная строка не укладывается в нужные нам границы, то делаем перенос строки, иначе добавляем еще одно слово
        if($textbox[2] > $width_text) {
            $ret .= ($ret == "" ? "" : "\n") . $word;
            $rowsCount++;
        }
        else
            $ret.=($ret==""?"":" ").$word;

        // Проверяем высоту
        if($textbox[3] > $height_text){
            $font_size = $font_size - 2;
      //      vd($textbox[3]);
            $ret = "";
            $i = -1;
        }
    }
    //vdd($font_size);
    $text3 = $ret;

    $startY = 60;
    if ($rowsCount == 1)
        $startY = 130;
    elseif ($rowsCount >= 2)
        $startY = 80;

    imageTTFText($im, 16, 0, 20, 30, $color0, $_SERVER['DOCUMENT_ROOT']."/fonts/RobotoRegular.ttf", getOption('og_image_www'));
    //imageTTFText($im, 16, 0, 450, 30, $color1, $_SERVER['DOCUMENT_ROOT']."/fonts/RobotoRegular.ttf", $text1);
    //imageTTFText($im, 15, 0, 520, 144, $color2, $_SERVER['DOCUMENT_ROOT']."/fonts/Bebas/Bebas Neue Bold.ttf", $text2);
    imageTTFText($im, $font_size, 0, 20, $startY, $color3, $_SERVER['DOCUMENT_ROOT']."/fonts/OswaldBold.ttf", $text3);
    //vdd($im);
    if($saveToFile) {
        $path = './upload/articles/' . $article['date'] . '/';
        if (!file_exists($path))
            mkdir($path);
        $image_file = 'noimage_' . $article['id'] . '.png';
        $ret = Imagepng($im, $path . $image_file);

        $filePath = '/upload/articles/' . $article['date'] . '/'.$image_file;

        imageDestroy($im);

        if($ret) return $filePath;

        return false;
    } else {
        header('Content-Type: image/png');
        Imagepng($im);
        imageDestroy($im);
    }
}

function getOgImage($item, $type = 'articles', $saveToFile = true){
    $ogPath = false;
    if($item['image'] == ''){
        $ogPath = '/upload/'.$type.'/og/'.$item['id'].'.png';
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$ogPath)){

            $config = array(
                substr($type,0,-1).'_id' => $item['id'],
                'path'      => $ogPath

            );
            //vdd($config);
            $ogPath = CreateOgImage($config, $saveToFile);
        }
    } else $ogPath = $item['image'];

    return $ogPath;
}

function createImageForOg($name, $description, $bgImage = false, $saveToFile = true){
    if(!$bgImage) $bgImage = getOption('og_backgroud_image');
    $filename = md5($name.$description);
    $im = imageCreateFromPNG($bgImage);

    $description = strip_tags($description);
    $description = str_replace('&nbsp;','', $description);

    $color = ImageColorAllocate($im, 23, 104, 105); //получаем идентификатор цвета RGB

    $CI = & get_instance();


    if(isset($_GET['test'])) {

        $logoPath = '/upload/articles/2016-09-21/8082f6e656fd2956299dff570e7a922b.png';
        $logo = false;

        switch ( strtolower(strrchr($logoPath, '.')) ){
            case ".jpg":
                $logo = @ImageCreateFromJPEG(".".$logoPath);
                break;
            case ".gif":
                $logo = @ImageCreateFromGIF(".".$logoPath);
                break;
            case ".png":
                $logo = @ImageCreateFromPNG(".".$logoPath);
                break;
            default:
                vdd("fuck");
        }
        $srcWidth = ImageSX($logo);
        $srcHeight = ImageSY($logo);

        // задание максимальной ширины и высоты
        $width = 100;
        $height = 100;

        list($width_orig, $height_orig) = getimagesize(".".$logoPath);
        $ratio_orig = $width_orig/$height_orig;
        if ($width/$height > $ratio_orig) {
            $width = $height*$ratio_orig;
        } else {
            $height = $width/$ratio_orig;
        }

        $all = imagecreatetruecolor(700,350);
        imagealphablending($all, false);
        imagesavealpha($all, true);
        imagecopyresampled($all,$im,0,0,0,0,700,350,700,350);


        $image_p = imagecreatetruecolor($width, $height);
        imagealphablending($image_p, false);
        imagesavealpha($image_p, true);

        imagealphablending($logo, false);
        imagesavealpha($logo, true);

        //imagecopyresampled($image_p, $logo, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        imagecopyresampled($all, $logo, 0,0,0,0,100,100,$width,$height);
        header('Content-Type: image/png');
        Imagepng($all);

//        if($srcWidth > 100 || $srcHeight > 100){
//            imagecopyresampled($logo, $logo, 0,0,0,0,100,100,$srcWidth,$srcHeight);
//            header('Content-Type: image/png');
//            Imagepng($logo);
//
//        }
        //imagecopy($im, $logo,0,0,0,0,100,100);
    }

    ////////////////////////////////
    // РАЗБИВАЕМ ТЕКСТ НА СТРОКИ
    //$description = "Возращенный текст с нужными переносами строк, пока пустая. Временная строка, добавляем в нее слово";
    $arr = explode(' ', $description);
    // Возращенный текст с нужными переносами строк, пока пустая

    $ret = "";
    $description_width_text  = imagesx($im) - 20;
    $name_width_text = 540;
    $height_text = 150;
    $name_font_size = 100;
    $description_font_size = 28;
    $name_start_y = 70;
    $rowsCount = 1;
    $description_start_y = 200;
    // Подгоняем размер шрифта названия
    $normsizeName = false;
    $aaa = false;
    while(!$normsizeName){
        if($name_font_size <= 20){
            $name_start_y = 43;
            $normsizeName = true;
            //$name_width_text = $name_width_text - 120;
            $name = getRowsText($name, $name_width_text, $height_text, "\n", $name_font_size,"/fonts/Bebas/Bebas Neue Bold.ttf");

        } else {
            $textbox = imagettfbbox($name_font_size, 0, $_SERVER['DOCUMENT_ROOT'] . "/fonts/Bebas/Bebas Neue Light.ttf", $name);
            $aaa = $textbox;
            if ($textbox[2] > $name_width_text) {
                $name_font_size = $name_font_size - 2;
            } else {
                $normsizeName = true;
                //vdd($name_font_size);
            }

            if($textbox[3] < 60) $description_start_y = 150;
            //
        }
    }
    if(count(explode(' ', $name)) > 5) $description_start_y = 200;
    //vdd($aaa);
    if($name_font_size > 60) $name_start_y = 100;
   // vdd($name_font_size);
    // Подгоняем размер шрифта описания
    $normsizeDescription = false;
    while(!$normsizeDescription){
        if($name_font_size <= 20){
            $name_start_y = 43;
            $normsizeDescription = true;
            //$name_width_text = $name_width_text - 120;
            $description = getRowsText($description, $description_width_text, $height_text, "\n", $description_font_size,"/fonts/Bebas/Bebas Neue Bold.ttf");

        } else {
            $textbox = imagettfbbox($description_font_size, 0, $_SERVER['DOCUMENT_ROOT'] . "/fonts/Bebas/Bebas Neue Bold.ttf", $name);
            if ($textbox[2] > $name_width_text) {
                $description_font_size = $description_font_size - 2;
            } else {
                $normsizeDescription = true;
                //vdd($name_font_size);
            }
            //$description_start_y = $textbox[1] + (imagesy($im) / 2) - ($textbox[5] / 2) - 5;
        }
    }
    // Перебираем наш массив слов
    if($description_font_size > $name_font_size)
        $description_font_size = $name_font_size;

    $description = getRowsText($description, $description_width_text, $height_text,"\n",$description_font_size);
//vdd($description_width_text);

//    if ($name_font_size < 50)
//        $description_start_y = 200;


    imageTTFText($im, $name_font_size, 0, 20, $name_start_y, $color, $_SERVER['DOCUMENT_ROOT']."/fonts/Bebas/Bebas Neue Bold.ttf", $name);
    imageTTFText($im, $description_font_size, 0, 20, $description_start_y, $color, $_SERVER['DOCUMENT_ROOT']."/fonts/Bebas/Bebas Neue Light.ttf", $description);

    if($saveToFile) {
        //vdd('zxc');
        $path = './upload/articles/og/';
        if (!file_exists($path))
            mkdir($path);
        $image_file = $filename . '.png';
        $ret = Imagepng($im, $path . $image_file);

        imageDestroy($im);

        return $ret;
    } else {
        //vdd("asfd");
        header('Content-Type: image/png');
        Imagepng($im);
        imageDestroy($im);
    }
}



function getImageForOg($name, $description, $saveToFile = true){
    $path = '/upload/articles/og/';
    $image_file = md5($name.$description) . '.png';
    if(!file_exists($_SERVER['DOCUMENT_ROOT'].$path.$image_file)){
        $ret = createImageForOg($name, $description, './img/no_image_fon.png', $saveToFile);
    }

    return $path.$image_file;
}

// THUMBS:
//myinclude(X_PATH.'/application/thumbs/ThumbLib.inc.php',false);
function CreateThumb($sizex, $sizey, $image, $folder)
{

    if (imageSizeVerify($image, $sizex, $sizey)) {
        return $image;
    } else {
        $filethumb = false;

        if ($sizex > 0 && $sizey > 0 && !empty($image) && file_exists('.' . $image) && !empty($folder)) {
            if (!is_dir('./upload/thumbs/' . $folder))
                mkdir('./upload/thumbs/' . $folder, 0777);

            $ex = explode('.', $image);
            $ex = $ex[count($ex) - 1];

            $filename = explode('/', $image);
            $filename = $filename[count($filename) - 1];

            $filethumb = '/upload/thumbs/' . $folder . '/' . $sizex . '_' . $sizey . '_' . $filename;

            if (!file_exists('.' . $filethumb)) {
                $thumb = PhpThumbFactory::create('.' . $image);
                $thumb->adaptiveResize($sizex, $sizey);
                $thumb->save('.' . $filethumb, $ex);
            }
        }

        return $filethumb;
    }
}

function CreateThumb2($sizex, $sizey, $image, $folder)
{
    return $image;
    if (imageSizeVerify($image, $sizex, $sizey)) {
        return $image;
    } else {
        $filethumb = false;

        if ($sizex > 0 && $sizey > 0 && !empty($image) && file_exists('.' . $image) && !empty($folder)) {
            if (!is_dir('./upload/thumbs/' . $folder))
                mkdir('./upload/thumbs/' . $folder, 0777);

            $ex = end(explode('.', $image));
            $filename = end(explode('/', $image));
            $filethumb = '/upload/thumbs/' . $folder . '/' . $sizex . '_' . $sizey . '_' . $filename;

            if (!file_exists('.' . $filethumb)) {
                $thumb = PhpThumbFactory::create('.' . $image);
                $thumb->resize($sizex, $sizey);
                $thumb->save('.' . $filethumb, $ex);
            }
        }

        return $filethumb;
    }
}

function is_image($filename)
{
    $img = @getimagesize($filename);
    if (!$img) return false;
    elseif (!array_key_exists($img[2], array('1' => 'gif', '2' => 'jpg', '3' => 'png'))) return false;
    else return true;
}

function imageSizeVerify($image, $width, $height)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . $image;
    //$img_size = getimagesize("http://".$_SERVER['SERVER_NAME'].$image);
    if ((file_exists($file) && is_image($file))) {
        $img_size = getimagesize($file);
        if (is_array($img_size)) {
            $w = $img_size[0];
            $h = $img_size[1];

            if ($w == $width && $h == $height) return true;
        }
    }
    return false;
}


function uploadFile($config = array('name' => false, 'file' => 'userfile','type' => 'articles', 'encrypt_name' => true))
{
    $type = 'articles';
    if(isset($config['type'])) $type = $config['type'];
    $file = 'userfile';
    if(isset($config['file'])) $file = $config['file'];
    $encrypt_name = true;
    if(isset($config['encrypt_name'])) $encrypt_name = $config['encrypt_name'];
    $name = false;
    if(isset($config['name'])) $name = $config['name'];
    elseif($encrypt_name == true) $name = time();
    $dontResize = false;
    if(isset($config['dontResize'])) $dontResize = $config['dontResize'];
    $watermark = false;
    if(isset($config['watermark'])) $watermark = $config['watermark'];

    $fileExtantion = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);


    // Проверка наличия папки текущей даты. Если нет, то создать
    $path = 'upload/' . $type . '/' . date("Y-m-d") . '/';
    if (!file_exists('./'.$path)) {
        /** проверяем и при необходимости создаём весь путь */
        $arr = explode('/', $path);
        $curr=array();
        foreach($arr as $key => $val){
            $curr[] = $val;
            if (!file_exists('./'.implode('/',$curr)."/")) {
                mkdir('./'. implode('/', $curr) . "/", 0755);
            }
        }
        mkdir( './'.$path, 0755);
    }

    $config['file_name'] = createFilename($name, $fileExtantion, $type);
    //vdd($config['file_name']);
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'jpg|png|gif|jpe|pdf|doc|docx|xls|xlsx';
    $config['max_size'] = '0';
    $config['max_width'] = '0';
    $config['max_height'] = '0';
    $config['encrypt_name'] = $encrypt_name;
    $config['overwrite'] = true;
    //vdd($config);

    $CI = &get_instance();

    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload($file)) {
        echo $CI->upload->display_errors();
        die();
    } else {
        $ret = $CI->upload->data();
        $ret['file_url'] = '/'.$path.$ret['file_name'];

        /** проверяем, картинка ли это и надо ли изменять её размеры */
        if ($ret['is_image'] == true/* && $ret['image_type'] != 'png'*/ && $dontResize != true) {
            $width = false;
            $height = false;
            if (isset($config['width']) && isset($config['height'])) {
                $width = $config['width'];
                $height = $config['height'];
            }
            if (!$width && !$height) {
                $width = getOption($type . '_foto_max_width');
                $height = getOption($type . '_foto_max_height');
            }

            if ($width != false && $height != false) {
                if (($ret['image_width'] != '') && $ret['image_width'] < $width)
                    $width = $ret['image_width'];
                if (($ret['image_height'] != '') && $ret['image_height'] < $height)
                    $height = $ret['image_height'];

                $config['width'] = $width;
                $config['height'] = $height;

                $config['image_library'] = 'GD2';
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = TRUE;

                $config['source_image'] = $ret["file_path"] . $ret['file_name'];
                $config['new_image'] = $ret["file_path"] . $ret['file_name'];
                $config['thumb_marker'] = '';
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();
            }
        }

        // Проверяем нужен ли водяной знак на картинках в статьях
        if($watermark == true){
            // Получаем файл водяного знака
            $watermark_file = getOption('watermark_file');
            if ($watermark_file === false)
                $watermark_file = 'img/logo.png';
            /** проверяем, есть ли физически файл вотермарка */
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$watermark_file)) {
                // Получаем вертикальную позицию водяного знака
                $watermark_vertical_alignment = getOption('watermark_vertical_alignment');
                if ($watermark_vertical_alignment === false)
                    $watermark_vertical_alignment = 'bottom';
                // Получаем горизонтальную водяного знака
                $watermark_horizontal_alignment = getOption('watermark_horizontal_alignment');
                if ($watermark_horizontal_alignment === false)
                    $watermark_horizontal_alignment = 'center';
                //
                // Получаем прозрачность водяного знака
                $watermark_opacity = getOption('watermark_opacity');
                if ($watermark_opacity === false)
                    $watermark_opacity = '20';
                //

                $config['source_image'] = $ret["file_path"] . $ret['file_name'];
                $config['create_thumb'] = FALSE;
                $config['wm_type'] = 'overlay';
                $config['wm_type'] = 'overlay';
                $config['wm_opacity'] = $watermark_opacity;
                $config['wm_overlay_path'] = $watermark_file;
                $config['wm_hor_alignment'] = $watermark_horizontal_alignment;
                $config['wm_vrt_alignment'] = $watermark_vertical_alignment;
                $CI->image_lib->initialize($config);
                $CI->image_lib->watermark();
            }
        }

        //vdd($ret);
        return $ret;
    }
}
