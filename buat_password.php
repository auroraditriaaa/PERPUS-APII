<?php

$password = "admin123";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password asli: " . $password . "<br><br>";
echo "Password hash:<br>";
echo $hash;