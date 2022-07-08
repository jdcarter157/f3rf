<?php

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->users = new Users($this->db);
        $this->posts = new Posts($this->db);
    }
    function index()
    {
        // primary landing page
        // set variables
        $this->f3->set('title', "Welcome to Shrine");

        // serve content
        $template = new Template;
        
        echo $template->render('header.htm');
        if ($this->f3->get('SESSION.id')) {
            echo $template->render('navbar.htm');
        }
        echo $template->render('landing.htm');
    }

    function login()
    {
        // login page
        // set variables
        $this->f3->set('title', "Login");
        // serve content
        $template = new Template;
        echo $template->render('header.htm');
        if ($this->f3->get('SESSION.id')) {
            echo $template->render('navbar.htm');
        }
        echo $template->render('login.htm');
    }

    function validateLogin()
    {
        // process POSTed login form
        if (isset($_POST['email']) && isset($_POST['password'])) {
            // gather form data
            $useremail = $_POST['email'];
            $userpassword = $_POST['password'];
            // get data from model
            $results = $this->users->getUserByEmail($useremail);
            // check to see if results came in
            if (isset($results[0])) {
                // check password against hash
                if (password_verify($userpassword, $results[0]['password'])) {
                    // success, initiate session and redirect
                    $this->f3->set("SESSION.id", $results[0]['user_id']);
                    header("Location: newsfeed");
                }
                else {
                    // bad password
                    $this->f3->reroute($this->f3->get('homepath') . '/login?password=invalid');
                }
            }
            else {
                // email not found
                $this->f3->reroute($this->f3->get('homepath') . '/login?email=invalid');
            }
        }
    }
    function newsfeed()
    {
        $this->f3->set('title', 'Your Newsfeed');
        // get user ID
        $user = $this->f3->get('SESSION.id');
        // get posts for user
        $posts = $this->posts->getNewsfeedPosts($user);
        // set results to f3
        $this->f3->set('result', $posts);
        // create and deliver template
        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('newsfeed.htm');
    }
    function addPost(){
        // get user ID
        $user = $this->f3->get('SESSION.id');
        // get text from feed form
        $feed_text= $this->f3->get('POST.feed');
        // call add function from model
        $this->posts->add($feed_text, $user);
        //reload newsfeed page with updated post 
        $this->f3->reroute('/newsfeed');
    }
    function removePost(\Base $f3, array $args=[]){ 
        $this->posts->remove($args['postID']);
        $f3->reroute('/newsfeed');
        
     }
     function editPost(\Base $f3, array $args=[]){ 
        $edit_text= $this->f3->get('POST.edit');
        $this->posts->edit($edit_text,$args['editID']);
        $f3->reroute('/newsfeed');

        
     }
    function logout() {
        // clear user session, return to root
        $this->f3->clear('SESSION.id');
        unset($_SESSION);
        $this->f3->reroute('/');
    }
    function register()
    {
        $this->f3->set('title', 'Register with Shrine');
        // registration page
        $template = new Template;
        echo $template->render('header.htm');
        // if logged in, get navbar
        if ($this->f3->get('SESSION.id')) {
            echo $template->render('navbar.htm');
        }
        echo $template->render('register.htm');
    }

    function registration()
    {
        // process registration form
        // get form data
        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');
        $vpassword = $this->f3->get('POST.vpassword');
        $firstName = $this->f3->get('POST.firstname');
        $lastName = $this->f3->get('POST.lastname');
        $birthday = $this->f3->get('POST.bday');
        $aboutMe = $this->f3->get('POST.aboutme');
        $url = $this->f3->get('POST.url');

        // check if email is available
        $result = $this->users->checkEmail($email);
        if ($result) {
            // check that passwords match
            if ($password = $vpassword) {
                // hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // organize data into array
                $formData = array(
                    ':email'=>$email,
                    ':password'=>$hashedPassword,
                    ':first_name'=>$firstName,
                    ':last_name'=>$lastName,
                    ':birthday'=>$birthday,
                    ':aboutme'=>$aboutMe,
                    ':url'=>$url
                );
                // insert array into db
                $result = $this->users->createNew($formData);
                if ($result) {
                    // on success, reroute to login
                    $this->f3->reroute($this->f3->get('homepath') . '/login');
                } else {
                    // on error send back to registration
                    $this->f3->reroute($this->f3->get('homepath') . '/register?error=unknown');
                }
            }
        }
        else {
            // email unavailable, return to registration
            $this->f3->reroute($this->f3->get('homepath') . '/register?email=unavailable');
        }
    }
}
