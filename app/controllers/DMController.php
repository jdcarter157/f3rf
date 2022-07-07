<?php
class DMController extends Controller {


    public function __construct(){
        /**
         * dmController relies on base controller to:
         * -instanciate the $f3 instance
         * -create db connection under $f3->set('db')
         * -Set some form of user ID variable in $f3 as the current user's id
         */
        parent::__construct();

        //Initialize Message and Users model
        $this->messages = new Messages($this->db);
        $this->users = new Users($this->db);
    }


    public function drawDMList(): void
    {
        $this->f3->set('title', 'Direct Messages');
        //Call Users model to query all dm's user has
        $msg = $this->messages->loadDMList($this->f3->get('SESSION.id'));
        $this->f3->set('msg', $msg);

        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('dmlist.htm');
    }

    public function drawSpecificDM(\Base $f3, array $args=[]): void{
        //Pull token from url to store in variable to be passed to users
        $msgRecipient = $args['msgRecipient'];

        //Call Users model to populate name of person you are dm'ing
        $dmRecipient = $this->users->getNameFromID($msgRecipient);
        $this->f3->set('msgWith', $dmRecipient);
        $name = $dmRecipient[0]['first_name'];
        $this->f3->set('title', "Chat with $name");

        //Call Message model to load dm information of the person you are dm'ing
        $msg = $this->messages->loadSpecificDM($this->f3->get('SESSION.id'), $msgRecipient);
        $this->f3->set('msg', $msg);
        
        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('dm.htm');
    }


    public function sendSpecificDM(\Base $f3, array $args=[]){

        //Pull message content from POST information
        $message = $this->f3->get("POST.message");

        //Call Message model to send DM to db and reroute back to dm page
        $dmSent = $this->messages->sendSpecificDM($this->f3->get('SESSION.id'), $args['msgRecipient'], $message);
        $this->f3->reroute($this->f3->get('homepath') . "/dm/".$args['msgRecipient']);
    }




}
