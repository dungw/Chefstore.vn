<?php

/**
 * @author duchanh
 * @copyright 2012
 */

include ("config.php");

class form
{

    function form()
    {
        $cmd = CInput::get('cmd', 'txt', '');
        switch ($cmd)
        {
            case "contact":
                $this->contact();
                break;
            
            default:
                //nothing to do
            break
           


        }
    }

}


new form();
