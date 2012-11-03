<?php
$fileSuffix = "backup_" . date("n-j-y");

echo "Deleting local backup files ... ";
unlink('database-'.$fileSuffix.'.sql');
unlink('files-'.$fileSuffix.'.zip');
echo "Done!<br>";
?>