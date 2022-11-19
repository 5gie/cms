<?php 
// Configs
define("DOMAIN", "format.local.com");
define("THEME_PATH", "themes");
define("DB_PREFIX", "kch_");
define("HTTP_SERVER", "http://format.local.com/");
define("DIRNAME", $_SERVER["DOCUMENT_ROOT"]);

//DEBUG
function dump($var)
{
    echo "<pre style='padding:10px;font-size:12px;background:#2D2D2D;color:#d0d0d0'>";
    echo '<h4 style="color:#FF5A5A">DEBUG MODE:</h4>';
    if (empty($var)) {
        echo 'TABLICA / ZMIENNA PUSTA!';
    } else {
        var_dump($var);
    }
    echo "</pre>";
}

?>