<?php

// Very quick hack to initialise a Tavi Database with a PHP script
//
// Lacks any error checking
//
// 8 Apr 2002 Rick van Lieshout (r.van.lieshout@promo-it.nl)

// Adjust these as needed
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "scsi54";
$dbname = "alittlerain";
$prefix = "wiki_"; // Database table prefix - set to same as DBTablePrefix in config.php

$dblink = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $dblink);

$database_sql = "CREATE TABLE ${prefix}interwiki (
  prefix varchar(80) NOT NULL default '',
  where_defined varchar(80) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  PRIMARY KEY  (prefix)
) TYPE=MyISAM;

CREATE TABLE ${prefix}links (
  page varchar(80) NOT NULL default '',
  link varchar(80) NOT NULL default '',
  count int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (page,link)
) TYPE=MyISAM;

CREATE TABLE ${prefix}pages (
  title varchar(80) NOT NULL default '',
  version int(10) unsigned NOT NULL default '1',
  time timestamp(14) NOT NULL,
  supercede timestamp(14) NOT NULL,
  mutable set('off','on') NOT NULL default 'on',
  username varchar(80) default NULL,
  author varchar(80) NOT NULL default '',
  comment varchar(80) NOT NULL default '',
  body text,
  PRIMARY KEY  (title,version)
) TYPE=MyISAM;

CREATE TABLE ${prefix}rate (
  ip char(20) NOT NULL default '',
  time timestamp(14) NOT NULL,
  viewLimit smallint(5) unsigned default NULL,
  searchLimit smallint(5) unsigned default NULL,
  editLimit smallint(5) unsigned default NULL,
  PRIMARY KEY  (ip)
) TYPE=MyISAM;

CREATE TABLE ${prefix}remote_pages (
  page varchar(80) NOT NULL default '',
  site varchar(80) NOT NULL default '',
  PRIMARY KEY  (page,site)
) TYPE=MyISAM;

CREATE TABLE ${prefix}sisterwiki (
  prefix varchar(80) NOT NULL default '',
  where_defined varchar(80) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  PRIMARY KEY  (prefix)
) TYPE=MyISAM;";

$sql_queries = explode(";", $database_sql);
foreach ($sql_queries as $q) {
    mysql_query($q, $dblink);
}
echo "DB Created!"
?>
