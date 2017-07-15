<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_file($file)
{
    $CI = &get_instance();
}

function copyDirectory($source, $dest, $over = false, $dontCopy = array())
{
    $ret = true;
    if (!is_dir($dest))
        mkdir($dest);
    if ($handle = opendir($source)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path = $source . '/' . $file;
                if (is_file($path)) {
                    if (!in_array($file, $dontCopy)) {           // Проверяем, надо ли копировать этот файл
                        if (!is_file($dest . '/' . $file) || $over) {
                            if (!@copy($path, $dest . '/' . $file)) {
                                echo "Ошибка копирования файла " . $path;
                                $ret = false;
                            }
                        }
                    } else echo 'Файл ' . $file . ' не был скопирован по Вашему указанию<br/>';
                } elseif (is_dir($path)) {
                    if (!is_dir($dest . '/' . $file))
                        mkdir($dest . '/' . $file);
                    $ret = copyDirectory($path, $dest . '/' . $file, $over, $dontCopy);
                }
            }
        }
        closedir($handle);
        return $ret;
    }
}

function db_backup($path = 'upload/backups/', $filename = false, $getDownload = false)
{
    $CI = &get_instance();
    if(!$filename)
        $filename = date("Y-m-d_H-i");
    // Загружает класс DB utility

// Загружаем класс DB utility
    $CI->load->dbutil();

// Создаем бэкап текущей бд и ассоциируем его с переменной
    $backup =& $CI->dbutil->backup();

    if($getDownload){                       // Отдаём на загрузку
        // Загружаем хелпер download и отправляем бэкап пользователю
        $CI->load->helper('download');
        force_download($filename.'.gz', $backup);
    } else {                                // Сохраняем на сервере
        // Загружаем хелпер file и записываем бэкап в файл
        if (!file_exists($path))
            mkdir($path);
        $CI->load->helper('file');
        write_file($path.$filename.'.gz', $backup);
        return $path.$filename;
    }
}