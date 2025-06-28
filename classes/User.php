<?php

//User.php [Class to manage users.]
//users.
//pathologicalplay [MMXXV]

class User {

private $db;
private $username;
private $user_password;
private $user_password_confirm;
private $user_email;
private $security_question_answer;
private $user_id;
private $user_level;
private $entries_per_page;
private $offset;
private $error_container;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setUsername($username) {
$this->username = $username;
}

public function setUserPassword($user_password) {
$this->user_password = $user_password;
}

public function setUserPasswordConfirm($user_password_confirm) {
$this->user_password_confirm = $user_password_confirm;
}

public function setUserEmail($user_email) {
$this->user_email = $user_email;
}

public function setSecurityQuestionAnswer($security_question_answer) {
$this->security_question_answer = $security_question_answer;
}

public function setUserId($user_id) {
$this->user_id = $user_id;
}

public function setUserLevel($user_level) {
$this->user_level = $user_level;
}

public function setEntriesPerPage($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function setOffset($offset) {
$this->offset = $offset;
}

public function setErrorContainer(ErrorContainer $error_container) {
$this->error_container = $error_container;
}

//Set methods.

//Check if a user exists. [controller->profile.php, controller->user_game_log.php]

private function validateIdOfUserDb() {
$conn = $this->db->connect();
$stmt = $conn->prepare("SELECT COUNT(*) AS user_count FROM users WHERE user_id = ?");
$stmt->bind_param('i', $this->user_id);
$stmt->execute();
$stmt->bind_result($user_count);
$stmt->fetch();
$this->db->closeConnection();
return (INT) $user_count;
}

public function validateIdOfUser() {
$user_count = $this->validateIdOfUserDb();
if ($user_count > 0) {
return true;
} else {
return false;
}
}

//Check if a user exists. [controller->profile.php, controller->user_game_log.php]

//Check if the form is empty.

private function ifLoginFormIsEmpty() {
if (empty($this->username) or empty($this->user_password)) {
return true;
} else {
return false;
}
}

//Check if the form is empty.

//Database access for login.

private function loginDb() {
$conn = $this->db->connect();
$stmt = $conn->prepare("SELECT user_id, username, user_password, user_level FROM users WHERE username = ?");
$stmt->bind_param('s', $this->username);
$stmt->execute();
$result = $stmt->get_result();
$this->db->closeConnection();
if ($result->num_rows === 1) {
return $result->fetch_assoc();
} else {
return false;
}
}

//Database access for login.

//Login.

public function login() {

if ($this->ifLoginFormIsEmpty() === true) {
throw new Exception("Please fill out the form completely.");
}

$user = $this->loginDb();
if ($user === false) {
throw new Exception("The login was not successful. Please try again.");
}

$user_password = $user['user_password'];
$username = $user['username'];
$user_level = $user['user_level'];
$user_id = $user['user_id'];

if (password_verify($this->user_password, $user_password)) {
$_SESSION['logged_in']['username'] = $username;
$_SESSION['logged_in']['user_level'] = $user_level;
$_SESSION['logged_in']['user_id'] = $user_id;
return true;
} else {
unset($_SESSION['logged_in']['username']);
unset($_SESSION['logged_in']['user_level']);
unset($_SESSION['logged_in']['user_id']);
throw new Exception("The login was not successful. Please try again.");
}
}

//Login.

//Validation of registration data.

private function validateRegistrationData() {
if (! empty($this->username) and strlen($this->username) > 30) {
$this->error_container->addError('The username cannot be longer than 30 characters.');
}

if (! empty($this->username) and strlen($this->username) < 5) {
$this->error_container->addError('The username cannot be shorter than 5 characters.');
}

if (! empty($this->username) and ! ctype_alnum($this->username)) {
$this->error_container->addError('The username must consist only of letters and numbers. Special characters are not allowed.');
}

if (! empty($this->user_password) and strlen($this->user_password) > 30) {
$this->error_container->addError('The password cannot be longer than 30 characters.');
}

if (! empty($this->user_password) and strlen($this->user_password) < 8) {
$this->error_container->addError('The password cannot be shorter than 8 characters.');
}

if ($this->user_password != $this->user_password_confirm) {
$this->error_container->addError('The passwords entered do not match.');
}

if (! empty($this->user_email) and ! filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
$this->error_container->addError('The email address is invalid.');
}

if (! empty($this->security_question_answer) and $this->security_question_answer != "old") {
$this->error_container->addError('The security question was not answered correctly.');
}

if (empty($this->username) or empty($this->user_password) or empty($this->user_password_confirm) or empty($this->user_email) or empty($this->security_question_answer)) {
$this->error_container->addError('The form must be filled out completely.');
}
}

//Validation of registration data.

//Method to hash the password for registration.

private function hashPassword() {
$options = ['cost' => 12];
return password_hash($this->user_password, PASSWORD_BCRYPT, $options);
}

//Method to hash the password for registration.

//Database access for registration.

private function registerDb() {
$conn = $this->db->connect();
$hashed_user_password = $this->hashPassword();
$save_user = $conn->prepare("INSERT INTO users(username, user_password, user_email, user_date) VALUES(?, ?, ?, NOW())");
$save_user->bind_param('sss', $this->username, $hashed_user_password, $this->user_email);
$save_user->execute();
$new_user_id = $save_user->insert_id;
$create_profile = $conn->prepare("INSERT INTO user_profiles(user_id) VALUES(?)");
$create_profile->bind_param('i', $new_user_id);
$result = $create_profile->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

//Database access for registration.

//Registration.

public function register() {
$this->validateRegistrationData();
if ($this->error_container->hasErrors()) {
return false;
} else {
try {
$this->registerDb();
return true;
} catch (mysqli_sql_exception $e) {
if ($e->getCode() == 1062) {
throw new Exception("The username or email address is already taken.");
}
}
}
}

//Registration.

//Total number of users for pagination.

private function getNumberOfUsersDb() {
$conn = $this->db->connect();
$get_number_of_users = $conn->query("SELECT user_id, username, user_date, user_email, user_level FROM users");
$total_number_of_users = $get_number_of_users->num_rows;
$this->db->closeConnection();
if ($total_number_of_users > 0) {
return (INT) $total_number_of_users;
} else {
return false;
}
}

public function getNumberOfUsers() {
$total_number_of_users = $this->getNumberOfUsersDb();
if ($total_number_of_users !== false) {
return $total_number_of_users;
} else {
return false;
}
}

//Total number of users for pagination.

//Output of all users for the backend.

private function getAllUsersDb() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$conn = $this->db->connect();
$stmt = $conn->query("SELECT user_id, username, user_date, user_email, user_level FROM users ORDER BY user_date DESC LIMIT $offset, $entries_per_page");
$result = $stmt->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getAllUsers() {
$result = $this->getAllUsersDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("An error has occurred.");
}
}

//Output of all users for the backend.

//Remove a user.

private function isAdmin() {
$conn = $this->db->connect();
$check_if_admin = $conn->prepare("SELECT user_level FROM users WHERE user_id = ?");
$check_if_admin->bind_param('i', $this->user_id);
$check_if_admin->execute();
$check_if_admin->bind_result($user_level);
$check_if_admin->fetch();
$this->db->closeConnection();
if ($user_level === 'administrator') {
return true;
} else {
return false;
}
}

private function removeUserDb() {
$conn = $this->db->connect();
$remove_user = $conn->prepare("DELETE FROM users WHERE user_id = ? LIMIT 1");
$remove_user->bind_param('i', $this->user_id);
$result = $remove_user->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeUser() {
if ($this->isAdmin() === true) {
throw new Exception("An administrator cannot be removed directly.");
}
if ($this->removeUserDb()) {
return true;
} else {
throw new Exception("A critical error occurred while deleting the user.");
}
}

//Remove a user.

//Update user level.

private function updateUserLevelDb() {
$conn = $this->db->connect();
$update_user_level = $conn->prepare("UPDATE users SET user_level = ? WHERE user_id = ? LIMIT 1");
$update_user_level->bind_param('si', $this->user_level, $this->user_id);
$result = $update_user_level->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function updateUserLevel() {
if ($this->isAdmin() === true) {
throw new Exception("The user level of an administrator cannot be changed directly.");
}
if ($this->updateUserLevelDb()) {
return true;
} else {
throw new Exception("A critical error occurred while deleting the user.");
}
}


//Update user level.

}
