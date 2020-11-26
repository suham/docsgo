<?php

    function setPrevUrl($name, $vars){
        $session = session();
        if(isset($_SESSION['PREV_URL'])){
            $session->remove('PREV_URL');
        }

        $PREV_URL = [
            'name'  => $name,
            'vars'  => $vars
        ];

        $session->set('PREV_URL', $PREV_URL );
    }

?>