<?include(dirname(__FILE__). '/../../../include_vendor.php');
$token = \Uni\WebDav\WebDavSecurity::getToken();
\Uni\WebDav\WebDavResponse::getInstance()->printOk($token);