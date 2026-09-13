<?php

$SUPABASE_URL = getenv('SUPABASE_URL') ?: '';
$SUPABASE_KEY = getenv('SUPABASE_KEY') ?: '';

if ($SUPABASE_URL === '' || $SUPABASE_KEY === '') {
    die('Supabase configuration is missing. Set SUPABASE_URL and SUPABASE_KEY.');
}

$url = $SUPABASE_URL . "/rest/v1/";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

if ($error) {
    die("❌ Connection failed: " . $error);
}

echo "<h2>Supabase Connection Test</h2>";
echo "<p>HTTP Status: $httpCode</p>";

if ($httpCode >= 200 && $httpCode < 300) {
    echo "<p style='color:green'>✅ Connected to Supabase!</p>";
} else {
    echo "<p style='color:red'>❌ Supabase connection failed</p>";
}

echo "<h3>Response:</h3>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";