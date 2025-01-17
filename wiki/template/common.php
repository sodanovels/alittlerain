<?php
// $Id: common.php,v 1.8 2002/02/22 14:46:09 smoonen Exp $

// This function generates the common prologue and header
// for the various templates.
//
// Its parameters are passed as an associative array with the following
// members:
//
//   'norobots' => An integer; if nonzero, robots will be forbidden to
//                 index the page or follow links from the page.
//   'title'    => A string containing the page title.  This function
//                 will append ' - WikiName' to the title.
//   'heading'  => A string containing the page's heading.
//   'headlink' => A string.  If not empty, it will be appended to the
//                 page's heading as a link to find the contents of the
//                 string in the database.
//   'headsufx' => A string containing the heading suffix.  If not
//                 empty, it will be printed after the heading link.
//   'toolbar'  => An integer; if nonzero, the toolbar will be displayed.

function template_common_prologue($args)
{
  global $WikiName, $HomePage, $WikiLogo, $MetaKeywords, $MetaDescription;
  global $StyleScript, $SeparateTitleWords, $SeparateHeaderWords;

  $keywords = ' ' . html_split_name($args['headlink']);
  $keywords = str_replace('"', '&quot;', $keywords);

  ob_start();                           // Start buffering output.

  if($SeparateTitleWords)
    { $args['title'] = html_split_name($args['title']); }
?>
<!DOCTYPE html
          PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html   xmlns   = "http://www.w3.org/1999/xhtml">
<head>
<meta name="KEYWORDS" content="<?php print $MetaKeywords . $keywords; ?>" />
<meta name="DESCRIPTION" content="<?php print $MetaDescription; ?>" />
<?php
  if($args['norobots'])
  {
?>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<?php
  }
?>
<link rel="STYLESHEET" href="<?php print $StyleScript; ?>" type="text/css" />
<title><?php print $args['title'] . ' - ' . $WikiName; ?></title>
</head>
<body>
<div id="header">
  <div class="logo">
  <a href="<?php print viewURL($HomePage); ?>"><img
    src="<?php print $WikiLogo; ?>" alt="[Home]" /></a>
  </div>
  <h1>
<?php
    print $args['heading'];
    if($args['headlink'] != '')
    {
?>
    <a class="title" href="<?php print findURL($args['headlink']); ?>">
<?php
    if($SeparateHeaderWords)
      { print html_split_name($args['headlink']); }
    else
      { print $args['headlink']; }
?></a>
<?php
    }
    print $args['headsufx'];
?>
  </h1>
<?php
  if($args['toolbar'])
    { print html_toolbar_top(); }
?>
<hr />
</div>
<?php
}

// This function generates the common prologue and header
// for the various templates.
//
// Its parameters are passed as an associative array with the following
// members:
//
//   'twin'      => A string containing the page's name; if not empty,
//                  twin pages will be sought and printed.
//   'edit'      => A string containing the page's name; if not empty,
//                  an edit link will be printed.
//   'editver'   => An integer containing the page's version; if not
//                  zero, the edit link will be directed at the given
//                  version.  If it is -1, the page cannot be edited,
//                  and a message to that effect will be printed.
//   'history'   => A string containing the page's name; if not empty,
//                  a history link will be printed.
//   'timestamp' => Timestamp for the page.  If not empty, a 'document
//                  last modified' note will be printed.
//   'nosearch'  => An integer; if nonzero, the search form will not appear.

function template_common_epilogue($args)
{
  global $FindScript, $pagestore;

?>
<div id="footer">
<hr />
<?php
  if(!$args['nosearch'])
  {
?>
<form method="get" action="<?php print $FindScript; ?>">
<div class="form">
<?php
  }
  if($args['edit'])
  {
    if($args['editver'] == 0)
    {
?>  <a href="<?php print editURL($args['edit']); ?>">Edit this document</a><?php
    }
    else if($args['editver'] == -1)
    {
?>    This document cannot be edited <?php
    }
    else
    {
?>
  <a href="<?php print editURL($args['edit'], $args['editver']); ?>">
  Edit this <em>ARCHIVE VERSION</em> of this document</a>
<?php
    }

    if($args['history'])
      { print ' | '; }
  }
  if($args['history'])
  {
?>
    <a href="<?php print historyURL($args['history']); ?>">View document history</a><br />
<?php
  }
  if($args['timestamp'])
  {
?>
  Document last modified <?php print html_time($args['timestamp']); ?><br />
<?php
  }
  if($args['twin'] != '')
  {
    if(count($twin = $pagestore->twinpages($args['twin'])))
    {
?>Twin pages: <?php
      for($i = 0; $i < count($twin); $i++)
        { print html_twin($twin[$i][0], $twin[$i][1]) . ' '; } ?>
<br /><?php
    }
  }
  if(!$args['nosearch'])
  {
?>
  <input type="hidden" name="action" value="find" />
  Search: <input type="text" name="find" size="20" />
</div>
</form>
<?php
  }
?>
</div>
</body>
</html>
<?php

  $size = ob_get_length();
  header("Content-Length: $size");
  ob_end_flush();
}
?>
