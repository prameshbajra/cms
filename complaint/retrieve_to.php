<?php
/* Attempt Mysql server connection. Assuming you are running MySQL
server with default setting  (user 'root' with no password)*/
$link=mysqli_connect("localhost","root", "", "cms");
if($link===false){
    die("ERROR: could not connect". mysqli_connect_error());
}

$sql="SELECT * FROM users";
if($result=mysqli_query($link,$sql)){
    if(mysqli_num_rows($result)>0){
        echo"<table border='1'>";
        echo"<tr>";
        echo"<th>id</th>";
        echo"<th>user_id</th>";
        echo"<th>product_description</th>";
        echo"<th>complaint</th>";
        echo"<th>status</th>";
        echo"<th>Edit</th>";
        echo "<th>Delete</th>";

        echo"</tr>";
        foreach ($result as $row){
            echo"<tr>";
            echo"<td>".$row['id']."</td>";
            echo"<td>".$row['user_id']."</td>";
            echo"<td>".$row['product_description']."</td>";
            echo"<td>".$row['complaint']."</td>";
            echo"<td>".$row['status']."</td>";
            echo '<td><a href="update.php?id=' . $row['id']. '">Edit</a></td>';
            echo '<td><a href="delete.php? id=' . $row['id'] .'">Delete</a> </td>';
            echo"</tr>";

        }
        echo"</table>";
        //Free Result Set

        mysqli_free_result($result);
    }else{
        echo"ERROR:Could not able to execute $sql.".mysqli_error($link);
    }
    mysqli_close($link);

}
?>