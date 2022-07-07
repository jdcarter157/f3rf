<?php


class Friends
{
    /**
     * handles everything friendship related
     * @class
     * 
     * @constructs Friend
     * @param {db} db connection 
     */

    private $db;

    public function __construct(DB\SQL $db)
    {
        $this->db = $db;
    }

    /**
     * search functionality for both first and last name
     * 
     * @param {string} fName searched users first name
     * @param {string} lName searched users last name
     * 
     * @return {array} array of friends that match the search
     */



    public function searchBoth(string $fName, string $lName): array
    {
        // convert strings to lowercase for checking
        $lowerFirst = strtolower($fName);
        $lowerLast = strtolower($lName);

        // creating paramaters and the SQL query to be executed
        $params = array(":firstName" => $lowerFirst, ":lastName" => $lowerLast);
        $query = "SELECT * FROM user WHERE lower(first_name) like CONCAT('%', :firstName, '%') and lower(last_name) like CONCAT('%', :lastName, '%')";

        return $this->db->exec($query, $params);
    }

    /**
     * search functionality for first name
     * 
     * @param {string} fName searched users first name
     * 
     * @return {array} array of friends that match the search
     */
    public function searchFirstName(string $fName): array
    {
        $lowerFirst = strtolower($fName);

        $query = "SELECT * FROM user WHERE lower(first_name) like CONCAT('%', :fName, '%')";
        $params = array("fName" => $lowerFirst);

        return $this->db->exec($query, $params);


    }

    /**
     * search functionality for last name
     *
     * @param {string} lName searched users last name
     * 
     * @return {array} array of friends that match the search 
     */

    public function searchLastName($lName): array
    {
        $lowerLast = strtolower($lName);

        $query = "SELECT * FROM user WHERE lower(last_name) like CONCAT('%', :lName, '%')";
        $params = array(":lName" => $lowerLast);

        return $this->db->exec($query, $params);


    }



    /**
     * Gets all pending friend requests for the user
     * 
     * @param {string} user The current user
     * 
     */
    public function pending(string $user): array
    {
        $query = "	with friends as (
            select user_2 user_id, 1 as requested from friend where user_1 = :user AND pending = 1
            UNION
            select user_1 user_id, 0 as requested from friend where user_2 = :user AND pending = 1
            )
        select 
              u.user_id
            , u.first_name
            , u.last_name
            , u.image_URL
            , f.requested
                from friends f
                join user u on f.user_id = u.user_id
                WHERE u.user_id <> :user;
        ";
        $params = array(":user" => $user);
        return $this->db->exec($query, $params);
    }
    /**
     * sets a specific friendship to confirmed on the current users side 
     * 
     * @param {string} user The current user
     * @param {string} reqUser user that initialy sent the friend request
     * 
     */
    public function confirm(string $user, string $reqUser): int
    {
        $query = "UPDATE friend SET pending = 0, created=NOW() 
                  WHERE user_2 = :user and user_1 = :reqUser";
        $params = array(":user" => $user, ":reqUser" => $reqUser);
        $result = $this->db->exec($query, $params);
        return $result;
    }



    /**
     * gets all friendships with the current user
     * 
     * @param {string} user The current user
     * 
     */
    public function myFriends(string $user): array
    {
        $params = array(":user" => $user);
        $query = "SELECT first_name, last_name, image_URL, user_id, about FROM user WHERE user_id in (SELECT 
        f.user_1
        FROM 
        friend f
        JOIN
        user u
        ON f.user_1 = u.user_id
        WHERE user_2 = :user AND pending = 0
        UNION
        SELECT
        f.user_2
        FROM
        friend f
        JOIN
        user u
        ON f.user_2 = u.user_id
        WHERE user_1 = :user AND pending = 0
        ORDER BY created)";

        return $this->db->exec($query, $params);
    }


    /**
     * remove a friend from the current users friend list
     * 
     * @param {string} user The current user
     * @param {string} friend The friend of the  user
     * 
     * 
     */

    public function remove(string $user, string $friend): int
    {
        $params = array(":user" => $user, ":friend" => $friend);
        $result = $this->db->exec("DELETE FROM friend 
                        WHERE (user_1 = :user AND user_2 = :friend) 
                        OR (user_1 = :friend AND user_2 = :user)", $params);
        return $result;
    }

    /**
     * add a friend to your pending friend requests
     * 
     * @param {string} user The current user
     * @param {string} friend The friend of the  user
     * 
     * @returns {int} boolean returned
     */

    public function add(string $user, string $friend): int
    {
        $params = array(":user" => $user, ":friend" => $friend);
        $sql = "INSERT INTO friend (user_1, user_2) VALUES (:user, :friend)";
        $result = $this->db->exec($sql, $params);
        return $result;
    }
    /**
     * reject or cancel a friend request
     * 
     * @param {string} user the current signed in user
     * @param{string} friend the friend of the user
     * 
     * @returns {int} boolean returned
     */
    public function reject(string $user, string $friend): int
    {

        $params = array(':user' => $user, ':friend' => $friend);
        $query = "DELETE FROM friend WHERE user_1 = :user AND user_2 = :friend";
        $result = $this->db->exec($query, $params);
        return $result;
    }

    public function friendsSearchBoth(string $fName, string $lName, string $user): array
    {
        // convert strings to lowercase for checking
        $lowerFirst = strtolower($fName);
        $lowerLast = strtolower($lName);

        // creating paramaters and the SQL query to be executed
        $params = array(":firstName" => $lowerFirst, ":lastName" => $lowerLast, ':user' => $user);
        $query = "SELECT * FROM user WHERE lower(first_name) like CONCAT('%', :firstName, '%') and lower(last_name) like CONCAT('%', :lastName, '%') AND user_id IN  (SELECT 
             f.user_1
         FROM 
             friend f
         WHERE f.user_2 = :user AND pending = 0
         UNION
         SELECT
             f.user_2
         FROM
             friend f
         WHERE f.user_1 = :user AND pending = 0)
         ";

        return $this->db->exec($query, $params);
    }


    /**
     * search functionality for first name
     * 
     * @param {string} fName searched users first name
     * @param {string} user the current signed in user
     * 
     * @returns {array} array of friends that match the search
     */
    public function friendsSearchFirst(string $fName, string $user): array
    {
        $lowerFirst = strtolower($fName);

        $query = "SELECT * FROM user WHERE lower(first_name) like CONCAT('%', :fName, '%') AND user_id IN  (SELECT 
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
        )";
        $params = array("fName" => $lowerFirst, ':user' => $user);

        return $this->db->exec($query, $params);

    }

    /**
     * search functionality for last name
     * 
     * @param {string} lName searched users first name
     * @param {string} user the current signed in user
     * 
     * @returns {array} array of friends that match the search
     */
    public function friendsSearchLast(string $lName, string $user): array
    {
        $lowerLast = strtolower($lName);

        $query = "SELECT * 
                    FROM user 
                    WHERE lower(last_name) LIKE CONCAT('%', :lName, '%') 
                        AND user_id IN 
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
                                )";
        $params = array(":lName" => $lowerLast, ':user' => $user);

        return $this->db->exec($query, $params);
    }
}
?>