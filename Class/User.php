<?php
    class User
    {
        public $userID;
        public $username;
        public $password;
        public $email;
        public $phone;
        public $address;
        public $roleID;
        public $fullname;
        public $token;
        public $recovertime;

        public function chk_UserAndPass($con)
        {
            $stmt = $con->prepare("SELECT * FROM user WHERE username = :user");
            $stmt->bindParam(':user', $this->username);

            if($stmt->execute())
            {
                $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

                if(count($user) > 0 && password_verify($this->password, $user[0]->password))
                    return $user;
            }

            return null;
        }

        public function chk_Email($con)
        {
            $stmt = $con->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam('email', $this->email);

            if($stmt->execute())
            {
                $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

                if(count($user) > 0)
                    return $user;
            }

            return null;
        }

        public function chk_Username($con)
        {
            $stmt = $con->prepare("SELECT * FROM user WHERE username = :username");
            $stmt->bindParam(':username', $this->username);

            if($stmt->execute())
            {
                $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

                if(count($user) > 0)
                    return $user;
            }

            return null;
        }

        public function addUser($con)
        {
            $stmt = $con->prepare("INSERT INTO user(username, password, email, roleID) VALUES(:user, :pass, :email, 2)");
            $stmt->bindParam('user', $this->username);
            $stmt->bindParam('pass', $this->password);
            $stmt->bindParam('email', $this->email);

            $id = 0;
            if($stmt->execute())
                $id = $con->lastInsertId();

            return $id;
        }

        public function getAllUser($con)
        {
            $sql = "SELECT * FROM user";
            $stmt = $con->prepare($sql);
            
            if($stmt->execute())
            {
                $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
                if(count($users) > 0)
                    return $users;
            }
            return null;
        }

        public function getAUserByID($con)
        {
            $sql = "SELECT * FROM user WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
                if(count($users) > 0)
                    return $users;
            }
            return null;
        }

        public function updateUser($con)
        {
            $sql = "UPDATE user SET username = :user, email = :email, phone = :phone, address = :address WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':user', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':userID', $this->userID);

            $stmt->execute();
        }

        public function updatePass($con)
        {
            $sql = "UPDATE user SET password = :pass WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':pass', $this->password);
            $stmt->bindParam(':userID', $this->userID);

            $stmt->execute();
        }

        public function updateCus($con)
        {
            $sql = "UPDATE user SET fullname = :fullname, email = :email, phone = :phone, address = :address WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':fullname', $this->fullname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':userID', $this->userID);

            $stmt->execute();
        }

        public function updateUserAdmin($con)
        {
            $sql = "UPDATE user SET username = :user, email = :email, phone = :phone, address = :address, roleID = :roleID WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':user', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':roleID', $this->roleID);
            $stmt->bindParam(':userID', $this->userID);

            $stmt->execute();
        }

        public function deleteUser($con)
        {
            $sql = "DELETE user WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam('userID', $this->userID, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function updateToken($con)
        {
            $sql = "UPDATE user SET token = :token, recovertime = CURRENT_TIMESTAMP WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':token', $this->token, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);

            $stmt->execute();
        }
    }
?>