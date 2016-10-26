<?php
namespace Uni\WebDav;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;
class WebDavInstaller{
    public static function postPackageInstall(Event $event){
        $io = $event->getIO();
        $io->write("Updating =.= ");
        $extra = $event->getComposer()->getPackage()->getExtra();
        $io->write("g =.= ".serialize($extra));
        var_dump($extra);
        //$vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $dir = '/home/bitrix/ext_www/test.domashniy.ru/webdav';
        echo "LOLOLOLO";
        mkdir($dir, 0755, true);
    }
}