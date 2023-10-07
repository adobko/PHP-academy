<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logovc - Students</title>
</head>
<body>
    <?php
    include 'navbar.php';
    require 'classes.php';
    ?>
    <h1 style="color: blue;">Students: </h1>
    <?php
    Render::render_students();
    ?>
</body>
</html>