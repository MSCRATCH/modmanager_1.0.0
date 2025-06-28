<?php

//ProfileManager.php [Class to manage profiles.]
//user_profiles.
//pathologicalplay [MMXXV]

class ProfileManager {

private $db;
private $user_id;
private $user_profile_description;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setUserId($user_id) {
$this->user_id = $user_id;
}

public function setUserProfileDescription($user_profile_description) {
$this->user_profile_description = $user_profile_description;
}

//Set methods.

//Load data of the respective profile. [controller->profile.php]

private function getUserProfileDb() {
$conn = $this->db->connect();
$get_user_profile = $conn->prepare("SELECT user_profiles.user_profile_description, users.username FROM user_profiles INNER JOIN users ON user_profiles.user_id = users.user_id WHERE user_profiles.user_id = ?");
$get_user_profile->bind_param('i', $this->user_id);
$get_user_profile->execute();
$result = $get_user_profile->get_result()->fetch_assoc();
$this->db->closeConnection();
return $result ?: false;
}

public function getUserProfile() {
$result = $this->getUserProfileDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("The profile does not exist.");
}
}

//Load data of the respective profile. [controller->profile.php]

//Update the profile. [controller->profile.php]

private function checkIfEmpty() {
if (empty($this->user_profile_description)) {
return true;
} else {
return false;
}
}

private function updateUserProfileDb() {
$conn = $this->db->connect();
$update_user_profile = $conn->prepare("UPDATE user_profiles SET user_profile_description = ? WHERE user_id = ? LIMIT 1");
$update_user_profile->bind_param('si', $this->user_profile_description, $this->user_id);
$result = $update_user_profile->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function updateUserProfile() {
if ($this->checkIfEmpty() === true) {
throw new Exception("You must enter a description before you can submit the form.");
}
if ($this->updateUserProfileDb()) {
return true;
} else {
throw new Exception("A critical error occurred while updating your profile description.");
}
}

//Update the profile. [controller->profile.php]

}
