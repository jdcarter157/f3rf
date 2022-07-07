<?php



class FriendSearch extends Controller
{
    /**
     * Search for friends
     * 
     * @param {base} f3 fat free framework variable
     * 
     */
    public function __construct(){
        parent::__construct();
        $this->friends = new Friends($this->db);
    }

    public function add(): void
    {
        $friend = $_POST['friend_id'];
        $user = $this->f3->get('SESSION.id');
        $result = $this->friends->add($user, $friend);
        if ($result) {
            $this->f3->reroute($this->f3->get('homepath') . '/friendsearch');
        }
    }

    /**
     * search functionality for both first and last name in your friends list
     * 
     * @param {string} fName searched users first name
     * @param {string} lName searched users last name
     * @param {string} user the current signed in user
     * 
     * @returns {array} array of friends that match the search
     */

    public function search(): void
    {
        // first/lastname input fields
        $firstName = $this->f3->get('GET.search_first_name');
        $lastName = $this->f3->get('GET.search_last_name');          
        /**
         * beter way to check is to count the number of lettr in the string to ensure that there is someting in the search bar
         * 
         * Checks what information the user enters and determins what query to execute 
         * 
         */

        if (strlen($firstName) > 0  && strlen($lastName) > 0) {
            // gets all users thats first and last names contains the info the user enters
            // var_dump($friend->searchBoth($firstName,$lastName));
           $this->f3->set('result',$this->friends->searchBoth($firstName,$lastName));
        } else if (strlen($firstName) > 0) {
            // gets all users thats first names contains the info the user enters
            $this->f3->set('result', $this->friends->searchFirstName($firstName));
        } else if(strlen($lastName) > 0){
            // gets all users thats last names contains the info the user enters
            $this->f3->set('result', $this->friends->searchLastName($lastName));
        }
        $this->f3->set('title', "Search for Friends");
        $template = new Template; 
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('friendsearch.htm');
    }
    public function searchFriendslist():void
    {
        $firstName = $this->f3->get('GET.search_first_name');
        $lastName = $this->f3->get('GET.search_last_name');      
        $user = $this->f3->get('SESSION.id');    

        $this->f3->set('title', "My Friends");
        if (strlen($firstName) > 0  && strlen($lastName) > 0) {
            // gets all users thats first and last names contains the info the user enters
            // var_dump($friend->searchBoth($firstName,$lastName));
           $this->f3->set('result',$this->friends->friendsSearchBoth($firstName,$lastName,$user));
        } else if (strlen($firstName) > 0) {
            // gets all users thats first names contains the info the user enters
            $this->f3->set('result', $this->friends->friendsSearchFirst($firstName,$user));
        } else if(strlen($lastName) > 0){
            // gets all users thats last names contains the info the user enters
            $this->f3->set('result', $this->friends->friendsSearchLast($lastName,$user));
        }
        $template = new Template; 
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('friendlist.htm');
    }
}

  
?>
