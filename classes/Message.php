<?php

//Message.php [Class to render messages.]
//pathologicalplay [MMXXV]

class Message {

private $message_text;
private $message_url;
private $message_button_text;

function __construct($message_text, $message_url = null, $message_button_text = null)  {
$this->message_text = $message_text;
$this->message_url = $message_url;
$this->message_button_text = $message_button_text;
}

//Render message.

public function renderMessage() {
$output = '';
$output .= '<div class="message">';
$output .= '<p>'. sanitize($this->message_text). '</p>';
if ($this->message_url && $this->message_button_text) {
$output .= '<a href="'. sanitize($this->message_url). '">'. '<button class="message_button">'. sanitize($this->message_button_text). '</button>'. '</a>';
}
$output .= '</div>';
return $output;
}

//Render message.

}
