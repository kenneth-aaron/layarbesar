<?php
/**
 * Custom functions for bbpress
 *
 * @package Muvipro
 */
 
// Remove BBP breadcrumb
add_filter( 'bbp_no_breadcrumb', '__return_true' );