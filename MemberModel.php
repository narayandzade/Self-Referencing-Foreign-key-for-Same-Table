
<?php 
require_once 'MemberCtrl.php';

$member = new MemberCtrl(); 
date_default_timezone_set('Asia/Kolkata');
        // Get the current date and time
$datetime = date('Y-m-d H:i:s');
// Process the form data
$name = $_POST['name'];
$parentid = $_POST['parentid'] ?? null;

// Insert the member
if ($member->insertMember($name, $datetime, $parentid)) {
    echo 1;
} else {
    echo 0;
}
?>