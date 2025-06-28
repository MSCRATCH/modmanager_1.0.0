<?php

//NewsManager.php [Class to manage and process the news.]
//news.
//pathologicalplay [MMXXV]

class NewsManager {

private $db;
private $news_post_id;
private $news_post_title;
private $news_post_text;
private $user_id;
private $entries_per_page;
private $offset;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setNewsPostId($news_post_id) {
$this->news_post_id = $news_post_id;
}

public function setNewsPostTitle($news_post_title) {
$this->news_post_title = $news_post_title;
}

public function setNewsPostText($news_post_text) {
$this->news_post_text = $news_post_text;
}

public function setUserId($user_id) {
$this->user_id = $user_id;
}

public function setEntriesPerPage($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function setOffset($offset) {
$this->offset = $offset;
}

//Set methods.

//Check if a NewsPost exists. [controller->edit_news.php]

private function validateIdOfNewsPostDb() {
$conn = $this->db->connect();
$stmt = $conn->prepare("SELECT COUNT(*) AS news_count FROM news WHERE news_post_id = ?");
$stmt->bind_param('i', $this->news_post_id);
$stmt->execute();
$stmt->bind_result($news_count);
$stmt->fetch();
$this->db->closeConnection();
return (INT) $news_count;
}

public function validateIdOfNewsPost() {
$news_count = $this->validateIdOfNewsPostDb();
if ($news_count > 0) {
return true;
} else {
return false;
}
}

//Check if a NewsPost exists. [controller->edit_news.php]

//Total number of records (news) for pagination. [controller->news.php]

private function getNumberOfNewsPostsDb() {
$conn = $this->db->connect();
$number_of_records = $conn->query("SELECT news.news_post_id, news.news_post_created, news.news_post_text, users.user_id, users.username FROM news INNER JOIN users ON news.user_id = users.user_id");
$total_number_of_records = $number_of_records->num_rows;
$this->db->closeConnection();
if ($total_number_of_records > 0) {
return (INT) $total_number_of_records;
} else {
return false;
}
}

public function getNumberOfNewsPosts() {
$total_number_of_records = $this->getNumberOfNewsPostsDb();
if ($total_number_of_records !== false) {
return $total_number_of_records;
} else {
return false;
}
}

//Total number of records (news) for pagination. [controller->news.php]

//Output of the NewsPosts (news) with pagination. [controller->news.php]

private function getNewsPostsDb() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$conn = $this->db->connect();
$get_news_posts = $conn->query("SELECT news.news_post_id, news.news_post_title, news.news_post_created, news.news_post_text, users.user_id, users.username FROM news INNER JOIN users ON news.user_id = users.user_id ORDER BY news.news_post_created DESC LIMIT $offset, $entries_per_page");
$result = $get_news_posts->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getNewsPosts() {
$result = $this->getNewsPostsDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of the NewsPosts (news) with pagination. [controller->news.php]

//Output of a news post. [controller->news_management.php]

private function getNewsPostDb() {
$conn = $this->db->connect();
$get_news_post = $conn->prepare("SELECT news_post_title, news_post_text FROM news WHERE news_post_id = ?");
$get_news_post->bind_param('i', $this->news_post_id);
$get_news_post->execute();
$result = $get_news_post->get_result()->fetch_assoc();
$this->db->closeConnection();
return $result ?: false;
}

public function getNewsPost() {
$result = $this->getNewsPostDb();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of a news post. [controller->news_management.php]

//Saving a NewsPost. [controller->news_management.php]

private function createNewsPostDb() {
$conn = $this->db->connect();
$create_news_post = $conn->prepare("INSERT INTO news(news_post_title, news_post_created, news_post_text, user_id) VALUES(?, NOW(), ?, ?)");
$create_news_post->bind_param('ssi', $this->news_post_title, $this->news_post_text, $this->user_id);
$result = $create_news_post->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function createNewsPost() {
$this->validateNewsPost();
$result = $this->createNewsPostDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while creating a news post.");
}
}

//Saving a NewsPost. [controller->news_management.php]

//Update a NewsPost. [controller->news_management.php]

private function validateNewsPost() {
if (empty($this->news_post_title) OR empty($this->news_post_text)) {
throw new Exception("Name, Author and Description cannot be empty.");
}
}

private function updateNewsPostDb() {
$conn = $this->db->connect();
$update_news_post = $conn->prepare("UPDATE news SET news_post_title = ?, news_post_text = ? WHERE news_post_id = ? LIMIT 1");
$update_news_post->bind_param('ssi', $this->news_post_title, $this->news_post_text, $this->news_post_id);
$result = $update_news_post->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function updateNewsPost() {
$this->validateNewsPost();
$result = $this->updateNewsPostDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating news post.");
}
}

//Update a NewsPost. [controller->news_management.php]

//Remove NewsPost. [controller->news_management.php]

private function removeNewsPostDb() {
$conn = $this->db->connect();
$remove_news_post = $conn->prepare("DELETE FROM news WHERE news_post_id = ? LIMIT 1");
$remove_news_post->bind_param('i', $this->news_post_id);
$result = $remove_news_post->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeNewsPost() {
if ($this->removeNewsPostDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the news post.");
}
}

//Remove NewsPost. [controller->news_management.php]

}
