<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo ("Cas: " . date("d/m/Y - H:i"));?></h1>
    <div class="form-box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label>Name: </label><input type="text" name="name">
            <input type="submit" value="Prichod" name="arrive">
        </form>
    </div>

    <?php
    date_default_timezone_set("Europe/Berlin");
    function getLogs() {
        $logs = array();
        $file = fopen("logs.txt", "a+");
        while (!feof($file)) {
            $line = fgets($file, filesize("logs.txt"));
            $pair = explode("|", $line);
            array_push($logs, $pair);
        }
        fclose($file);
        return $logs;
    }
    function writeLogs($arrive, $student) {
        $file = fopen("logs.txt", "a+");
        fwrite($file, ($student . "|" . $arrive . "\n"));
        fclose($file);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["arrive"] && $_POST["name"]) {
            $time = date("H:i");
            $hour = (int)date("H");
            $minute = (int)date("i");
            $name = trim(htmlspecialchars($_POST["name"]));

            if ($hour > 8 || ($hour == 8 && $minute > 0)) {
                if ($hour >= 20) {
                    die("Prisiel si uz prilis neskoro.");
                } else {
                    $report = ($time . " Meskanie!");
                }
            } else {
                $report = $time;
            }
            writeLogs($report, $name);
            
        } else {
            echo "<span style='color: red'> *Musis napisat svoje meno! </span>";
        }
    }
    $logs = getLogs();
    if (isset($logs)) {
        echo '<table border="1" style="margin: 20px 20px;">';
        echo '<tr><th>Student:</th><th>Prichod:</th></tr>';    
        foreach ($logs as $pair) {
            echo "<tr>";
            echo "<td>" . $pair[0] . "</td>";
            echo "<td>" . $pair[1] . "</td>";
            echo "</tr>";
        }
        echo '</table>';
    }
    ?>

</body>
</html>