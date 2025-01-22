<?php


    Class database extends mysqli{
        public function __construct()
        {
            parent::__construct('localhost', 'root', '123456', 'movie_database', 3316);
            $this->set_charset('utf8');
            $this->connect_error == NULL ? 'Coonnection granted with the database' : die('Connetion severed with the database');
        }
    }