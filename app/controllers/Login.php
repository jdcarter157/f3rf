<?php
class Login extends Controller{
    public function login(\Base $f3, array $args=[]):void {
        // get POST variables
        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');
        
        $users = new Users($this->db);
        $result = $users->getUserByEmail($email);

        $success = password_verify($password, $result[0]['password']);
        
        if ($success) {
            // on success set session id and reroute to newsfeed
            $this->f3->set('SESSION.id', $result[0]['user_id']);
            $this->f3->reroute('/newsfeed');
        } else {
            // return to login on error
            $this->f3->reroute('/login.php?invalidlogin=true');

        }
    }
}