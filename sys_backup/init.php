<?php
$fileSuffix = "backup_" . date("n-j-y");

function backup_tables($host,$user,$pass,$name,$tables = '*') {
  global $fileSuffix;

  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
  
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = ereg_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  
  //save file
  $handle = fopen('database-'.$fileSuffix.'.sql','w+');
  fwrite($handle,$return);
  fclose($handle);
}

function Zip($source, $destination) {
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

function uploadFiles() {
	global $fileSuffix;

	$database = fopen('database-'.$fileSuffix.'.sql', 'rb');
	//$files = fopen('files-'.$fileSuffix.'.zip', 'rb');
	
	$conn_id = ftp_connect("ftp.waveaudio.net");
	$login_result = ftp_login($conn_id, "ffiadm1n", 'S)9dP|W6y"?~f8*b+:Te');
	
	if (ftp_fput($conn_id, "databases/" . $fileSuffix . ".sql", $database, FTP_ASCII)) {
	//    ftp_fput($conn_id, "files/" . $fileSuffix . ".zip", $files, FTP_BINARY)) {
	    //Good!
	} else {
	    echo "Failed";
	    exit;
	}
	
	// close the connection and the file handler
	ftp_close($conn_id);
	fclose($database);
	//fclose($files);
}

echo "Initiating backup ... <br>";
echo "Backing up database ... ";
backup_tables("localhost", "pavcsbel_spryno", "Oliver99", "pavcsbel_sga");
echo "Done!<br>";

echo "Backing up files ... ";
//Zip("../../sga", 'files-'.$fileSuffix.'.zip');
echo "Done!<br>";

echo "Uploading files to remote host ... ";
uploadFiles();
echo "Done!<br>";

echo "Deleting local backup files ... ";
unlink('database-'.$fileSuffix.'.sql');
//unlink('files-'.$fileSuffix.'.zip');
echo "Done!<br>";
echo "Full backup completed!";
?>