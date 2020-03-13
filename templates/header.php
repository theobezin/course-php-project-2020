<?php
session_start();



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Rememboard</title>
    <link href="/style/style-dark.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


<div class="navbar">
    <img id="logo-navbar"  src="../logo.png">
    <?php if (isset($_SESSION['id'])): ?>
        <a href="#"><i class="fa fa-fw fa-user"></i> Logout</a>
    <?php else: ?>
        <a href="#"><i class="fa fa-fw fa-user"></i> Login</a>
    <?php endif; ?>
</div>


