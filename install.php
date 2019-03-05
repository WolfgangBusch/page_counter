<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version März 2019
 */
require_once __DIR__.'/lib/class.page_counter_install.php';
#
# --- Einfuegen der Aufrufzaehler-Spalte in rex_article, Erzeugen des Zaehler-Moduls
page_counter_install::insert_counter_column();
page_counter_install::build_module($this->getPackageId());
?>