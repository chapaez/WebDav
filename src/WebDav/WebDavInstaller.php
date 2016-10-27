<?php
namespace Uni\WebDav;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;

/**
 * Class WebDavInstaller
 * @package Uni\WebDav
 */
class WebDavInstaller{
    /**
     * @param $src
     * @param $dst
     */
    private static function recurse_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    self::recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * @param Event $event
     */
    public static function postPackageInstall(Event $event){
        $io = $event->getIO();
        $io->write("Updating =.= ");
        $extra = $event->getComposer()->getPackage()->getExtra();
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';
        $dir = $extra['bxuni/wdcache'];
        if(!file_exists($dir)) {
            mkdir($dir, 0755, true);
            copy(dirname(__FILE__) . '/config.json', $dir . '/config.json');
            copy(dirname(__FILE__) . '/urls.json', $dir . '/urls.json');

        }
        file_put_contents($dir.'/include_vendor.php',"<?include('".$vendorDir."');");
        self::recurse_copy(dirname(__FILE__) . '/../script/', $dir.'/script');
        self::recurse_copy(dirname(__FILE__) . '/../adm/', $dir.'/adm');

        file_put_contents(dirname(__FILE__).'/scriptdir.json',json_encode(["dir"=>$dir]));

    }
}