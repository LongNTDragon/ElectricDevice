<?php
    class Product
    {
        public $proID;
        public $name;
        public $price;
        public $status;
        public $insurance;
        public $image;
        public $catID;

        public function getAllNewProductByCatID($con)
        {
            $sql = "SELECT * FROM product WHERE catID = :catID ORDER BY proID DESC LIMIT 4 OFFSET 0";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':catID', $this->catID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
                if(count($result) > 0)
                    return $result;
            }
            return null;
        }

        public function getAProductByID($con)
        {
            $sql = "SELECT * FROM product WHERE proID = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id', $this->proID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
                if(count($result) > 0)
                    return $result;
            }
            return null;
        }

        public function getProductByPage($con, $limit, $offset, $sort)
        {
            if($sort == "asc")
                $sql = "SELECT * FROM product WHERE catID = :catID ORDER BY price LIMIT :limit OFFSET :offset";
            else
            {
                if($sort == "dsc")
                    $sql = "SELECT * FROM product WHERE catID = :catID ORDER BY price DESC LIMIT :limit OFFSET :offset";
                else
                    $sql = "SELECT * FROM product WHERE catID = :catID ORDER BY proID LIMIT :limit OFFSET :offset";
            }
            
            
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':catID', $this->catID, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            if($stmt->execute())
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
            
            return null;
        }

        public function getAll($con)
        {
            $sql = "SELECT * FROM product WHERE catID = :catID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':catID', $this->catID, PDO::PARAM_INT);

            if($stmt->execute())
            {
                $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
                if(count($result) > 0)
                    return $result;
            }
            return null;
        }

        public function insertProduct($con)
        {
            $sql = "INSERT INTO product(name, price, status, insurance, image, catID) VALUES (:name , :price, :status, :insurance, :image, :catID)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->bindParam(':insurance', $this->insurance, PDO::PARAM_INT);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
            $stmt->bindParam(':catID', $this->catID, PDO::PARAM_INT);

            $id = 0;
            if($stmt->execute())
                $id = $con->lastInsertId();
            return $id;
        }

        public function updateProduct($con)
        {
            $sql = "UPDATE product SET name = :name, price = :price, status = :status, insurance = :insurance WHERE proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->bindParam(':insurance', $this->insurance, PDO::PARAM_INT);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_STR);

            $stmt->execute();
        }

        public function deleteProduct($con)
        {
            $sql = "DELETE FROM product WHERE proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function updateProImg($con)
        {
            $sql = "UPDATE product SET image = :image WHERE proID = :proID";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
            $stmt->bindParam(':proID', $this->proID, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function findProduct($con, $str)
        {
            $sql = "SELECT * FROM product WHERE name LIKE '%" . $str . "%'";
            $stmt = $con->prepare($sql);
            
            if($stmt->execute())
            {
                $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
                if(count($result) > 0)
                    return $result;
            }
            return null;
        }
    }
?>