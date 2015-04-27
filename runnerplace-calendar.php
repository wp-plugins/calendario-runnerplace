<?php
 
/*
Plugin Name: RunnerPlace Calendar Plugin
Plugin URI: http://www.runnerplace.com/
Description: Todo el calendario de carreras populares en tu web.
Version: 1.1.2
Author: RunnerPlace
Author URI: http://www.runnerplace.com/
License: A short license name. Example: GPL2

*/

/*  Copyright 2015 RUNNERPLACE (email : info@runnerplace.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* Función que instancia el Widget
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function RPRC_create_widget(){    
    include_once(plugin_dir_path( __FILE__ ).'/includes/widget.php');
    register_widget('RPRC_widget');
}
add_action('widgets_init','RPRC_create_widget');
 
?>
