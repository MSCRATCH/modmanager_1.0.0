<?php

//CategoryManager.php [Class to manage the categories table.]
//categories.
//pathologicalplay [MMXXV]

class CategoryManager {

private $db;
private $category_id;
private $category_name;
private $category_description;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setCategoryId($category_id) {
$this->category_id = $category_id;
}

public function setCategoryName($category_name) {
$this->category_name = $category_name;
}

public function setCategoryDescription($category_description) {
$this->category_description = $category_description;
}

//Set methods.

//Check if a category exists. [controller->items.php]

private function validateIdOfCategoryDb() {
$conn = $this->db->connect();
$stmt = $conn->prepare("SELECT COUNT(*) AS category_count FROM categories WHERE category_id = ?");
$stmt->bind_param('i', $this->category_id);
$stmt->execute();
$stmt->bind_result($category_count);
$stmt->fetch();
$this->db->closeConnection();
return (INT) $category_count;
}

public function validateIdOfCategory() {
$category_count = $this->validateIdOfCategoryDb();
if ($category_count > 0) {
return true;
} else {
return false;
}
}

//Check if a category exists. [controller->items.php]

//Output of categories. [controller->categories.php]

private function getCategoriesDb() {
$conn = $this->db->connect();
$stmt = $conn->query("SELECT c.category_id, c.category_name, c.category_description, COUNT(f.file_id) AS file_count FROM categories c LEFT JOIN files f ON c.category_id = f.category_id GROUP BY c.category_id, c.category_name, c.category_description");
$result = $stmt->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getCategories() {
$result = $this->getCategoriesDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of categories. [controller->categories.php]

//Output of categories. [controller->CategoryManager.php, controller->create_file.php, controller->edit_file.php]

private function showCategoriesDb() {
$conn = $this->db->connect();
$stmt = $conn->query("SELECT category_id, category_name, category_description FROM categories");
$result = $stmt->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function showCategories() {
$result = $this->showCategoriesDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of categories. [controller->CategoryManager.php, controller->create_file.php, controller->edit_file.php]

//Saving a category. [controller->CategoryManager.php]

private function createCategoryDb() {
$conn = $this->db->connect();
$create_category = $conn->prepare("INSERT INTO categories(category_name, category_description) VALUES(?, ?)");
$create_category->bind_param('ss', $this->category_name, $this->category_description);
$result = $create_category->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function createCategory() {
$this->validateCategory();
$result = $this->createCategoryDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while creating the category.");
}
}

//Saving a category. [controller->CategoryManager.php]

//Updating a category. [controller->CategoryManager.php]

private function validateCategory() {
if (empty($this->category_name) OR empty($this->category_description)) {
throw new Exception("Category name and description are required.");
}
}

private function updateCategoryDb() {
$conn = $this->db->connect();
$update_category = $conn->prepare("UPDATE categories SET category_name = ?, category_description = ? WHERE category_id = ? LIMIT 1");
$update_category->bind_param('ssi', $this->category_name, $this->category_description, $this->category_id);
$result = $update_category->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function updateCategory() {
$this->validateCategory();
$result = $this->updateCategoryDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating the category.");
}
}

//Updating a category. [controller->CategoryManager.php]

//Remove a category. [controller->CategoryManager.php]

private function removeCategoryDb() {
$conn = $this->db->connect();
$remove_category = $conn->prepare("DELETE FROM categories WHERE category_id = ? LIMIT 1");
$remove_category->bind_param('i', $this->category_id);
$result = $remove_category->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeCategory() {
if ($this->removeCategoryDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the category.");
}
}

//Remove a category. [controller->CategoryManager.php]

}
