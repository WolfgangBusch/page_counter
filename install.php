<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Dezember 2017
 */
require_once __DIR__.'/functions/function.install.php';
#
# --- Einfuegen der Aufrufzaehler-Spalte in rex_article, Erzeugen des Zaehler-Moduls
counter_insert_counter_column();
counter_insert_module($this->getPackageId());
?>
