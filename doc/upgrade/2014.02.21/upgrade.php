<?php
/* Upgrade your database to version 2014.04.21
 *
 * Run this from command line, while in 2014.04.21 ugprade directory.
 */

require_once('../../../config.php');

function InitializeDatabaseConnection()
{
  $retValue = null;
  global $settings;
  $con = @mysql_connect($settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD']);

  if (!($con && @mysql_select_db($settings['DB_DB']))) {
    die("Unable to connect to DB...");
  }

  return $retValue;
}

function Upgrade() {
  global $settings;

  $source = file_get_contents('upgrade.sql');
  $queries = explode(';', $source);
  $prefix = $settings['DB_PREFIX'];

  foreach ($queries as $query) {
    if (!trim($query))
      continue;
    if (trim($query) == 'SHOW WARNINGS')
      continue;
    $query = str_replace(':', $prefix, $query);
    if (!mysql_query($query)) {
      echo $query, "<br>";
      die(mysql_error() . "\n");
    }
  }
  return true;
}

InitializeDatabaseConnection();
Upgrade();
?>
