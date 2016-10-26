<?php
namespace Uni\WebDav;
class WebDavLog{
    private $_logFile;
    private $_logName;
    private $_send_mail;
    function __construct(){
        $this->_send_mail = false;

        $logName = basename(__FILE__, ".php");

        $file = WebDavConfigurator::getInstance()->getLogFolder().date("m.Y")."/".date("d.m.Y").".log";
        $this->CheckDirPath($file);

        $this->_logFile = fopen($file, "a+");
        $this->_logName =  $logName;
    }
    function __destruct(){
        fclose($this->_logFile);
    }
    function Add($message, $arParams=""){
        $message = date("d.m.Y H:i:s")."\t".$message."\n";
        if($arParams && is_array($arParams)){
            $message.=	print_r($arParams,true);
        }
        $message .= "\n";
        fwrite($this->_logFile, $message);
    }
    function AddError($message, $arParams = false){
        $message = "[ERROR]\t".$message;
        $this->Add($message, $arParams);
    }
    function AddSuccess($message, $arParams = false){
        $message = "[SUCCESS]\t".$message;
        $this->Add($message, $arParams);
    }
    function AddNotice($message, $arParams = false){
        $message = "[NOTICE]\t".$message;
        $this->Add($message, $arParams);
    }
    function CheckDirPath($path, $bPermission=true)
    {
        $path = str_replace(array("\\", "//"), "/", $path);

        //remove file name
        if(substr($path, -1) != "/")
        {
            $p = strrpos($path, "/");
            $path = substr($path, 0, $p);
        }

        $path = rtrim($path, "/");

        if(!file_exists($path))
            return mkdir($path, 0755, true);
        else
            return is_dir($path);
    }
}