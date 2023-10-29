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
    $host = "php-db-postgre.postgres.database.azure.com";
    $user = "adminlogan@php-db-postgre";
    $password = "Secret123456";
    $database = "postgres";
    $port=5432;

    $conn = pg_connect("host=$host port=$port dbname=$database user=$user password=$password") or die("Failed to create connection to database: ". pg_last_error(). "<br/>");
    print "Successfully created connection to database.<br/>";

    $query = "DROP TABLE IF EXISTS products;";
	pg_query($conn, $query) 
		or die("Encountered an error when executing given sql statement: ". pg_last_error(). "<br/>");
	print "Finished dropping table (if existed).<br/>";

    $query1 = "CREATE TABLE products (productID int NOT NULL PRIMARY KEY, title text NOT NULL, description text NOT NULL, price money NULL, imageID text NOT NULL);";
	pg_query($conn, $query1) 
		or die("Encountered an error when executing given sql statement: ". pg_last_error(). "<br/>");
	print "Finished creating table.<br/>";

    $query2="INSERT INTO products (productID, title, description, price, imageID) VALUES
    (1, 'Sony PlayStation 5 Console', 'Experience lightning-fast loading with an ultra-high-speed SSD, deeper immersion with support for haptic feedback, adaptive triggers and 3D Audio, and an all-new generation of incredible PlayStation game', '834.00', 'ps5.jpg'),
    (2, 'Xbox Series X', 'Through the revolutionary new Xbox Velocity Architecture, thousands of games on Xbox One, including Xbox 360 and original Xbox Games, will experience improvements in performance, including improved boot and load times, more stable frame rates, higher resolutions and improved quality on Xbox Series X.', '899.00', 'xox.jpg'),
    (3, 'PlayStation 2', 'The PlayStation 2 (PS2) is a home video game console developed and marketed by Sony Interactive Entertainment.', '173.99', 'ps2.jpg'),
    (4, 'Xbox One', 'The Xbox One is a home video game console developed by Microsoft. Announced in May 2013, it is the successor to Xbox 360 and the third console in the Xbox series.', '300.00', 'xbox1.jpg'),
    (5, 'Nintendo Switch', 'The Nintendo Switch is a video game console developed by Nintendo and released worldwide in most regions on March 3, 2017.', '629.00', 'switch.jpg'),
    (7, 'Xbox Series S', 'Go all-digital and enjoy disc-free, next-gen gaming with the smallest Xbox console ever made.', '599.00', 'xs.jpg'),
    (8, 'PS5 PlayStation 5 Console Marvel’s Spider-Man 2 Limited Edition Bundle', 'Get the PlayStation®5 Console – Marvel’s Spider-Man 2 Limited Edition Bundle with a symbiote takeover design, and experience the next game in the Marvel’s Spider-Man franchise. This bundle includes a PS5 console with Limited Edition console covers, a Limited Edition DualSense wireless controller, a voucher for a digital copy of the game, and pre-order incentive items.', '1089.00', 'sp.jpg'),
    (9, 'Xbox 360 S', 'The Xbox 360 is a home video game console developed by Microsoft. As the successor to the original Xbox, it is the second console in the Xbox series.', '68.00', '360.jpg');";
    pg_query($conn, $query2) or die("Encountered an error when executing given sql statement: ". pg_last_error(). "<br/>");

    //$conn = mysqli_init();
    
    //mysqli_real_connect($conn, $servername, $username, $password, $db_name, 3306);
    //if (mysqli_connect_errno($conn)) {
    //die('Failed to connect to MySQL: '.mysqli_connect_error());
    //}
    //mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, MYSQLI_CLIENT_SSL);
    //$connection = new mysqli($servername,$username,$password ,$dbname);
    //if($con->connect_errno){
    //    die("Conection failed: " . $connection->coonect_errno);
    //};
    $sql = "SELECT * FROM products";
    $result =pg_query($conn, $sql)or die("Encountered an error when executing given sql statement: ". pg_last_error(). "<br/>");    
    //$result = $conn->query($sql);

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
                            "<div>"."<p class=\"price\">".$this->price."</p>"."</div>";
        }
    }
    $array =array();
    
    if(!$result){
        die("Failed running SQL statement: " .pg_last_error());
    };

    while($row=pg_fetch_assoc($result)){
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
    pg_close($conn);

?>
</body>
</html>
