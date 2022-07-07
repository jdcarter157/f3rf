<?php
class Profile extends Controller
{
    public function __construct(){
        /**
         * dmController relies on base controller to:
         * -instanciate the $this->f3 instance
         * -create db connection under $this->f3->set('db')
         * -Set some form of user ID variable in $this->f3 as the current user's id
         */
        parent::__construct();

        //Initialize Message and Users model
        $this->users = new Users($this->db);
    }
    //Beginning of user profile
    public function profile(): void
    {
        //Current users profile
        $user = $this->f3->get('SESSION.id');
        $info = $this->users->getUserById($user);

        //Generate current users profile
        $this->f3->set('result', $info);
        $template = new Template;
        $this->f3->set('title', 'Your Profile');

        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('profile.htm');
    }
    //End of user profile




    // Beginning of other profile use profile
    public function otherProfile(\Base $f3, array $args = [])
    {
        //other users info
        $info = $this->users->getUserById($args['other_id']);
        $this->f3->set('title', $this->f3->get('result')[0]["first_name"] . '\'s Profile');

        $this->f3->set('result', $info);

        //generate viewed users profile
        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('profile.htm');
    }
    //End of other user profile
}

