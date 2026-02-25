<?php
include('db.php');

/**
 * Functie om een website te controleren (HTTP Status)
 */
function checkWebsite($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // We hebben alleen de header nodig
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Codes tussen 200 en 399 zien we als 'online'
    return ($code >= 200 && $code < 400);
}

/**
 * Functie om een IP-adres te controleren (Ping/Port check)
 */
function checkIP($ip) {
    // We proberen verbinding te maken op poort 80 (of 443)
    // Voor een echte ICMP ping heb je vaak admin rechten nodig op de server
    $port = 80; 
    $waitTimeoutInSeconds = 2; 
    if($fp = @fsockopen($ip, $port, $errCode, $errStr, $waitTimeoutInSeconds)){   
       fclose($fp);
       return true;
    } else {
       return false;
    } 
}

// Haal alle services op uit de database
$services = mysqli_query($conn, "SELECT * FROM services");

echo "<h1>Status Check Run: " . date('H:i:s') . "</h1><hr>";

while ($s = mysqli_fetch_assoc($services)) {
    $id = $s['id'];
    $name = $s['name'];
    $target = $s['target'];
    $type = $s['type'];
    
    echo "Checking <strong>$name</strong> ($target)... ";
    
    $is_online = false;
    
    if ($type == 'website') {
        $is_online = checkWebsite($target);
    } else {
        $is_online = checkIP($target);
    }
    
    $new_status = $is_online ? 'online' : 'offline';
    
    // Update de database als de status is veranderd
    mysqli_query($conn, "UPDATE services SET status = '$new_status' WHERE id = $id");
    
    if ($is_online) {
        echo "<span style='color:green;'>ONLINE</span><br>";
    } else {
        echo "<span style='color:red;'>OFFLINE</span><br>";
    }
}

echo "<hr>Check completed.";
?>