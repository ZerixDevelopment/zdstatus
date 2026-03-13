<?php
include('db.php');

function checkWebsite($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY         => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($code >= 200 && $code < 400);
}

function checkIP($ip) {
    $port = 80; 
    $waitTimeoutInSeconds = 2; 
    if($fp = @fsockopen($ip, $port, $errCode, $errStr, $waitTimeoutInSeconds)){   
       fclose($fp);
       return true;
    }
    return false;
}

$services = mysqli_query($conn, "SELECT * FROM services");
$updateStmt = $conn->prepare("UPDATE services SET status = ? WHERE id = ?");

echo "<h1>Status Check: " . date('H:i:s') . "</h1><hr>";

while ($s = mysqli_fetch_assoc($services)) {
    $is_online = ($s['type'] == 'website') ? checkWebsite($s['target']) : checkIP($s['target']);
    $new_status = $is_online ? 'online' : 'offline';
    
    // Alleen updaten bij wijziging
    if ($new_status !== $s['status']) {
        $updateStmt->bind_param("si", $new_status, $s['id']);
        $updateStmt->execute();
    }
    
    $color = $is_online ? 'green' : 'red';
    echo "Checking <strong>{$s['name']}</strong>: <span style='color:$color;'>" . strtoupper($new_status) . "</span><br>";
}

$updateStmt->close();
echo "<hr>Check completed.";
?>