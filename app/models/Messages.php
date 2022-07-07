<?php



class Messages {

    //Initialize db and id variable
    public function __construct($db){
        $this->db = $db;
        
    }

    
    public function loadDMList($userID) {
        /**
         * Query searches for unique dm's user has with other users
         * 
         * Returns [user_id, first_name, last_name, image_URL] of dm partners
        **/
        $data = array(":myID"=>$userID);
        $result = $this->db->exec("WITH ids AS 
                                    (
                                        SELECT 
                                            
                                            user_1
                                            , user_2 
                                        FROM message 
                                        WHERE 
                                            (user_1 = :myID OR user_2 = :myID) 
                                    ),
                                messaged_friends AS
                                    (
                                        SELECT user_2 
                                        FROM ids 
                                        WHERE user_1 = :myID 
                                            UNION 
                                        SELECT user_1 
                                        FROM ids 
                                        WHERE user_2 = :myID
                                    )
                                SELECT 
                                    user_id,
                                    first_name
                                    , last_name
                                    , image_URL 
                                FROM user 
                                WHERE user_id 
                                    IN (
                                        SELECT 
                                            * 
                                        FROM messaged_friends
                                    );",$data);
        return $result;
    }

    public function loadSpecificDM($userID, $dmPartnerID){
        //Query searches for all messages between current user and user with ID passed as $dmPartnerID
        $data =  array(":myID" => $userID, ":theirID" => $dmPartnerID);
        $result = $this->db->exec("SELECT * FROM message WHERE (user_1 = :myID AND user_2 = :theirID) OR (user_1 = :theirID AND user_2 = :myID)", $data);
        return $result;
    }

    public function sendSpecificDM($userID, $dmPartnerID, $messageContent){
        /**
         * Query attempts to insert message with user id, partner id, and message content into 'message' table
         * Return 1 on success, 0 on fail
         **/
            $data = array(":myID" =>$userID, ":theirID"=>$dmPartnerID, ":msgContent"=>$messageContent);
            $result = $this->db->exec("INSERT INTO message (user_1, user_2, msg_content) VALUES(:myID, :theirID, :msgContent)", $data);
            return $result;
    }

}