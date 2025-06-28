<?php

//Auth.php [User authentication.]
//pathologicalplay [MMXXV]

class Auth {

//Check if a user is logged in.

public static function isLoggedIn() {
return isset($_SESSION['logged_in']['user_level']);
}

//Check if a user is logged in.

//Check if a user is an administrator.

public static function isAdministrator() {
return isset($_SESSION['logged_in']['user_level']) && $_SESSION['logged_in']['user_level'] == 'administrator';
}

//Check if a user is an administrator.

//Check if a user is activated.

public static function isNotActivated() {
return isset($_SESSION['logged_in']['user_level']) && $_SESSION['logged_in']['user_level'] == 'not_activated';
}

//Check if a user is activated.

//Get username from the session.

public static function getUsername() {
if (isset($_SESSION['logged_in']['username'])) {
return $_SESSION['logged_in']['username'];
} else {
return false;
}
}

//Get username from the session.

//Get ID from the session.

public static function getUserId() {
if (isset($_SESSION['logged_in']['user_id'])) {
return (INT) $_SESSION['logged_in']['user_id'];
} else {
return false;
}
}

//Get ID from the session.

//Get user level from the session.

public static function getUserLevel() {
if (isset($_SESSION['logged_in']['user_level'])) {
return $_SESSION['logged_in']['user_level'];
} else {
return false;
}
}

//Get user level from the session.

}
