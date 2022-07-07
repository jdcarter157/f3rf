<?php



class PendingRequest extends Controller
{
    /**
     * handles all pending friend requesrs
     */
    

    
    public function __construct(){
        parent::__construct();
        $this->friends = new Friends($this->db);
    }
    public function pendingrequest(): void
    {
        $this->f3->set('title', 'Pending Friend Requests');
        $user = $this->f3->get("SESSION.id");
        $this->f3->set('result', $this->friends->pending($user));
        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('pendingrequest.htm');
    }

    /**
     * This confirms friend
     * 
     * @return void
     */
    public function confirm_friend(): void
    {;
    
        $user = $this->f3->get("SESSION.id");
        $req_user = $this->f3->get('POST.pending_request');
    
        $thing = $this->friends->confirm($user, $req_user);
        $this->f3->reroute("/pendingrequest");


    }

    /**
     * rejecting a incoming friendship request
     * 
     */
    public function reject_friend(): void
    {;


        $user = $this->f3->get("SESSION.id");
        $req_user = $this->f3->get('POST.rejected_request');

        $this->friends->reject($req_user,$user);
        $this->f3->reroute("/pendingrequest");


    }
    /**
     * cancel a friend request that you sent
     */
    public function cancel_request():void
    {
        $user = $this->f3->get("SESSION.id");
        $req_user = $this->f3->get('POST.cancel_request');
        $this->friends->reject($user,$req_user);
        $this->f3->reroute("/pendingrequest");

    }

}