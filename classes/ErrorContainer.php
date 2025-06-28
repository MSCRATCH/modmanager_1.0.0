<?php

//ErrorContainer.php [Class to store and output error messages.]
//pathologicalplay [MMXXV]

class ErrorContainer {
private $errors = [];


//Add error.

public function addError($error) {
$this->errors[] = $error;
}

//Add error.

//Output of errors.

public function getErrors() {
return $this->errors;
}

public function hasErrors() {
return ! empty($this->errors);
}

//Output of errors.

}
