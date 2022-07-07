<?php

class Posts {
    protected $db;

    public function __construct(DB\SQL $db) {
        // connect model to db
        $this->db = $db;
    }

    public function getNewsfeedPosts($id, $page=0){
        $offset = $page * 25;
        $sql = "SELECT 
                    p.post_id
                    , p.created
                    , p.content
                    , u.first_name
                    , u.last_name 
                    , u.image_URL
                    , u.user_id
                FROM 
                    post p 
                JOIN 
                    user u 
                    ON p.user_id = u.user_id  
                WHERE p.user_id 
                    IN
                        (SELECT 
                            f.user_1
                        FROM 
                            friend f
                        WHERE f.user_2 = :user AND pending = 0
                        UNION
                        SELECT
                            f.user_2
                        FROM
                            friend f
                        WHERE f.user_1 = :user AND pending = 0
                        UNION
                        SELECT :user)
                ORDER BY post_id DESC
                LIMIT 25
                OFFSET :offset";
        $result = $this->db->exec($sql, array(":user"=>$id, ":offset"=>$offset));
        return $result;
    }
    
    public function add($feed_text,$user){
        $data = array(":content"=>$feed_text, ":user"=>$user);
        $result = $this->db->exec('INSERT INTO post (content, user_id) VALUES(:content, :user)', $data);
    
        return $result;
        }
        public function remove($post_id){
            $result = $this->db->exec('DELETE FROM post WHERE post_id = ?', [$post_id]);
        }
}