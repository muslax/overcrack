<?php
/** show-markdown.php **/

list($y, $m, $d, $f) = explode('/', substr($_SERVER['REQUEST_URI'], 1), 5);
$seek = $f . '.md';
$prefix = '/path/to/blog/posts/'; // Path to posts folder, please change to suit your environment
$directory = $prefix . $y . '/' . $m;
if (file_exists($directory)) {
    $files = scandir($directory);
    foreach ($files as $file) {
        if (strpos($file, $seek)) {
            header('Content-Type: text/plain');
            echo file_get_contents($directory . '/' . $file);
            exit;
        }
    }

    include '404.html';
    die;
}
