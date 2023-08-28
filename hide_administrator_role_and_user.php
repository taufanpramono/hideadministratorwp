

<!-- hide administrator user from list -->

<style type="text/css">
	
.subsubsub a .count,.subsubsub a.current .count {
	display: none;
}

#user-1 {
	display: none;
}

	
</style>




<?php  

//==========================
// Hide Administrator Role 
// Drop Down or selected Role
//===========================

// Enqueue jQuery
add_action('admin_enqueue_scripts' , 'ft_hide_administrator_jquery' );
function ft_hide_administrator_jquery(){
	global $pagenow;
	if ( 'users.php' == $pagenow ){
		wp_enqueue_script('jquery');
	}
}

// menghilangkan administrator dari dropdown
function hide_administrator_role_option($user_roles) {
    if (isset($user_roles['administrator']) && current_user_can('administrator')) {
        unset($user_roles['administrator']);
    }
    return $user_roles;
}
add_filter('editable_roles', 'hide_administrator_role_option');


//menghilangkan dari tab menu
add_action('admin_head' , 'ft_hide_administrator_user');
function ft_hide_administrator_user(){
	if ( !current_user_can('activate_plugins') ){
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			var admin_count = 0;
			var total_count = 0;

			$("ul.subsubsub li a:contains('Administrator')").each(function(){
				admin_count = parseInt($(this).find('.count').text().replace(/\D/g,''));
			});
			$("ul.subsubsub li a:contains('Administrator')").parent().remove();
			$("ul.subsubsub li a:contains('All')").each(function(){
				total_count = parseInt($(this).find('.count').text().replace(/\D/g,'')) - admin_count;
				$(this).find('.count').text('('+total_count+')');
			});
			$("#users tr .administrator").closest('tr').remove();
		});
		</script>
		<?php
	}
}

//menghilangkan nama admin dari pemilihan author
add_filter('wp_dropdown_users_args', 'exclude_admin_authors');

function exclude_admin_authors($args) {
    $args['role__not_in'] = 'administrator'; // Mengecualikan penulis dengan peran "administrator"
    return $args;
}




?>
