<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (eregi("config.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 
global $bgcolor1,$bgcolor2,$bgcolor3;
// Titre personalisé de la Faqs
$faqs_title = "";

// Description de la Faqs
$faqs_desc = "";

// Classement des Questions (id | questions)
$faqs_orderby = "id";

function couper_texte_propre($text, $length, $ending = '...', $exact = false) {
    if(strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
        return $text;
    }
    preg_match_all('/(<.+?>)?([^<>]*)/is', $text, $matches, PREG_SET_ORDER);
    $total_length = 0;
    $arr_elements = array();
    $truncate = '';
    foreach($matches as $element) {
        if(!empty($element[1])) {
            if(preg_match('/^<\s*.+?\/\s*>$/s', $element[1])) {
            } else if(preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $element[1], $element2)) {
                $pos = array_search($element2[1], $arr_elements);
                if($pos !== false) {
                    unset($arr_elements[$pos]);
                }
            } else if(preg_match('/^<\s*([^\s>!]+).*?>$/s', $element[1], $element2)) {
                array_unshift($arr_elements,
                strtolower($element2[1]));
            }
            $truncate .= $element[1];
        }
        $content_length = strlen(preg_replace('/(&[a-z]{1,6};|&#[0-9]+;)/i', ' ', $element[2]));
        if($total_length >= $length) {
            break;
        } elseif ($total_length+$content_length > $length) {
            $left = $total_length>$length?$total_length-$length:$length-$total_length;
            $entities_length = 0;
            if(preg_match_all('/&[a-z]{1,6};|&#[0-9]+;/i', $element[2], $element3, PREG_OFFSET_CAPTURE)) {
                foreach($element3[0] as $entity) {
                    if($entity[1]+1-$entities_length <= $left) {
                        $left--;
                        $entities_length += strlen($entity[0]);
                    } else break;
                }
            }
            $truncate .= substr($element[2], 0, $left+$entities_length);
            break;
        } else {
            $truncate .= $element[2];
            $total_length += $content_length;
        }
    }
    if(!$exact) {
        $spacepos = strrpos($truncate, ' ');
        if(isset($spacepos)) {
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;
    foreach($arr_elements as $element) {
        $truncate .= '</' . $element . '>';
    }
    return $truncate;
} 
?>
<link href='http://fonts.googleapis.com/css?family=Sofadi+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
<style>
.containernono{
  /*
  background: rgba(255,255,255,0.8);
  margin:75px auto;
  padding: 35px;
  */
}
.last-h5{
   border-bottom:1px solid #555;
}
/* Frequently Asked Questions*/
.header-h5 {
    width: 100%;
    margin: 0;
    padding: 15px;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    cursor:pointer;
    border-top:1px solid #555;
    border-left:1px solid #555;
    border-right:1px solid #555;
    background: <?php echo $bgcolor2; ?>;
    
}

.img {
    display: inline-block;
    margin-right: 10px;
    vertical-align: middle;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 20px;
}

.question-Q {
    display: inline-block;
    vertical-align: middle;
    font-size: 15px;
    font-weight: bold;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    margin-right: 7px;
}

.answer-A {
    font-size: 22px;
    vertical-align: middle;
    margin-right: 7px;
}

.question {
    vertical-align: middle;
    font-family: 'Shadows Into Light', cursive;
    font-size: 14px;
    font-weight: normal;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    display: inline-table;

}

.faq-p 
{
    margin:0 auto;
    display: block;
    width: 100%;
    padding: 15px;
    border-top: 1px solid #555;
    border-left: 1px solid #555;
    border-right: 1px solid #555;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    background: <?php echo $bgcolor1; ?>;
    font-size: 15px;
    font-weight: normal;
    /*color: #FFF;*/
}
.faq-p a{
	text-decoration: none; border-bottom: 1px dotted;
	cursor: url("modules/Faqs/images/lien_externe.png"), pointer;
}
.last-faq-p {
  border-top: none;
  -webkit-border-bottom-right-radius: 15px;
  -webkit-border-bottom-left-radius: 15px;
  -moz-border-radius-bottomright: 15px;
  -moz-border-radius-bottomleft: 15px;
  border-bottom-right-radius: 15px;
  border-bottom-left-radius: 15px;
  border-bottom:1px solid #555;
}

/**
 * HINT- A CSS tooltip library
 */

.hint { position: relative; display: inline-block; }

.hint:before, .hint:after {
			position: absolute;
			opacity: 0;
			z-index: 1000000;
			-webkit-transition: 0.3s ease;
			-moz-transition: 0.3s ease;
  pointer-events: none;
}

		
.hint:hover:before, .hint:hover:after {
	opacity: 1;
}

.hint:before {
	content: '';
	position: absolute;
	background: transparent;
	border: 6px solid transparent;
	position: absolute;

}
		
.hint:after {
	content: attr(data-hint);
	background: rgba(0, 0, 0, 0.8);
			color: white;
			padding: 8px 10px;
			font-size: 12px;
	white-space: nowrap;
	box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
}


/* top */

.hint--top:before {
	bottom: 100%;
	left: 50%;
	margin: 0 0 -18px 0;
	border-top-color: rgba(0, 0, 0, 0.8);
}
		
.hint--top:after {
	bottom: 100%;
	left: 50%;
	margin: 0 0 -6px -10px;
}

.hint--top:hover:before {
	margin-bottom: -10px;
}

.hint--top:hover:after {
	margin-bottom: 2px;
}

/* default: bottom */

.hint--bottom:before {
	top: 100%;
	left: 50%;
	margin: -14px 0 0 0;
	border-bottom-color: rgba(0, 0, 0, 0.8);
}
		
.hint--bottom:after {
	top: 100%;
	left: 50%;
	margin: -2px 0 0 -10px;
}

.hint--bottom:hover:before {
	margin-top: -6px;
}

.hint--bottom:hover:after {
	margin-top: 6px;
}

/* right */

.hint--right:before {
	left: 100%;
	bottom: 50%;
	margin: 0 0 -4px -8px;
	border-right-color: rgba(0,0,0,0.8);
}
		
.hint--right:after {
	left: 100%;
	bottom: 50%;
	margin: 0 0 -13px 4px;
}

.hint--right:hover:before {
	margin: 0 0 -4px -0;
}

.hint--right:hover:after {
	margin: 0 0 -13px 12px;
}

/* left */

.hint--left:before {
	right: 100%;
	bottom: 50%;
	margin: 0 -8px -4px 0;
	border-left-color: rgba(0,0,0,0.8);
}
		
.hint--left:after {
	right: 100%;
	bottom: 50%;
	margin: 0 4px -13px 0;
}

.hint--left:hover:before {
	margin: 0 0 -4px 0;
}

.hint--left:hover:after {
	margin: 0 12px -13px 0;
}
</style>