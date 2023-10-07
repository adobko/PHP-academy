<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logovc</title>
</head>
<body>
    <?php 
    include 'navbar.php';
    require 'classes.php';
    ?>
    <div class="form-box">
        <h1 style="color: blue;">Zaznamenanie prichodu: </h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label>Name: </label><input type="text" name="name">
            <input type="submit" value="Prichod" name="arrive">
        </form>
    </div>
    <br>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["name"]) && !empty($_POST["name"])) {
            $name = Name::clean_name($_POST["name"]);
            if (Name::validate_name($name)){
                $student = new Student($name);
                $student->arrive();
            } else {
                echo "<span style='color: red'> *Toto meno nieje validne! </span>";
            }
        } 
    } else {
        echo "<span style='color: red'> *Napis meno, ktorym si sa zaregistroval! </span>";
    }
    Render::render_arrivals();
    ?>
</body>
</html>