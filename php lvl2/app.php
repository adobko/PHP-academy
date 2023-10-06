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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">
            <label>Name: </label><input type="text" name="name">
            <input type="submit" value="Prichod" name="arrive">
        </form>
    </div>
    <br>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if ($_GET["arrive"] && $_GET["name"]) {
            $name = Student::clean_name($_GET["name"]);
            if (Student::validate_name($name)){
                $student = new Student($name);
                $student->arrive();
            } else {
                echo "<span style='color: red'> *Toto meno nieje validne! </span>";
            }
        }
    } else {
        echo "<span style='color: red'> *Napis meno, ktorym si sa zaregistroval! </span>";
    }
    //Student::render_students();
    Student::render_arrivals();
    ?>
</body>
</html>