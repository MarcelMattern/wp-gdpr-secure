<?php
/*
Plugin Name: DSGVO/GDPR Secure
Plugin URI: https://www.coffee-code.de
Description: Silence
Author: Marcel Mattern
Author URI: https://www.coffee-code.de
Version: 0.1
*/

//if ( ! defined( 'ABSPATH' ) ) exit;


function gdpr_scripts()
{
    wp_register_script( 'gdpr-dsgvo-secure', plugins_url( '/dsgvo-gdpr-secure/assets/js/script.min.js' ), array( 'jquery' ), '', true);
    wp_enqueue_script( 'gdpr-dsgvo-secure');
}
add_action( 'wp_enqueue_scripts', 'gdpr_scripts' );