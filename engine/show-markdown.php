<?php
/**
 * Process only two pattern of URL
 * http://site.com/help=markdown
 * http://site.com/2017/08/22/overcast-ios11-soon=markdown
 **/

require_once(realpath(dirname(__FILE__) . '/..') . '/config.php');
$uri = substr($_SERVER['REQUEST_URI'], 1);
$uri = substr($uri, 0, strlen($uri) - 9);
$exp = explode("/", $uri);

if (count($exp) == 1 || count($exp) == 4) {
    $seek = ( count($exp) == 1 ? $exp[0] : $exp[3] ) . '.md';
    $path = Updater::$source_path . '/' . (count($exp) == 1 ? 'pages' : 'posts/');
    $directory = $path ;
    if (count($exp) == 4) {
        list($y, $m, $d, $f) = explode('/', $uri);
        $directory = $path . $y . '/' . $m;
    }
    
    if (file_exists($directory)) {
        $files = scandir($directory);
        
        foreach ($files as $file) {
            if (strpos($file, $seek) !== false) {
                header('Content-Type: text/plain');
                echo file_get_contents($directory . '/' . $file);
                exit;
            }
        }
        include '404.html';
        die;
    }
} else {
    include '404.html';
    die;
}
