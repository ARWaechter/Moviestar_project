<?php

require_once("models/User.php");
require_once("models/Message.php");

class UserDAO implements UserDAOInterface
{
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {

        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);

    }

    public function buildUser($data)
    {

        $user = new User();

        $user->id = $data["id"];
        $user->name = $data["name"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->image = $data["image"];
        $user->bio = $data["bio"];
        $user->token = $data["token"];

        return $user;

    }
    
    public function create(User $user, $authUser = false)
    {

        $stmt = $this->conn->prepare("INSERT INTO users(name, lastname, email, password, token) VALUES(:name, :lastname, :email, :password, :token)");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        // AUTENTICATE USER, WHEN AUTH IS TRUE
        if($authUser)
        {
            $this->setTokenToSession($user->token);
        }

    }
    
    public function update(User $user, $redirect = true)
    {

        $stmt = $this->conn->prepare("UPDATE users SET name = :name, lastname = :lastname, email = :email, image = :image, bio = :bio, token = :token WHERE id = :id");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        if($redirect)
        {
            // REDIRECT TO USER PAGE
            $this->message->setMessage("Update successfull", "success", "editprofile.php");
        }

    }
    
    public function verifyToken($protected = false)
    {
        if(!empty($_SESSION["token"]))
        {
            // TAKE SESSION TOKEN
            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if($user)
            {
                return $user;
            }
            else if($protected)
            {
                // REDIRECT USER NOT AUTENTICATED
                $this->message->setMessage("Login to see this page.", "error", "index.php");
            }
        }
        else if($protected)
        {
            // REDIRECT USER NOT AUTENTICATED
            $this->message->setMessage("Login to see this page.", "error", "index.php");
            //return false;
        }
    }
    
    public function setTokenToSession($token, $redirect = true)
    {
        //SAVE TOKEN ON SESSION
        $_SESSION["token"] = $token;

        if($redirect)
        {
            // REDIRECT TO USER PAGE
            $this->message->setMessage("Welcome", "success", "editprofile.php");
        }
    }
    
    public function authenticateUser($email, $password)
    {

        $user = $this->findByEmail($email);

        if($user)
        {

            // CHECK PASSWORD MATCH
            if(password_verify($password, $user->password))
            {
                
                // GENERATE TOKEN AND INSERT ON SESSION
                $token = $user->generateToken();

                $this->setTokenToSession($token);

                // UPDATE USER TOKEN
                $user->token = $token;

                $this->update($user, false);

                return true;

            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }

    }
    
    public function findByEmail($email)
    {

        if($email != "")
        {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            // SUCCESS TEST
            if ($stmt->rowCount() > 0)
            {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
                
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }

    }
    
    public function findById($id)
    {

        if($id != "")
        {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            // SUCCESS TEST
            if ($stmt->rowCount() > 0)
            {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
                
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }

    }
    
    public function findByToken($token)
    {
        if($token != "")
        {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
            $stmt->bindParam(":token", $token);
            $stmt->execute();

            // SUCCESS TEST
            if ($stmt->rowCount() > 0)
            {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
                
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }
    }

    public function destroyToken()
    {
        
        // REMOVE SESSION TOKEN
        $_SESSION["token"] = "";

        // LOGOUT MESSAGE
        $this->message->setMessage("Logout successfuly", "success", "index.php");

    }
    
    public function changePassword(User $user)
    {
        $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        // LOGOUT MESSAGE
        $this->message->setMessage("Password successfuly changed", "success", "editprofile.php");
    }
}