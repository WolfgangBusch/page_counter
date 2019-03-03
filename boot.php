<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version März 2019
 */
require_once __DIR__.'/lib/class.page_counter_install.php';
require_once __DIR__.'/lib/class.page_counter.php';
#
# --- Stylesheet-Datei auch im Backend einbinden
$my_package=$this->getPackageId();
$file=rex_url::addonAssets($my_package).$my_package.'.css';
rex_view::addCssFile($file);
?>
