
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




if(isset($_POST['ok'])){
$pdo = Database::connect();   
$login=$_POST['login'];
$prenom=$_POST['prenom'];
$nom=$_POST['nom'];
$password=$_POST['password'];
$confirmpassword=$_POST['confirmpassword'];

if ($password != $confirmpassword){
    echo "les mots de passe ne correspondent pas";
    exit();
}else{
 


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$requete =$pdo->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES ('$login', '$prenom', '$nom', '$password')");
$requete->execute(
 );
 $user = $requete->fetch(PDO::FETCH_ASSOC);

 //header("Location: index.php");
}
}

$pdo = Database::disconnect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="module.css">
    <title>INSCRIPTION</title>
</head>
<h1 style="text-align: center;">CREATION DE COMPTE</h1>



<body>
<div class="contaiiner">
<div class="user-input-box">
    <form method="POST" >
        <label for="login">login</label>
        <input type="text" id="login" name="login" placeholder="entrer votre identifiant" required>
</div>
</br>
<div class="user-input-box">
        <label for="prenom">prenom</label>
        <input type="text" id="prenom" name="prenom" placeholder="entrer votre prenom" required>
</div>
</br>
<div class="user-input-box">
        <label for="nom">nom</label>
        <input type="text" id="nom" name="nom" placeholder="entrer votre nom" required>
</div>
</br>
<div class="user-input-box">
        <label for="pass">password</label>
        <input type="password" id="pass" name="password" placeholder="entrer votre mot de passe" required>
</div>
</br>
<div class="user-input-box">
        <label for="confirmpass">confirm password</label>
        <input type="password" id="confirmpass" name="confirmpassword" placeholder="confirmation mot de passe" required>
</br>
    </br>
<div class="form-submit-btn">
        <input type="submit" value="creer" name="ok">
</div>
</div>
</form>
    </body>
</html>