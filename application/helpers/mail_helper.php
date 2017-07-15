<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


function mail_send($to, $subject, $msg, $attach = false)
{
    $CI = & get_instance();
    $CI->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = getOption('smtp_host');
    $config['smtp_user'] = getOption('smtp_user');
    $config['smtp_pass'] = getOption('smtp_pass');
    $config['smtp_port'] = getOption('smtp_port');
    
    $config['mailtype'] = 'html';
    
    @$CI->email->initialize($config);
    
    @$CI->email->from(getOption('smtp_user'), $_SERVER['SERVER_NAME']);
    @$CI->email->to($to);
    
    @$CI->email->subject($_SERVER['SERVER_NAME'].' - '.$subject);
    @$CI->email->message($msg);
    if($attach)
        @$CI->email->attach($_SERVER['DOCUMENT_ROOT'].$attach);
    $ret = @$CI->email->send();
//$ret = false;

    if(!$ret)
    {
        $file = false;
        $file_name = false;
        if ($attach) {
            $fp = fopen($_SERVER['DOCUMENT_ROOT'].$attach, "rb");
            if (!$fp) {
                print "Cannot open file";
                exit();
            }
            $file = fread($fp, filesize($_SERVER['DOCUMENT_ROOT'].$attach));
            fclose($fp);

            $pos = strripos($attach, '.');
            if($pos) {
                $ext = substr($attach,($pos));
                $file_name = $subject.$ext;
            }
        }
        $EOL = "\r\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
        $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных.
        $headers    = "MIME-Version: 1.0;$EOL";
        $headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";
        $headers   .= "From: no-reply@".$_SERVER['SERVER_NAME'];

        if($attach) {
            $multipart = "--$boundary$EOL";
            $multipart .= "Content-Type: text/html; charset=UTF-8$EOL";
            $multipart .= "Content-Transfer-Encoding: base64$EOL";
            $multipart .= $EOL; // раздел между заголовками и телом html-части
            $multipart .= chunk_split(base64_encode($msg));

            $multipart .= "$EOL--$boundary$EOL";
            $multipart .= "Content-Type: application/octet-stream; name=\"$file_name\"$EOL";
            $multipart .= "Content-Transfer-Encoding: base64$EOL";
            $multipart .= "Content-Disposition: attachment; filename=\"$file_name\"$EOL";
            $multipart .= $EOL; // раздел между заголовками и телом прикрепленного файла
            $multipart .= chunk_split(base64_encode($file));

            $multipart .= "$EOL--$boundary--$EOL";

            $ret = mail($to, $_SERVER['SERVER_NAME'] . ' - ' . $subject, $multipart, $headers);
        } else{
            $ret = mail($to, $_SERVER['SERVER_NAME'] . ' - ' . $subject, $msg, $headers);
        }

    }
    //vd($ret);die();
    return $ret;
    //echo $this->email->print_debugger();
}


