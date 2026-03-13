<?php
include('../db.php');

function checkWebsite($url) {
    $url = trim($url);
    if (!preg_match('~^https?://~', $url)) $url = 'http://' . $url;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY         => true, // We only need the headers
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_FOLLOWLOCATION => false, // DO NOT follow ISP fake search pages
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_errno($ch);
    curl_close($ch);

    // If there is a connection error (like domain not found) or the code is not 200-399
    if ($curlError !== 0 || $httpCode < 200 || $httpCode >= 400) {
        return false;
    }

    return true;
}

function checkIP($ip) {
    $port = 80; 
    $timeout = 2; 
    $fp = @fsockopen(trim($ip), $port, $errCode, $errStr, $timeout);
    if($fp){ fclose($fp); return true; }
    return false;
}

$services = mysqli_query($conn, "SELECT * FROM services");

while ($s = mysqli_fetch_assoc($services)) {
    $id = $s['id'];
    $name = mysqli_real_escape_string($conn, $s['name']);
    $old_status = $s['status'];
    
    $is_online = ($s['type'] == 'website') ? checkWebsite($s['target']) : checkIP($s['target']);
    $new_status = $is_online ? 'online' : 'offline';
    
    // UPDATE DATABASE
    mysqli_query($conn, "UPDATE services SET status = '$new_status' WHERE id = $id");

    // INCIDENT LOGIC
    if ($old_status !== $new_status) {
       if ($new_status == 'offline') {
    $title = "AUTOMATIC: $name is offline";
    $desc = "The system detected that $name ($target) is unreachable at " . date('H:i:s');
    // ... insert query ...
} else {
    $search_title = "AUTOMATIC: $name is offline";
    // ... delete query ...
}
    }
}
echo "Monitor completed at " . date('H:i:s');
?>