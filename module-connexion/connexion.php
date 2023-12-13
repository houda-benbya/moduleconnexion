<?php
$admin='admin';


class Database{

    private static $servername = 'localhost';
    private static $username = 'root';
    private static $passwordBDD = '';
    private static $BDD ='moduleconnexion';
    private static $conn = null;
    
    
    public static function _construct(){
        die('Init function is not allowed');
    }
    
    public static function connect(){ //fonction de connexion à la BDD
        if (null == self::$conn){ //si la connexion est nulle
            try{ //on essaie de se connecter
                self::$conn = new PDO("mysql:host=".self::$servername.";"."dbname=".self::$BDD,self::$username,self::$passwordBDD); //on se connecte à la BDD
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

session_start();
//session_destroy();
$user=[];
if ($_SERVER["REQUEST_METHOD"] == "POST") { //si la méthode de requête est POST on récupère les données du formulaire
    $login = $_POST["login"]; //on récupère le login
    $password = $_POST["password"]; //on récupère le password
    $pdo = Database::connect(); //on se connecte à la BDD
    // Assuming you have a PDO instance $db
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //on définit le mode d'erreur de PDO
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'"); //on prépare la requête SQL pour récupérer le login et le password de l'utilisateur connecté
   // var_dump($stmt);
    $stmt->execute(); //on exécute la requête SQL pour récupérer le login et le password de l'utilisateur connecté
    $user = $stmt->fetch(PDO::FETCH_ASSOC); //on récupère les résultats de la requête SQL pour récupérer le login et le password de l'utilisateur connecté

}


if (isset($user) && count($user) == 1){

        if ($user[0]['login'] == $admin and $user[0]['password'] == $admin) { //si le login et le password sont égaux à admin on redirige vers la page admin.php
            $_SESSION["login"] == $user[0]['login']; //on crée une session pour l'admin
            $_SESSION["password"] == $user[0]['login']; //on crée une session pour l'admin
           var_dump($login);
            var_dump($password);
           header("Location: admin.php");
    }
    else{ //sinon on redirige vers la page profil.php
        $_SESSION["login"] = $login; //on crée une session pour l'utilisateur
        $_SESSION["password"] = $password; //on crée une session pour l'utilisateur
        var_dump($login);
        var_dump($password);
        header("Location: profil.php");
        exit();
    }
}

Database::disconnect();
//<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>


<!DOCTYPE html>
<html>
<body>
<link rel="stylesheet" href="module.css">
<h1 style="text-align: center;">VEUILLEZ VOUS CONNECTER POUR ACCEDER A NOS COURS EN LIGNE</h1>

<div class="contaiiner">
<div class="user-input-box">   
<form method="post" action="">
    Login: <input type="text" name="login" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit">
</div>
</div>
</form>
</body>
</html>