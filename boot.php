<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2023
 */
require_once __DIR__.'/lib/class.page_counter.php';
#
# --- Stylesheet-Datei auch im Backend einbinden
$package=$this->getPackageId();
$file=rex_url::addonAssets($package).$package.'.css';
rex_view::addCssFile($file);
?>
