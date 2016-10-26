<?php
namespace Uni\WebDav;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;
class WebDavInstaller{
    private function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public static function postPackageInstall(Event $event){
        $io = $event->getIO();
        $io->write("Updating =.= ");
        $extra = $event->getComposer()->getPackage()->getExtra();
        var_dump($extra);
        //$vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $dir = $extra['bxuni/wdcache'];
        self::recurse_copy(dir(__FILE__).'../script/',$dir);
        /*if(!file_exists($dir)) {
            mkdir($dir, 0755, true);

        }*/

    }
}