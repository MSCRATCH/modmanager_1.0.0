<?php

//LikeManager.php [Class to control liking of files.]
//file_likes.
//pathologicalplay [MMXXV]

class LikeManager {

private $db;
private $file_id;
private $user_id;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setUserId($user_id) {
$this->user_id = $user_id;
}

//Set methods.

//Statistics of the respective file. [controller->item.php]

private function getFileLikesDb() {
$conn = $this->db->connect();
$get_file_game_log_stats = $conn->prepare("SELECT COUNT(file_like_id) AS file_likes_total_count FROM file_likes WHERE file_id = ?");
$get_file_game_log_stats->bind_param('i', $this->file_id);
$get_file_game_log_stats->execute();
$get_file_game_log_stats->bind_result($file_likes_total_count);
$get_file_game_log_stats->fetch();
$this->db->closeConnection();
return (INT) $file_likes_total_count;
}

public function getFileLikes() {
return $this->getFileLikesDb();
}

//Statistics of the respective file. [controller->item.php]

//Checking if something has already been liked. [controller->item.php]

private function checkIfUserLikedDb() {
$conn = $this->db->connect();
$check_if_user_liked = $conn->prepare("SELECT COUNT(*) AS check_like_count FROM file_likes WHERE file_id = ? AND user_id = ?");
$check_if_user_liked->bind_param('ii', $this->file_id, $this->user_id);
$check_if_user_liked->execute();
$check_if_user_liked->bind_result($check_like_count);
$check_if_user_liked->fetch();
$this->db->closeConnection();
return (INT) $check_like_count;
}

public function checkIfUserLiked() {
$result = $this->checkIfUserLikedDb();
if ($result === 1) {
return true;
} else {
return false;
}
}

//Checking if something has already been liked. [controller->item.php]

//Adding a like. [controller->item.php]

private function addLikeDb() {
$conn = $this->db->connect();
$add_like = $conn->prepare("INSERT INTO file_likes(file_like_created, file_id, user_id) VALUES (NOW(), ?, ?)");
$add_like->bind_param('ii', $this->file_id, $this->user_id);
$result = $add_like->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function addLike() {
$user_like = $this->checkIfUserLikedDb();
if ($user_like === 1) {
throw new Exception("You have already liked the file, so you cannot like it again.");
}
if ($this->addLikeDb()) {
return true;
} else {
throw new Exception("A critical error occurred while adding your like.");
}
}

//Adding a like. [controller->item.php]

//Remove a like. [controller->item.php]

public function removeLikeDb() {
$conn = $this->db->connect();
$remove_like = $conn->prepare("DELETE FROM file_likes WHERE file_id = ? AND user_id = ? LIMIT 1");
$remove_like->bind_param('ii', $this->file_id, $this->user_id);
$result = $remove_like->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeLike() {
$user_like = $this->checkIfUserLikedDb();
if ($user_like === 0) {
throw new Exception("You have not yet added a like to the file, so it cannot be removed.");
}
if ($this->removeLikeDb()) {
return true;
} else {
throw new Exception("A critical error occurred while adding your like.");
}
}

//Remove a like. [controller->item.php]

//Preview the history for the respective user's profile. [controller->profile.php]

private function getUserLikesPreviewDb() {
$conn = $this->db->connect();
$get_user_likes_preview = $conn->prepare("SELECT file_likes.file_like_created, files.file_id, files.file_name FROM file_likes INNER JOIN files ON file_likes.file_id = files.file_id WHERE file_likes.user_id = ? ORDER BY file_likes.file_like_created DESC LIMIT 5");
$get_user_likes_preview->bind_param('i', $this->user_id);
$get_user_likes_preview->execute();
$result = $get_user_likes_preview->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getUserLikesPreview() {
$result = $this->getUserLikesPreviewDb();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Preview the history for the respective user's profile. [controller->profile.php]

}
