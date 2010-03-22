<?php

// Prepare tweets and auto-detect hyperlinks, hashtags and usernames
function preparetweet($ret) {
  $ret = substr($ret, strpos($ret, ": ")+1);
  $ret = preg_replace_callback('#(?<=[\s>])(\()?([\w]+?://(?:[\w\\x80-\\xff\#$%&~/\-=?@\[\](+]|[.,;:](?![\s<])|(?(1)\)(?![\s<])|\)))+)#is', 'clickable_url', $ret);
  $ret = preg_replace_callback('|(#[a-zA-Z0-9_ŠšŸ€…†§]*)|is', 'clickable_hashtag', $ret);
  $ret = preg_replace_callback('|(@[a-zA-Z0-9_ŠšŸ€…†§]*)|is', 'clickable_username', $ret);
  return trim($ret);   
}

function clickable_hashtag($matches) {
  $origin = trim($matches[0]);
  return '<a target="_blank" class="hashtag" href="http://search.twitter.com/search?q=&tag='.substr($origin, 1).'">'.$origin.'</a>';
}

function clickable_username($matches) {
  $origin = trim($matches[0]);
  return '<a target="_blank" class="username" href="http://twitter.com/'.substr($origin, 1).'">'.$origin.'</a>';
}

function clickable_url($matches) {
  $url = $matches[2];
  if ( empty($url) )
  return $matches[0];
  return $matches[1] . "<a class='link' href=\"$url\">$url</a>";
}

// Turn date to relative string
function reldate($input, $now = false) {
    if (!$now) { $now = time(); }
    $diff = $now - $input;
    if ($diff < 3600) {
        $value = floor($diff / 60);
        $unit = "Minute";
        $unit2 = "Minuten";
    } elseif ($diff < 86400) {
        $value = floor($diff / 3600);
        $unit = "Stunde";
        $unit2 = "Stunden";
    } else {
        $value = floor($diff / 86400);
        $unit = "Tag";
        $unit2 = "Tagen";
    }
    if ($value == 1) {    
        return "vor ".$value." ".$unit;
    } else {
        return "vor ".$value." ".$unit2;
    }
}

?>