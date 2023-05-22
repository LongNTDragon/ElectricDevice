<?php
    class BillDetail
    {
        public $billID;
        public $proID;
        public $price;
        public $quantity;

        public function addProduct($con)
        {
            $sql = "INSERT INTO billdetail VALUES (:billID, :proID, :price, :quantity)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_INT);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function getAllProductByID($con)
        {
            $sql = "SELECT * FROM billdetail WHERE billID = :billID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $bArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'BillDetail');
                if(count($bArr) > 0)
                    return $bArr;
            }
            return null;
        }

        public function checkProduct($con)
        {
            $sql = "SELECT * FROM billdetail WHERE proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam('proID', $this->proID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $bDArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'BillDetail');
                if(count($bDArr) > 0)
                    return $bDArr;
            }
            return null;
        }

        public function deleteProduct($con)
        {
            $sql = "DELETE FROM billdetail WHERE proID = :proID AND billID = :billID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam('proID', $this->proID, PDO::PARAM_INT);
            $stmt->bindParam('billID', $this->billID, PDO::PARAM_INT);

            $stmt->execute();
        }
    }
?>