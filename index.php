<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lab 3 &#9979; Logan's Woolworths</title>
</head>
<body>
<nav><h1>Logan's Woolworths</h1></nav>
<?php
    $servername = "db-php.mysql.database.azure.com";
    $username = "adminlogan";
    $password = "Secret123456";
    $db_name = "shopping";
    $conn = mysqli_init();
    
    mysqli_real_connect($conn, $servername, $username, $password, $db_name, 3306);
    if (mysqli_connect_errno($conn)) {
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}
    //mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, MYSQLI_CLIENT_SSL);
    //$connection = new mysqli($servername,$username,$password ,$dbname);
    //if($con->connect_errno){
    //    die("Conection failed: " . $connection->coonect_errno);
    //};
    $sql = "SELECT * FROM products";

    $result = $con->query($sql);

    class Product{
        public $price;
        public $title;
        public $description;
        public $imageID;

        function __construct($title,$imageID,$description,$price){
            $this->price=$price;
            $this->title=$title;
            $this->description=$description;
            $this->imageID=$imageID;
        }
        function __toString(){
            return (string) "<div>"."<h2>".$this->title."</h2>"."</div>".
                            "<div>"."<img src=\"".$this->imageID."\"class=\"center\">"."</div>".
                            "<div>"."<p>".$this->description."</p>"."</div>".
                            "<div>"."<p class=\"price\">"."$".$this->price."</p>"."</div>";
        }
    }
    $array =array();
    
    if(!$result){
        die("Failed running SQL statement: " .$con->error);
    };

    while($row=$result->fetch_assoc()){
        $product=new Product($row['title'],$row['imageID'],$row['description'],$row['price']);
        array_push($array,$product);
    }
    myProduct($array);
    
    
    function myProduct($list){
        echo"<div class=\"flex-container\">";
        foreach($list as $item){
        echo"<div>";
        echo  $item ;
        echo"</div>";   
        }
        echo"</div>";
    }
    mysqli_close($conn);

?>
</body>
</html>
