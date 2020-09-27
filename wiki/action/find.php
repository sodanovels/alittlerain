<?php
// $Id: find.php,v 1.6 2002/01/07 16:28:32 smoonen Exp $

require('parse/html.php');
require(TemplateDir . '/find.php');

// Find a string in the database.
function action_find()
{
  global $pagestore, $find;

  $list = $pagestore->find($find);

  $text = '';
  foreach($list as $page)
    { $text = $text . html_ref($page, $page) . html_newline(); }

  template_find(array('find'  => $find,
                      'pages' => $text));
}
?>
