<?php
date_default_timezone_set("Europe/Berlin");
class Student {
    public $name;
    public $arrives;
    public function __construct($name) {
        $this->name = $name;
    }
    static public function validate_name($name) {
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            return False;
        } else{
            return True;
        }
    }
    static public function clean_name($name) {
        $name = htmlspecialchars(trim(stripslashes($name)));
        return $name;
    }
    static public function get_logs($file) {
        $logs = array();
        $json = fopen($file, "a+");
        if (filesize($file) > 0) {
            $logs = fread($json, filesize($file));
            $logs = json_decode($logs, true);
        } else {
            $logs = array();
        }
        fclose($json);
        return $logs;
    }
    private function update_logs($logs, $file) {
        $logs = json_encode($logs, JSON_PRETTY_PRINT);
        $json = fopen($file, "w");
        fwrite($json, $logs);
        fclose($json);
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
            }
            $students[$this->name] += 1;
            $this->update_logs($students, "students.json");
            $arrivals[] = array(
                "student" => $this->name,
                "time" => $report
            );
            $this->update_logs($arrivals, "arrivals.json");
            echo "<span style='color: green'> *{$this->name}, tvoj prichod bol zaznamenany! </span>";
        } else {
            echo "<span style='color: red'> *Toto meno este nieje zaregistrovane! <a href='register.php'>Registrovat</a></span>";
        }
    }
    static public function render_arrivals() {
        sleep(10);
        $arrivals = self::get_logs("arrivals.json");
        echo var_dump(is_null($arrivals));
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
    static public function render_students() {
        $students = self::get_logs("students.json");
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
