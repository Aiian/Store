<?php

class Product {
    
    private $id; // int
    private $name; // string
    private $price; // float
    private $description; // string
    private $image; // array of links???
    
    public function __construct() {
         $this->setId(-1);
         $this->setName(null);
         $this->setPrice(null);
         $this->setDescription(null);
         $this->setImage(null);
    }

    private function loadFromDB($conn, $id){
        $sql = "SELECT products.id, `name`, `price`, `description`, `image` FROM `products` LEFT JOIN `products_images` ON products.id = products_                 images.products_id WHERE products.id = $id";
        $result = $conn->query($sql);
        if (!$result){
            throw new Exception('Error connecting to database.');
//            return false;    // to be decided, if connection errors should be handled by Exceptions
        } else {
            foreach($result as $row){
                $this->setId($row['id']);
                $this->setName($row['name']);
                $this->setPrice($row['price']);
                $this->setDescription($row['description']);
                $this->setImage($row['image']);
            }
            return true;
        }
    }
    
    public function create($conn, $name, $price, $description){
        $sql = "INSERT INTO `products` (`name`, `price`, `description`) VALUES ('$name', '$price', '$description')";
        $result = $conn->query($sql);
        if (!$result){
            throw new Exception('Error connecting to database.');
//            return false;    // to be decided, if connection errors should be handled by Exceptions
        } else {
            $this->setId($result->insert_id);
            $this->setName($name);
            $this->setPrice($price);
            $this->setDescription($description);
            return true;
        }
    }
    
    public function uploadImage($conn, $id, $image){
        
        $this->loadFromDB($conn, $id);

        $sql = "INSERT INTO `products_images` (`image`, `products_id`) VALUES ('$image', '$id')";
        $result = $conn->query($sql);
        if (!$result){
            throw new Exception('Error connecting to database.');
//            return false;    // to be decided, if connection errors should be handled by Exceptions
        } else {        
            $this->setImage($image);
            return true;
        }
    }
    
    public function update($conn, $id, $name, $price, $description){
        
        $this->loadFromDB($conn, $id);

        $sql = "UPDATE `products` SET `name` = '$name', `price` = '$price', `description` = '$description' WHERE id = $id";
        $result = $conn->query($sql);
        if (!$result){
            throw new Exception('Error connecting to database.');
//            return false;    // to be decided, if connection errors should be handled by Exceptions
        } else {
            $this->setId($result->insert_id);
            $this->setName($name);
            $this->setPrice($price);
            $this->setDescription($description);
            return true;
        }
    }
    
    // returns array of ALL products or one product as object, if product $id is given
    public function listProducts($conn, $id = null){ 
            $productList = []; 
            $sql = "SELECT `id` FROM `products`";
            $result = $conn->query($sql);
            if (!$result){
                throw new Exception('Error connecting to database.');
    //            return false;    // to be decided, if connection errors should be handled by Exceptions
            } elseif ($id === null) {        
                foreach ($result as $row){
                    $this->loadFromDB($conn, $row['id']);
                    $productList[] = $this;
                }
                return $productList;
            } else {
                $this->loadFromDB($conn, $id);
                return $this;
            }
    }
    
    // getters and setters
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getImage() {
        return $this->image;
    }
    public function setId($id) {
        $this->id = $id;
    }
        public function setName($name) {
        $this->name = $name;
    }
    public function setPrice($price) {
        $this->price = $price;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
    public function setImage($image) {
        $this->image = $image;
    }


    
    
    
    
    
    
    
    
    
    
    
    
}
