<?php

class Database{

    private static $servername = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $BDD ='moduleconnexion';
    private static $conn = null;
    
    
    public static function _construct(){
        die('Init function is not allowed');
    }
    
    public static function connect(){ //fonction de connexion à la BDD
        if (null == self::$conn){ //si la connexion est nulle
            try{ //on essaie de se connecter
                self::$conn = new PDO("mysql:host=".self::$servername.";"."dbname=".self::$BDD,self::$username,self::$password); //on se connecte à la BDD
            }catch(PDOException $e){
                die($e->getMessage());
            }
        }
        return self::$conn;
    }
    
    public static function disconnect(){
        self::$conn = null;
    }
    
    }
    $pdo = Database::connect(); 

session_start();

if (!isset($_SESSION["login"])&& $_SESSION ["login"] != 'admin' && !isset($_SESSION["password"]) && $_SESSION["password"] != "admin") {
    header("Location: connexion.php");
    exit();//si la session login n'existe pas on redirige vers la page connexion.php

} 

$stmt = $pdo->prepare("SELECT * FROM utilisateurs"); //on prépare la requête SQL pour récupérer tous les utilisateurs
$stmt->execute(); //on exécute la requête SQL pour récupérer tous les utilisateurs
$users = $stmt->fetchAll(); //on récupère les résultats de la requête SQL pour récupérer tous les utilisateurs

$pdo = Database::disconnect();

?>

<!DOCTYPE html>
<html>
<body>
<table> 
    <tr>
        <th>ID</th>
        <th>prenom</th>
        <th>nom</th>
        <th>login</th>
        <th>password</th>
    </tr>  
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['prenom']; ?></td>
        <td><?php echo $user['nom']; ?></td>
        <td><?php echo $user['login']; ?></td>
        <td><?php echo $user['password']; ?></td>
    </tr>
    <?php endforeach; ?>
    



</table>
</body>
</html>









    $pdo = Database::disconnect();

?>