<?php

function sanitize($content) {
$content = trim($content ?? '');
$content = htmlentities($content ?? '', ENT_QUOTES, "UTF-8");
return ($content);
}

function sanitize_ucfirst($content) {
$content = trim($content ?? '');
$content = ucfirst($content ?? '');
$content = htmlentities($content ?? '', ENT_QUOTES, "UTF-8");
return ($content);
}

function sanitize_strtoupper($content) {
$content = trim($content ?? '');
$content = strtoupper($content ?? '');
$content = htmlentities($content ?? '', ENT_QUOTES, "UTF-8");
return ($content);
}

function fileSizeFormatted($bytes) {
if ($bytes < 1024) return $bytes. 'B';
elseif ($bytes < 1048576) return round($bytes / 1024, 2). 'KB';
elseif ($bytes < 1073741824) return round($bytes / 1048576, 2). 'MB';
else return round($bytes / 1073741824, 2). 'GB';
}

?>
