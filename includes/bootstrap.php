<?php
/**
 * Bootstrap
 * Load config and all classes. Include this at the top of every PHP page.
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Notice.php';
require_once __DIR__ . '/../classes/Admin.php';

Auth::startSession();
