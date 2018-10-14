<?php
session_start();
$_SESSION["name"]=$_GET["name"];
$_SESSION["pwd"]=$_GET["password"];
$_SESSION["type"]=$_GET["type"];

function test($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data =  htmlspecialchars($data);
	return $data;
}


$name=test($_GET["name"]);
$pwd=test($_GET["password"]);
$type=test($_GET["type"]);




$conn=new mysqli("localhost:3306", "root", "", "chanakya");
if($conn->connect_error)
{
    die("connection failed".$conn->connect_error);
}
$s="select * from accounts where username='$name';";
$r=$conn->query($s);
if($r->num_rows)
{
    while($row=$r->fetch_assoc())
    {
        if($row['username']==$name)
        {
            if($row['password']==$pwd)
            {
                if($row['type']==$type)
                {
                    if($row['type']=='student')
                        header("location: studenthome.php");
                    else 
                    {
                        header("location: companyhome.php");
            
                    }
                }
                else 
                {
                    echo "<html><body><center><p>PLEASE ENTER THE CORRECT TYPE OF LOGIN</p></center></body></html>";
                include 'login.php';
                
                }
            }
            else 
            {
                echo "<html><body><center><p>PLEASE ENTER THE CORRECT PASSWORD</p></center></body></html>";
                include 'index.php';
            }
        }
    }
}
else 
{
     echo "<html><body><center><p>THIS USERNAME IS NOT REGISTERED PLEASE SIGNUP</p></center></body></html>";
            include "index.php";
    
}
    $conn->close();
?>

