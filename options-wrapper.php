<?php

if (!defined('ABSPATH')) {
    exit; // exit if accessed directly
}

?>
<div class="wrap">
    <h1>WP Simple SMTP</h1>
    <hr>
    <h3>SMTP Konfiguration</h3>
    <p>Lege hier die Konfiguration für den Versand über SMTP fest.</p>
    <?php require_once 'options-smtp.php'; ?>
    <hr>
    <?php require_once 'options-test.php'; ?>
    <hr>
</div>