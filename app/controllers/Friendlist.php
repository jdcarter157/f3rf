<?php


class Friendlist extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->friends = new Friends($this->db);
    }

    public function friend(): void
    {
        $user = $this->f3->get("SESSION.id");
        // get list of friends from user
        $this->f3->set('result',$this->friends->myFriends($user));
        $this->f3->set('title', "Your Friends");
        $template = new Template;
        echo $template->render('header.htm');
        echo $template->render('navbar.htm');
        echo $template->render('friendlist.htm');
    }

    public function remove_friendship():void
    {

        $rmvFriend= $this->f3->get('POST.remove_friend');
        $user = $this->f3["SESSION.id"];
        // remove user from db
        $this->friends->remove($user, $rmvFriend);

        $this->f3->reroute("/friendlist");
    }


}