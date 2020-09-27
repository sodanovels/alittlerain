<?php
// $Id: style.php,v 1.2 2002/02/22 14:46:08 smoonen Exp $

// This function emits the current template's stylesheet.

function action_style()
{
  header("Content-type: text/css");

  ob_start();

  require(TemplateDir . '/wiki.css');

  $size = ob_get_length();
  header("Content-Length: $size");
  ob_end_flush();
}

