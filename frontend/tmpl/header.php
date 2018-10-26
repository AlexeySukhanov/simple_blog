<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Site Name</title>
    <link rel="stylesheet" href="frontend/ext/foundation/css/foundation.css">
    <link rel="stylesheet" href="frontend/int/css/main.css">
</head>
<body>

<div class="grid-container">
    <a href="<?php echo $this->base->url . '/admin' ?>" class="button">Admin login</a>
    <div>
        <?php if (!empty($_SERVER['PHP_SELF'])) {
            echo 'current url: ' . $_SERVER['PHP_SELF'];
        } ?> <br>
    </div>

