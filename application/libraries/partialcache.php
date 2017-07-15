<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Этот класс представляет собой библиотеку для фреймворка CodeIgniter,
 * которая предназначена для частичного кэширования web страниц.
 *
 * Пример использования:
 *    $this->load->library('partialcache');
 *    if (($data = $this->partialcache->get('data block name', 5)) === false) {
 *        $data = ; //получение данных обычным способом (например, из БД)
 *        $this->partialcache->save('data block name', $data);
 *    }
 *  //передаем данные в представление
 *    $pageData['view_var_name'] = $data;
 *
 * Примечание: если нужно сохранять в кэше структуры данных (например, массивы),
 * то предварительно необходимо преобразовать их в строку
 * (например, с помощью функции serialize).
 *
 * Размещение кэша:
 *    указывается в $config['cache_path'] (файл application/config/config.php)
 *
 * @author Стаценко Владимир http://www.simplecoding.org <vova_33@gala.net>
 * @version 1.0
 * @package CodeIgniter Library
 */
class PartialCache
{

    function translitRuToEn($string, $max_chars = false)
    {
        $CI =& get_instance();
        $CI->load->helper('translit_helper');
        return translitRuToEn($string, $max_chars);
    }

    //папка с кэшем
    private $cacheDir = '';
    //количество попыток блокировки файла перед чтением-записью
    private $retries = 5;

    function PartialCache()
    {
        //определяем размещение папки для кэша
        $CI =& get_instance();
        $path = $CI->config->item('cache_path');
        $this->cacheDir = ($path == '') ? BASEPATH . 'cache/' : $path;
    }

    /**
     * Возвращает блок данных из кэша. Если заданный
     * блок отсутсвует, возвращает false.
     *
     * @param $name - имя блока
     * @param $time - время жизни кэша (минут)
     * @return кэшированны блок или false (если он отсутствует)
     */
    function get($name, $time = 0)
    {

        $refreshSeconds = ((!is_numeric($time)) ? 0 : $time) * 60;
        $cacheFile = $this->translitRuToEn($name);
        if (file_exists($this->cacheDir . $cacheFile) &&
            ((time() - filemtime($this->cacheDir . $cacheFile)) < $refreshSeconds)
        ) {
            //читаем данные из файла
            $fp = fopen($this->cacheDir . $cacheFile, 'rb');
            //блокируем файл для записи
            $curTry = 1;
            do {
                if ($curTry > 1) {
                    usleep(rand(100, 10000));
                }
            } while (!flock($fp, LOCK_SH) && (++$curTry <= $this->retries));

            //не смогли заблокировать файл
            if ($curTry == $this->retries) {
                return false;
            }

            //читаем данные из файла
            $cacheContent = '';
            if (filesize($this->cacheDir . $cacheFile) > 0) {
                $cacheContent = fread($fp, filesize($this->cacheDir . $cacheFile));
            }

            //снимаем блокировку
            flock($fp, LOCK_UN);
            //закрываем файл
            fclose($fp);

            return $cacheContent;
        }
        return false;
    }

    /**
     * Сохраняет блок данных в кэше
     *
     * @param $name - имя блока с кэшем
     * @param $cacheContent - содержимое блока
     * @return true - если блок сохранен, false - в противном случае
     */
    function save($name, $cacheContent)
    {
        //проверяем возможна ли запись в папку с кэшем
        if (!$this->_checkCacheDir()) {
            return false;
        }

        //открываем файл для записи
        $cacheFile = $this->translitRuToEn($name);
        //var_dump($cacheFile);
        $fp = fopen($this->cacheDir . $cacheFile, 'wb');
        if (!$fp) {
            return false;
        }

        //блокируем файл перед записью
        $curTry = 1;
        do {
            if ($curTry > 1) {
                usleep(rand(100, 10000));
            }
        } while (!flock($fp, LOCK_EX) && (++$curTry <= $this->retries));

        //не смогли заблокировать файл
        if ($curTry == $this->retries) {
            return false;
        }

        //записываем в файл
        fwrite($fp, $cacheContent);
        //снимаем блокировку и закрываем файл
        flock($fp, LOCK_UN);
        fclose($fp);
        @chmod($this->cacheDir . $cacheFile, 0777);

        log_message('debug', "Cache file written: " . $this->cacheDir . $cacheFile);

        return true;
    }

    /**
     * Проверяет возможна ли запись в папку кэша.
     * Если возможна возвращает true, если нет - false.
     *
     * @return true - если запись возможна, false - если нет
     */
    function _checkCacheDir()
    {
        if (!is_dir($this->cacheDir) OR !is_really_writable($this->cacheDir)) {
            return false;
        }
        return true;
    }
}

?>