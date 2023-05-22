<?php
    class Bill
    {
        public $billID;
        public $userID;
        public $createdDate;
        public $receivedDate;
        public $sumMoney;
        public $billStatus;

        public function createBill($con)
        {
            $sql = "INSERT INTO bill(userID) VALUES (:userID)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);

            $id = 0;
            if($stmt->execute())
                $id = $con->lastInsertId();

            return $id;
        }

        public function updateSumMoney($con)
        {
            $sql = "UPDATE bill SET sumMoney = :sumMoney WHERE billID = :billID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':sumMoney', $this->sumMoney, PDO::PARAM_INT);
            $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function getAllBillOfUser($con)
        {
            $sql = "SELECT * FROM bill WHERE userID = :userID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $bArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Bill');
                if(count($bArr) > 0)
                    return $bArr;
            }
            return null;
        }

        // public function getABillByBillID($con)
        // {
        //     $sql = "SELECT * FROM bill WHERE userID = :userID AND billID = :billID";
        //     $stmt = $con->prepare($sql);
        //     $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        //     $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);

        //     if($stmt->execute())
        //     {
        //         $bArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Bill');
        //         if(count($bArr) > 0)
        //             return $bArr;
        //     }
        //     return null;
        // }

        public function getAllBill($con)
        {
            $sql = "SELECT * FROM bill";
            $stmt = $con->prepare($sql);
            
            if($stmt->execute())
            {
                $bArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Bill');
                if(count($bArr) > 0)
                    return $bArr;
            }
            return null;
        }

        public function getABill($con)
        {
            $sql = "SELECT * FROM bill WHERE billID = :billID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);
            
            if($stmt->execute())
            {
                $bArr = $stmt->fetchAll(PDO::FETCH_CLASS, 'Bill');
                if(count($bArr) > 0)
                    return $bArr;
            }
            return null;
        }

        public function updateBill($con)
        {
            $sql = "UPDATE bill SET billStatus = 1, receivedDate = CURRENT_TIMESTAMP WHERE billID = :billID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);
            
            $stmt->execute();
        }

        public function deleteBill($con)
        {
            $sql = "DELETE FROM bill WHERE billID = :billID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':billID', $this->billID, PDO::PARAM_INT);
            
            $stmt->execute();
        }
    }
?>