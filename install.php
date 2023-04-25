<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2023
 */
require_once __DIR__.'/lib/class.page_counter.php';
#
# --- Einfuegen der Aufrufzaehler-Spalte in rex_article, Erzeugen des Zaehler-Moduls
page_counter::insert_counter_column();
page_counter::build_module($this->getPackageId());
?>