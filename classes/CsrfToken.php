<?php

//CsrfToken.php [Class to protect forms against CSRF.]
//pathologicalplay [MMXXV]

class CsrfToken {
private $session;
private $tokenNamePrefix = 'csrf_token_';

public function __construct(&$session) {
$this->session = &$session;
}

public function generateToken($formName) {
$token = bin2hex(random_bytes(32));
$tokenName = $this->tokenNamePrefix . $formName;
$this->session[$tokenName] = $token;
return $token;
}

public function validateToken($formName, $token) {
$tokenName = $this->tokenNamePrefix . $formName;
if (isset($this->session[$tokenName]) && $token === $this->session[$tokenName]) {
$this->deleteToken($formName);
return true;
}
return false;
}

private function deleteToken($formName) {
$tokenName = $this->tokenNamePrefix . $formName;
unset($this->session[$tokenName]);
}
}
