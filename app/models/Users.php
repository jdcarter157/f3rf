<?php

class Users {
    protected $db;

    public function __construct(DB\SQL $db){
        // connect model to db
        $this->db = $db;
    }
    public function getUserByEmail($email){
        // return all data about user by email
        $sql = "SELECT * FROM user WHERE email = :email";
        $data = array(":email"=>$email);
        $result = $this->db->exec($sql, $data);
        return $result;
    }

    public function getUserById($id){
        $sql = "SELECT * FROM user WHERE user_id=:id";
        $data = array(":id"=>$id);
        $result = $this->db->exec($sql, $data);
        return $result;
    }
    public function createNew(array $formData) {
        $sql = 'INSERT INTO USER 
                (email, password, first_name, last_name, birthday, about, image_URL) 
                VALUES 
                (:email, :password, :first_name, :last_name, :birthday, :aboutme, :url)';
        $result = $this->db->exec($sql, $formData);
        return $result;
    }

    public function checkEmail($email) {
        // returns true if email is available
        $result = $this->getUserByEmail($email);
        return !isset($result[0]);
    }
    public function getNameFromID($userID){
        $result = $this->db->exec("SELECT * FROM user WHERE user_id = :id", [":id"=>$userID]);
        return $result;
    }
}