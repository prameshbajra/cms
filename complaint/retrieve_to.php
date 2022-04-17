
<?php
/* Attempt Mysql server connection. Assuming you are running MySQL
server with default setting  (user 'root' with no password)*/
$link = mysqli_connect("localhost", "root", "", "cms");
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($link === false) {
        die("ERROR: could not connect" . mysqli_connect_error());
    }

    echo "
    <div>
        <a href='logout.php'>Click here to log out</a>
    </div>
    <br><br><br>
    <h3>Users List</h3>";
    $sql = "SELECT * FROM users";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>id</th>";
            echo "<th>email</th>";
            echo "<th>role</th>";
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";

            echo "</tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo '<td><a href="update_users.php?id=' . $row['id'] . '">Edit</a></td>';
                echo '<td><a href="delete_users.php? id=' . $row['id'] . '">Delete</a> </td>';
                echo "</tr>";

            }
            echo "</table>";
        }
    }

    echo "<br><br><br> <h3>Compliant List</h3>";

    $sql = "SELECT * FROM complaint";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Id</th>";
            echo "<th>User Id</th>";
            echo "<th>Product Description</th>";
            echo "<th>Compliant</th>";
            echo "<th>Status</th>";
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
            echo "</tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['product_description'] . "</td>";
                echo "<td>" . $row['complaint'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo '<td><a href="update_complaints.php?id=' . $row['id'] . '">Edit</a></td>';
                echo '<td><a href="delete_complaints.php?id=' . $row['id'] . '">Delete</a> </td>';
                echo "</tr>";

            }
            echo "</table>";
            //Free Result Set

            mysqli_free_result($result);
        } else {
            echo "Such Empty! Much wow !! <br> No complaints.";
        }
        mysqli_close($link);
    }
} else {
    echo "<h3>Looks like you're lost. <a href='http://localhost/final_project/complaint/login.php'>Login</a></h3>";
}
?>


