<?php

    
class Controller {
	protected $f3;
    protected $db;
    
    function beforeroute() {
        if (isset($this->f3['SESSION.id'])) {
        } else {
            if (!in_array($this->f3->get('PATH'), ['/', '/login', '/register']) ) {
                $this->f3->reroute('/');
            }
        }
    }
    function __construct(){
        // grab instance of F3
        $f3 = Base::instance();
        $this->f3 = $f3;
        
        // connect to database
        $db = new DB\SQL(
            $f3->get('db_dns'),
            $f3->get('db_user'),
            $f3->get('db_password'),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
        );

        // link db to controller for easy access
        $this->db = $db;

        // track sessions
        new \DB\SQL\Session($this->db);
        
        // set homepath for easy routing
        $f3->set('homepath', $f3->get('SCHEME') . '://'
         . $f3->get('HOST') . $f3->get('BASE'));
    }
}
