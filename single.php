<?php
/**
 * The Template for displaying all single posts
 *
 */

get_header(); 


if(in_category(30)) {
	get_template_part('single-qcity-curious');
} else {
	get_template_part('single-default');
}
?>
