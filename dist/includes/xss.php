<?php
$UNSAFE_HTML[] = "/\</";
$UNSAFE_HTML[] = "/\>/";
$UNSAFE_HTML[] = "/(?i)javascript/";
$UNSAFE_HTML[] = "/(?i)embed.*swf/";
$UNSAFE_HTML[] = "/(?i)vbscri/";
$UNSAFE_HTML[] = "/(?i)onblur/";
$UNSAFE_HTML[] = "/(?i)onabort/";
$UNSAFE_HTML[] = "/(?i)string/";
$UNSAFE_HTML[] = "/(?i)alert/";
$UNSAFE_HTML[] = "/(?i)fromCharCode/";
$UNSAFE_HTML[] = "/(?i)onchange/";
$UNSAFE_HTML[] = "/(?i)onclick/";
$UNSAFE_HTML[] = "/(?i)onerror/";
$UNSAFE_HTML[] = "/(?i)onsubmit/";
$UNSAFE_HTML[] = "/(?i)onreset/";
$UNSAFE_HTML[] = "/(?i)onload/";
$UNSAFE_HTML[] = "/(?i)onchange/";
$UNSAFE_HTML[] = "/(?i)onfocus/";
$UNSAFE_HTML[] = "/(?i)onmouseover/";
$UNSAFE_HTML[] = "/(?i)onmouseout/";
$UNSAFE_HTML[] = "/(?i)script/";
$UNSAFE_HTML[] = "/(?i).js/";

function replace_unsafe_html($input) {
    global $UNSAFE_HTML;

    if (! is_array($input)) {
        foreach ( $UNSAFE_HTML as $match ) {
            $input=preg_replace($match,'',$input );
        }
    } else {
        foreach($input as $key => $value) {
            $input[$key] = replace_unsafe_html($value);
        }
    }
    return $input;
}


foreach ($_GET as $key => $value){
    $_GET[$key] = replace_unsafe_html($value);
}
foreach ($_POST as $key => $value){
    $_POST[$key] = replace_unsafe_html($value);
}
