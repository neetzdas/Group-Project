<?php
$template = '../app/views/administrators/AdminNavigation.php';
$navigation = loadTemplate($template, ['selected'=>$selected]);

$template = '../app/templates/UserTemplate.php';
$contents = [
  'title'=>$title,
  'navigation'=>$navigation,
  'content'=>$content,
  'role'=>'Administrator'
];
$content = loadTemplate($template, $contents);

$this->view($content);


?>
