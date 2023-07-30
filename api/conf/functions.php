<?php
function debugTerminal($element){
    ob_start();
    print_r($element);
    $output = ob_get_clean();
    error_log($output);
}

