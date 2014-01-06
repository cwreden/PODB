<?php
// router.php
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"]))
    return false; // Liefere die angefragte Ressource direkt aus
else if (preg_match('/api.*/', $_SERVER["REQUEST_URI"])) {
    include('api/index.php');
} else {
    include('index.html');
}
