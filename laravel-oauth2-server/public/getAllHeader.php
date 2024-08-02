<?php
// Get all headers
$headers = getallheaders();

// Output all headers
foreach ($headers as $name => $value) {
    echo "$name: $value <br>";
}
?>