<?php
require_once __DIR__ . '/../../../config.php'; // adapte le chemin si besoin
session_start();
session_unset();
session_destroy();
header('Location: ' . BASE_URL);
exit;