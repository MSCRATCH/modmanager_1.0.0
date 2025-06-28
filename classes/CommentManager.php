<?php

//CommentManager.php [Class to manage and process the comments.]
//file_comments.
//pathologicalplay [MMXXV]

class CommentManager {

private $db;
private $file_comment_id;
private $file_id;
private $comment_text;
private $user_id;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setFileCommentId($file_comment_id) {
$this->file_comment_id = $file_comment_id;
}

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setCommentText($comment_text) {
$this->comment_text = $comment_text;
}

public function setUserId($user_id) {
$this->user_id = $user_id;
}

//Set methods.

//Display the comments of the respective file. [controller->item.php]

private function getCommentsDb() {
$conn = $this->db->connect();
$get_comments = $conn->prepare("SELECT file_comments.file_comment_id, file_comments.file_comment_created, file_comments.file_comment, users.username, users.user_id FROM file_comments INNER JOIN users ON file_comments.user_id = users.user_id WHERE file_comments.file_id = ? ORDER BY file_comments.file_comment_created DESC");
$get_comments->bind_param('i', $this->file_id);
$get_comments->execute();
$result = $get_comments->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getComments() {
$result = $this->getCommentsDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Display the comments of the respective file. [controller->item.php]

//Check if the form is not empty.

private function checkIfEmpty() {
if (empty($this->comment_text)) {
return true;
} else {
return false;
}
}

//Check if the form is not empty.

//Save comment. [controller->item.php]

private function createCommentDb() {
$conn = $this->db->connect();
$create_comment = $conn->prepare("INSERT INTO file_comments(file_comment_created, file_comment, user_id, file_id) VALUES(NOW(), ?, ?, ?)");
$create_comment->bind_param('sii', $this->comment_text, $this->user_id, $this->file_id);
$result = $create_comment->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function createComment() {
if ($this->checkIfEmpty() === true) {
throw new Exception("You need to enter a comment.");
}
if ($this->createCommentDb()) {
return true;
} else {
throw new Exception("A critical error occurred while saving the comment.");
}
}

//Save comment. [controller->item.php]

//Show the latest 5 comments from each user. [controller->profile.php]

private function getUserCommentsDb() {
$conn = $this->db->connect();
$get_user_comments = $conn->prepare("SELECT file_comments.file_comment, file_comments.file_comment_created, files.file_id, files.file_name FROM file_comments INNER JOIN files ON file_comments.file_id = files.file_id WHERE file_comments.user_id = ? ORDER BY file_comments.file_comment_created DESC LIMIT 5");
$get_user_comments->bind_param('i', $this->user_id);
$get_user_comments->execute();
$result = $get_user_comments->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getUserComments() {
$result = $this->getUserCommentsDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Show the latest 5 comments from each user. [controller->profile.php]

//Remove comment. [controller->item.php]

private function removeCommentDb() {
$conn = $this->db->connect();
$remove_comment = $conn->prepare("DELETE FROM file_comments WHERE file_comment_id = ? LIMIT 1");
$remove_comment->bind_param('i', $this->file_comment_id);
$result = $remove_comment->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeComment() {
if ($this->removeCommentDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the comment.");
}
}

//Remove comment. [controller->item.php]

}
