<?php
date_default_timezone_set("Europe/Berlin");
class Name {
    public static function validate_name($name) {
        if (preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            return True;
        } else{
            return False;
        }
    }
    public static function clean_name($name) {
        $name = filter_var($name, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_NO_ENCODE_QUOTES);
        $name = htmlspecialchars(trim(stripslashes($name)));
        return $name;
    }
}
trait File {
    public static function get_logs($file) {
        if (file_exists($file)) {
            $logs = json_decode(file_get_contents($file), true);
        } else {
            touch($file);
            $logs = array();
        }
        return $logs;
    }
    protected static function update_logs($logs, $file) {
        $logs = json_encode($logs, JSON_PRETTY_PRINT);
        $json = fopen($file, "w");
        fwrite($json, $logs);
        fclose($json);
    }
}
class Student {
    use File;
    public $name;
    public function __construct($name) {
        $this->name = $name;
    }
    public function register() {
        $students = self::get_logs("students.json");
        if (!isset($students[$this->name])) {
            $students[$this->name] = 0;
            $this->update_logs($students, "students.json");
            echo "<span style='color: green'> *Ahoj {$this->name}, uspesne si sa zaregistroval! </span>";
        } else {
            echo "<span style='color: red'> *Toto meno je uz zaregistrovane! </span>";
        }
    }
    public function arrive() {

        $students = self::get_logs("students.json");
        $arrivals = self::get_logs("arrivals.json");
        if (isset($students[$this->name])) {   
            $report = date("H:i");
            $hour = (int)date("H");
            $minute = (int)date("i");      
            if ($hour>8 || ($hour==8 && $minute>0)) {
                if ($hour >= 20) {
                    die("<span style='color: red; margin:20px;'>!!! prisiel si uz prilis neskoro !!! </span>");
                } else {
                    $report .= " Meskanie!";
                }
            } else if ($hour <= 5) {
                die("<span style='color: red; margin:20px;'>!!! prisiel si prilis skoro !!! </span>");
            }
            $students[$this->name] += 1;
            self::update_logs($students, "students.json");
            $arrivals[] = array(
                "student" => $this->name,
                "time" => $report
            );
            self::update_logs($arrivals, "arrivals.json");
            echo "<span style='color: green'> *{$this->name}, tvoj prichod bol zaznamenany! </span>";
        } else {
            echo "<span style='color: red'> *Toto meno este nieje zaregistrovane! <a href='register.php'>Registrovat</a></span>";
        }
    }
}
class Render {
    use File; 
    public static function render_arrivals() {
        $arrivals = self::get_logs("arrivals.json"); // error
        if (isset($arrivals)) {
            echo "<table border='1'><tr><th>Student</th><th>Cas</th></tr>";
            foreach ($arrivals as $arrival) {
                echo "<tr>";
                echo "<td>{$arrival['student']}</td>";
                echo "<td>{$arrival['time']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    public static function render_students() {
        $students = self::get_logs("students.json"); // error
        if (isset($students)) {
            echo "<table border='1'><tr><th>Student</th><th>Pocet prichodou</th></tr>";
            foreach ($students as $name => $value) {
                echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$value}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}
?>