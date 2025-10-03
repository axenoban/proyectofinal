<?php
$pass = "1234";

$hash = password_hash($pass, PASSWORD_DEFAULT);

echo "Hash generado: " . $hash;