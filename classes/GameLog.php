<?php

//GameLog.php [Class to save a played expansion or map.]
//game_log.
//pathologicalplay [MMXXV]

class GameLog {

private $db;
private $file_id;
private $user_id;
private $entries_per_page;
private $offset;

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

public function setEntriesPerPage($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function setOffset($offset) {
$this->offset = $offset;
}

//Set methods.

//Method to display the ten users with the most entries in the GameLog. [controller->categories.php]

private function getTopPlayersDb() {
$conn = $this->db->connect();
$get_top_players = $conn->query("SELECT COUNT(game_log.game_log_id) AS top_player_count, users.user_id, users.username FROM game_log INNER JOIN users ON game_log.user_id = users.user_id GROUP BY game_log.user_id ORDER BY top_player_count DESC, users.user_id ASC LIMIT 10");
$result = $get_top_players->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getTopPlayers() {
$result = $this->getTopPlayersDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Method to display the ten users with the most entries in the GameLog. [controller->categories.php]

//Method to print the ten files that have been added to the GameLog most frequently. [controller->categories.php]

private function getMostPlayedFilesDb() {
$conn = $this->db->connect();
$get_most_played_files = $conn->query("SELECT COUNT(game_log.game_log_id) AS most_played_file_count, files.file_id, files.file_name FROM game_log INNER JOIN files ON game_log.file_id = files.file_id GROUP BY game_log.file_id ORDER BY most_played_file_count DESC, files.file_id ASC LIMIT 10");
$result = $get_most_played_files->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getMostPlayedFiles() {
$result = $this->getMostPlayedFilesDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Method to print the ten files that have been added to the GameLog most frequently. [controller->categories.php]

//Statistics of the respective user. [controller->profile.php]

private function getUserGameLogStatsDb() {
$conn = $this->db->connect();
$get_user_game_log_stats = $conn->prepare("SELECT COUNT(*) AS user_game_log_stats_count FROM game_log WHERE user_id = ?");
$get_user_game_log_stats->bind_param('i', $this->user_id);
$get_user_game_log_stats->execute();
$get_user_game_log_stats->bind_result($user_game_log_stats_count);
$get_user_game_log_stats->fetch();
$this->db->closeConnection();
return (INT) $user_game_log_stats_count;
}

public function getUserGameLogStats() {
return $this->getUserGameLogStatsDb();
}

//Statistics of the respective user. [controller->profile.php]

//Statistics of the respective file. [controller->item.php]

private function getFileGameLogStatsDb() {
$conn = $this->db->connect();
$get_file_game_log_stats = $conn->prepare("SELECT COUNT(game_log_id) AS file_game_log_stats_count FROM game_log WHERE file_id = ?");
$get_file_game_log_stats->bind_param('i', $this->file_id);
$get_file_game_log_stats->execute();
$get_file_game_log_stats->bind_result($file_game_log_stats_count);
$get_file_game_log_stats->fetch();
$this->db->closeConnection();
return (INT) $file_game_log_stats_count;
}

public function getFileGameLogStats() {
return $this->getFileGameLogStatsDb();
}

//Statistics of the respective file. [controller->item.php]

//Check if something has already been added to the GameLog.

private function checkGameLogDb() {
$conn = $this->db->connect();
$check_game_log = $conn->prepare("SELECT COUNT(*) AS check_game_log_count FROM game_log WHERE file_id = ? AND user_id = ?");
$check_game_log->bind_param('ii', $this->file_id, $this->user_id);
$check_game_log->execute();
$check_game_log->bind_result($check_game_log_count);
$check_game_log->fetch();
$this->db->closeConnection();
return (INT) $check_game_log_count;
}

public function checkGameLog() {
$result = $this->checkGameLogDb();
if ($result === 1) {
return true;
} else {
return false;
}
}

//Check if something has already been added to the GameLog.

//Check the file type.

private function checkFileTypeDb() {
$conn = $this->db->connect();
$check_file_type = $conn->prepare("SELECT file_type FROM files WHERE file_id = ?");
$check_file_type->bind_param('i', $this->file_id);
$check_file_type->execute();
$check_file_type->bind_result($file_type);
$check_file_type->fetch();
$this->db->closeConnection();
return $file_type;
}

private function checkFileType() {
$file_type = $this->checkFileTypeDb();
if ($file_type === 'sp_map' OR $file_type === 'addon') {
return true;
} else {
return false;
}
}

//Check the file type.

//Add to GameLog. [controller->item.php]

private function addToGameLogDb() {
$conn = $this->db->connect();
$add_to_game_log = $conn->prepare("INSERT INTO game_log(game_log_created, file_id, user_id) VALUES (NOW(), ?, ?)");
$add_to_game_log->bind_param('ii', $this->file_id, $this->user_id);
$result = $add_to_game_log->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function addToGameLog() {
$game_log = $this->checkGameLogDb();
$file_type = $this->checkFileType();
if ($game_log === 1) {
throw new Exception("You have already added the file to your GameLog and therefore cannot add it again.");
}
if ($file_type === false) {
throw new Exception("This file type cannot be added to your GameLog.");
}
if ($this->addToGameLogDb()) {
return true;
} else {
throw new Exception("A critical error occurred while adding to the GameLog.");
}
}

//Add to GameLog. [controller->item.php]

//Remove from GameLog. [controller->item.php]

public function removeFromGameLogDb() {
$conn = $this->db->connect();
$remove_from_game_log = $conn->prepare("DELETE FROM game_log WHERE file_id = ? AND user_id = ? LIMIT 1");
$remove_from_game_log->bind_param('ii', $this->file_id, $this->user_id);
$result = $remove_from_game_log->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeFromGameLog() {
$game_log = $this->checkGameLogDb();
if ($game_log === 0) {
throw new Exception("You haven't added the file to your GameLog yet, so you can't remove it.");
}
if ($this->removeFromGameLogDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the file from the GameLog.");
}
}

//Remove from GameLog. [controller->item.php]

//Preview of the GameLog for the respective user's profile, limited to 5. [controller->profile.php]

private function getUserGameLogPreviewDb() {
$conn = $this->db->connect();
$get_user_game_log_preview = $conn->prepare("SELECT game_log.game_log_created, files.file_id, files.file_name FROM game_log INNER JOIN files ON game_log.file_id = files.file_id WHERE game_log.user_id = ? ORDER BY game_log.game_log_created DESC LIMIT 5");
$get_user_game_log_preview->bind_param('i', $this->user_id);
$get_user_game_log_preview->execute();
$result = $get_user_game_log_preview->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getUserGameLogPreview() {
$result = $this->getUserGameLogPreviewDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Preview of the GameLog for the respective user's profile, limited to 5. [controller->profile.php]

//Total number of entries of the respective user (game_log) for pagination. [controller->user_game_log.php]

private function getNumberOfGameLogDb() {
$conn = $this->db->connect();
$number_of_records = $conn->prepare("SELECT game_log.game_log_created, files.file_id, files.file_name, users.username FROM game_log INNER JOIN files ON game_log.file_id = files.file_id INNER JOIN users ON game_log.user_id = users.user_id WHERE game_log.user_id = ?");
$number_of_records->bind_param('i', $this->user_id);
$number_of_records->execute();
$number_of_records->store_result();
$total_number_of_records = $number_of_records->num_rows;
$this->db->closeConnection();
if ($total_number_of_records > 0) {
return (INT) $total_number_of_records;
} else {
return false;
}
}

public function getNumberOfGameLog() {
$total_number_of_records = $this->getNumberOfGameLogDb();
if ($total_number_of_records !== false) {
return $total_number_of_records;
} else {
return false;
}
}

//Total number of entries of the respective user (game_log) for pagination. [controller->user_game_log.php]

//Output of the entire GameLog of the respective user with pagination. [controller->user_game_log.php]

private function getUserGameLogDb() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$conn = $this->db->connect();
$get_user_game_log = $conn->prepare("SELECT game_log.game_log_created, files.file_id, files.file_name, users.username FROM game_log INNER JOIN files ON game_log.file_id = files.file_id INNER JOIN users ON game_log.user_id = users.user_id WHERE game_log.user_id = ? ORDER BY game_log.game_log_created DESC LIMIT $offset, $entries_per_page");
$get_user_game_log->bind_param('i', $this->user_id);
$get_user_game_log->execute();
$result = $get_user_game_log->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getUserGameLog() {
$result = $this->getUserGameLogDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of the entire GameLog of the respective user with pagination. [controller->user_game_log.php]

}
