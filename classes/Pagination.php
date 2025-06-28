<?php

//Pagination.php [Class to create and output pagination.]
//pathologicalplay [MMXXV]

class Pagination {

private $entries_per_page;
private $current_page;
private $total_records;

function __construct($entries_per_page, $current_page, $total_records)  {
$this->entries_per_page = $entries_per_page;
$this->current_page = $current_page;
$this->total_records = $total_records;
}

//Calculate offset.

public function getOffset() {
return ($this->current_page - 1) * $this->entries_per_page;
}

//Calculate offset.

//Calculate number of pages.

public function getNumberOfPages() {
if ($this->total_records === 0) {
return 1;
}
return ceil($this->total_records / $this->entries_per_page);
}

//Calculate number of pages.

//Check if the page number is valid.

public function isValidPageNumber() {
if ($this->total_records === 0) {
$this->current_page = 1;
return true;
}
$number_of_pages = $this->getNumberOfPages();
if ($this->current_page < 1 || $this->current_page > $number_of_pages) {
$this->current_page = 1;
}
return true;
}

//Check if the page number is valid.

//Render pagination.

public function renderPagination($url) {
$number_of_pages = $this->getNumberOfPages();
$output = '';
$separator = strpos($url, '?') !== false ? '&' : '?';
$output .= '<ul class="pagination_ul">';
$prev_page = ($this->current_page > 1) ? $this->current_page - 1 : $this->current_page;
$output .= '<li class="pagination_li">'. '<a class="pagination_a" href="'. sanitize($url). sanitize($separator). 'page='. sanitize($prev_page). '">'. "PREV". '</a>'. '</li>';
$output .= '<li class="pagination_li_nh">'. sanitize($this->current_page). "&nbsp;". "OF". "&nbsp;". sanitize($number_of_pages). '</li>';
$next_page = ($this->current_page < $number_of_pages) ? $this->current_page + 1 : $this->current_page;
$output .= '<li class="pagination_li">'. '<a class="pagination_a" href="'. sanitize($url).  sanitize($separator). 'page='. sanitize($next_page). '">'. "NEXT". '</a>'. '</li>';
$output .= '</ul>';

return $output;
}

//Render pagination.

}
