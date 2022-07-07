<?php
class LiveChat {
    public function __construct($db){
        $this->db = $db;
    }

    public function sendMessages($userID, $msgContent){
        //Insert new message into livechat db table
        $result = $this->db->exec("INSERT INTO livechat (user_id, content) VALUES (:userID, :content)", [":userID"=>$userID, ":content"=>$msgContent]);
        return $result;
    }
    
    public function getMessages($userID){
        //Return result of all entries in livechat db table
        $result = $this->db->exec('SELECT l.created, l.content, u.first_name, u.last_name FROM livechat l JOIN user u ON l.user_id = u.user_id;');
        return $result;
    }
}