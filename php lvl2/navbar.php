<style>
    header {
        font-family: serif;
        font-weight: 100;
    }
    nav ul {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    nav ul li {
        background-color: rgb(200, 200, 200);
        border-radius: 20px;
        width: fit-content;
        padding: 10px 10px;
        margin: 10px 10px;
    }
    nav ul li:hover {
        cursor: pointer;
        opacity: 85%;
    }
    nav ul li a {
        text-decoration: none;
        color: rgb(10, 10, 10);
        font-size: 30px;
    }
    #current {
        background-color: rgb(150, 150, 255);
    }
</style>
<header>
    <nav>
        <ul>
            <li><a href='app.php'>Logovac</a></li>
            <li><a href="render_students.php">Students</a></li>
            <li><a href='register.php'>Registracia</a></li>
        </ul>
        <h2>
            <?php
            date_default_timezone_set("Europe/Berlin");
            echo date("d/m/Y - H:i");
            ?>
        </h2>
    </nav>
</header>

