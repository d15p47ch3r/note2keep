<?php
$base_url = 'https://note2keep.herokuapp.com';
$data_directory = 'tmp';
function sanitizeString($string) {
    return preg_replace('/[^a-zA-Z0-9]+/', '', $string);
}
function generateRandomString($length = 5) {
    $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (empty($_GET['f']) || sanitizeString($_GET['f']) !== $_GET['f']) {
    header('Location: ' . $base_url . '/' . generateRandomString());
    die();
}

$name = sanitizeString($_GET['f']);
$path = $data_directory . DIRECTORY_SEPARATOR . $name;

if (isset($_POST['t'])) {
    file_put_contents($path, $_POST['t']);
    die();
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'curl') === 0) {
    print file_get_contents($path);
    die();
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="generator" content="Note2Keep - Simply & Easy way to save your notes" />
    <title>Note2Keep - Simply & Easy way to save your notes</title>
    <link rel="shortcut icon" href="<?php print $base_url; ?>/favicon.ico" />
    <link href="<?php print $base_url; ?>/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <textarea id="content"><?php
            if (file_exists($path))                 print htmlspecialchars(file_get_contents($path), ENT_QUOTES, 'UTF-8');
            else echo 'Project: Note2Keep - Made by Dispatcher'
?></textarea>
    <pre id="printable"></pre>
    </div>
    <script src="<?php print $base_url; ?>/script.js"></script>
</body>
</html>
