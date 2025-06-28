<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//index.php [front_controller.]

require_once 'classes/Dbh.php';
require_once 'classes/Auth.php';
require_once 'classes/User.php';
require_once 'includes/functions.php';
require_once 'classes/CategoryManager.php';
require_once 'classes/CommentManager.php';
require_once 'classes/FileManager.php';
require_once 'classes/FileUpdater.php';
require_once 'classes/FileUploader.php';
require_once 'classes/GameLog.php';
require_once 'classes/ImageManager.php';
require_once 'classes/LikeManager.php';
require_once 'classes/Message.php';
require_once 'classes/NewsManager.php';
require_once 'classes/Pagination.php';
require_once 'classes/ProfileManager.php';
require_once 'classes/ReadmeManager.php';
require_once 'classes/ErrorHandler.php';
require_once 'classes/ErrorContainer.php';
require_once 'classes/CsrfToken.php';

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
session_start ();

define('name', 'Modmanager');
define('version', '1.0.0');
define('author', 'pathologicalplay');

$db = new DbH();

require_once 'controller/error_handler.php';

if (Auth::isNotActivated()) {
require_once 'includes/header_alt.php';
include 'templates/messages/message_not_activated.php';
exit();
}

$allowed_sections = array(
'items',
'item',
'download',
'readme',
'news',
'profile',
'manage_profile',
'user_game_log',
'login',
'logout',
'register',
'create_file',
'category_management',
'file_management',
'edit_file',
'news_management',
'edit_news',
'user_management',
'error_log',
);

if (isset($_GET['section'])) {
$section = sanitize($_GET['section']);
if (in_array($section, $allowed_sections)) {
switch ($section) {
case 'items':
require_once 'controller/items.php';
break;
case 'item':
require_once 'controller/item.php';
break;
case 'download':
require_once 'controller/download.php';
break;
case 'readme':
require_once 'controller/readme.php';
break;
case 'news':
require_once 'controller/news.php';
break;
case 'profile':
require_once 'controller/profile.php';
break;
case 'manage_profile': //Only accessible to registered users.
require_once 'controller/manage_profile.php';
break;
case 'user_game_log':
require_once 'controller/user_game_log.php';
break;
case 'login':
require_once 'controller/login.php';
break;
case 'logout':
require_once 'controller/logout.php';
break;
case 'register':
require_once 'controller/register.php';
break;
case 'create_file': //Can only be accessed by an administrator.
require_once 'controller/create_file.php';
break;
case 'category_management': //Can only be accessed by an administrator.
require_once 'controller/category_management.php';
break;
case 'file_management': //Can only be accessed by an administrator.
require_once 'controller/file_management.php';
break;
case 'edit_file': //Can only be accessed by an administrator.
require_once 'controller/edit_file.php';
break;
case 'news_management': //Can only be accessed by an administrator.
require_once 'controller/news_management.php';
break;
case 'edit_news': //Can only be accessed by an administrator.
require_once 'controller/edit_news.php';
break;
case 'user_management': //Can only be accessed by an administrator.
require_once 'controller/user_management.php';
break;
case 'error_log': //Can only be accessed by an administrator.
require_once 'controller/error_log.php';
break;
}
} else {
require_once 'controller/categories.php';
}
} else {
require_once 'controller/categories.php';
}

require_once 'includes/footer.php';
?>
