#!/usr/bin/env php
<?php
Phar::mapPhar();
include 'phar://' . __FILE__ . '/index.php';
__HALT_COMPILER();
