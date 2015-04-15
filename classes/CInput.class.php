<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class  CInput
{
	function CInput()
	{
	}
	function get( $varname , $type = ''  , $vartext = '' , $method = '')
	{
		global $HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_COOKIE_VARS,$_REQUEST;	
		$value = "";
		
		if ( !empty( $_POST[ $varname ] ) )
		{
			$value	= 	$_POST[ $varname ];
		}
		else if (!empty($_GET[ $varname ]))
		{
			$value 	= 	$_GET[ $varname ];
		}
		else if(!empty($_REQUEST[ $varname ] ))
		{
			$value	=	$_REQUEST[ $varname ];
		}
		else if(!empty($_FILES[ $varname ] ))
		{
			$value	=	$_FILES[ $varname ];
		}
		if(!$value)	$value	=	$vartext;
		$value = @trim($value);
		switch ( $type )
		{
			case 'txt':
				$value = CInput::def( $value );
			break;
            case 'con':
				$value = CInput::content( $value );
			break;
			case 'int':					
				$value = CInput::cint( $value );
			break;
			case 'sql':
				$value = CInput::csql( $value );
			break;
			case 'big':
				$value = CInput::cbigint( $value );
			break;
			case 'dte':
				$value = CInput::cdate( $value );
			break;
			default:
				$value = CInput::cstr( $value );
		}
		return $value;
	}
	function cstr( $strval )
	{
		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
		if(strlen($strval))
			$strval = htmlspecialchars($strval);
            $strval = str_replace("script","",$strval);
		return $strval;
	}
	function cdate( $strval )
	{
		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
		if(strlen($strval))
			$strval = htmlspecialchars($strval);
		return date("Y-m-d", strtotime($strval));
	}
	function def( $strval )
	{
		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
		$strval = htmlspecialchars($strval);
        //$strval = str_replace("script","",$strval);
		return $strval;
	}
    
    function content($strval){
        return $strval;
    }
    
	function csql( $strval )
	{
		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
		return $strval;
	}
	function cint( $intval )
	{
		if ( get_magic_quotes_gpc() == 0 ) $intval = addslashes($intval);
		$intval = (int) $intval;
		return $intval;
	}
	function cbigint( $intval )
	{
		$intval = str_replace(",","", $intval);
		if(is_numeric(trim($intval)))
			return $intval;
		return 0;
	}
}
?>