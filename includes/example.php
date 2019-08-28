<?php
namespace ITBL\Example;
/**
 * This is an example template with comments on what do do
 *
 * @return void
 */
 
 function setup(){
     $n = function( $function ){
        return __NAMESPACE__ . '\\' . $function;
     };
     
     //add the hooks and filters here
     //add_action( "", "" );
 }