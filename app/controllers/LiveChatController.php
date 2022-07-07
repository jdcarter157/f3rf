<?php

class LiveChatController extends Controller {

    public function __construct(){
        parent::__construct();
        //Model to be used for liveChat db table
        $this->liveChat = new LiveChat($this->db);
    }

    //Initial routing to display chat template
    public function displayChat(){
        $this->f3->set('title', 'Live Chat');
        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('livechat.htm');
        echo $template->render('footer.htm');
    }

    //Function touched by worker ajax request to send messages based on GET values
    public function sendMessage(){
        echo $this->liveChat->sendMessages($this->f3->get("GET.id"), $this->f3->get("GET.msg"));
    }
    
    //Function touched by worker ajax request to get all messages from liveChat db table
    public function getMessage(){
        //Encode and echo get request from model back to the worker
        echo json_encode($this->liveChat->getMessages($this->f3->get("SESSION.id")));
        
    }
}?>