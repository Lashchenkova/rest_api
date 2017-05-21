<?php


class API
{
    private $method;
    private $request;
    private $id;
    private $action;
    private $name;

    public function __construct($method, $uri)
    {
        $this->method = $method;
        $parts = parse_url($uri);
        $path = trim( $parts['path'], '/' );//delete slashs

        $request = explode('/', $path);
        $this->request = array_filter($request);//delete empty elements
    }

    public function validate()
    {
        if( !empty($this->request ) //check if request not empty and = /users
            && $this->request[0] === 'api'
            && count($this->request) > 1
            && $this->request[1] === 'users')
        {
            array_shift($this->request);//delete "api" in uri
        }else{
            header( 'Bad Request', true, 400 );
            exit();
        }

        if ( count($this->request) > 1 ) {

            if ( count($this->request) === 2
                && is_numeric($this->request[1]) ) //validate numeric user_id
            {
                $this->id = $this->request[1];
            } elseif ( count($this->request) === 3 //for users/search/JohnDoe
                && $this->request[1] === "search"
                && !is_numeric($this->request[2]) )
            {
                $this->action = $this->request[1];//action - search
                $this->name = $this->request[2];//name - name from db_table_users
            } else {
                header( 'Not found', true, 404 );
                exit();
            }

        }
    }

    public function rest()
    {
        $this->validate();

        switch (TRUE) {
            case ( $this->method === 'GET' && !$this->id ):
                Users::find($this->name);
                break;
            case ( $this->method === 'PUT' && $this->id ):
                Users::update($this->id);
                break;
            case ( $this->method === 'POST' && count($this->request) === 1 ):
                Users::add();
                break;
            case ( $this->method === 'DELETE' && $this->id ):
                Users::delete($this->id);
                break;
            default:
                header( 'Bad Request', true, 400 );
                exit();
        }
    }
}