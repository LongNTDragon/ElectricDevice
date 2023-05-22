<?php
    class Categories
    {
        public $catID;
        public $catName;

        public function getAllCategories($con)
        {
            $sql = "SELECT * FROM categories";
            $stmt = $con->prepare($sql);

            if($stmt->execute())
            {
                $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Categories');
                if(count($result) > 0)
                    return $result;
            }
            return null;
        }
    }
?>