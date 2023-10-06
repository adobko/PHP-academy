<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logovc - Register</title>
</head>
<body>
    <?php 
    include 'navbar.php';
    require 'classes.php';
    ?>
    <div class="form-box">
        <h1 style="color: blue;">Registrecia: </h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label>Name: </label><input type="text" name="name">
            <input type="submit" value="Registrovat" name="register">
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["name"] && $_POST["register"]) {
            $name = Student::clean_name($_POST["name"]);
            if (Student::validate_name($name)) {
                $student = new Student($name);
                $student->register();
            } else {
                echo "<span style='color: red'> *Toto meno nieje validne! </span>";
            }
        } else {
            echo "<span style='color: red'> *Musis napisat svoje meno! </span>";
        }

    }
    ?>
</body>
</html>