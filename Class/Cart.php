<?php
    class Cart
    {
        public $userID;
        public $proID;
        public $quantity;

        public function countProductInCart($con)
        {
            $sql = "SELECT * FROM cart WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $cartArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cart');
                if(count($cartArr) > 0)
                    return count($cartArr);
            }
            return 0;
        }

        public function findProductOfUser($con)
        {
            $sql = "SELECT * FROM cart WHERE userID = :userID AND proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $cartArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cart');
                if(count($cartArr) > 0)
                    return $cartArr;
            }
            return null;
        }

        public function addProduct($con)
        {
            $sql = "INSERT INTO cart VALUES (:userID, :proID, :quantity)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);

            if($stmt->execute())
                return $con->lastInsertId();
            return null;
        }
        
        public function updateQuantity($con)
        {
            $sql = "UPDATE cart SET quantity = :quantity WHERE userID = :userID AND proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function getAllProductOfUser($con)
        {
            $sql = "SELECT * FROM cart WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $cartArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cart');
                if(count($cartArr) > 0)
                    return $cartArr;
            }
            return null;
        }

        public function deleteProduct($con)
        {
            $sql = "DELETE FROM cart WHERE proID = :proID AND userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam('proID', $this->proID, PDO::PARAM_INT);
            $stmt->bindParam('userID', $this->userID, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function checkProduct($con)
        {
            $sql = "SELECT * FROM cart WHERE proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam('proID', $this->proID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $cartArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cart');
                if(count($cartArr) > 0)
                    return $cartArr;
            }
            return null;
        }
    }
?>