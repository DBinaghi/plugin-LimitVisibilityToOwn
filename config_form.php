<?php $view = get_view(); ?>

<div class="field">
	<div class="two columns alpha">
		<label><?php echo __('Limit to own Items')?></label>	
	</div>
	<div class="inputs five columns omega">
		<p class="explanation"><?php echo __("Check the roles that will be able to see only their own Items (in Admin mode). <br>N.B.: by default, Super User's role is not available for limitation."); ?></p>
		<div class="input-block">		
			<?php
				if (get_option('limit_visibility_to_own_items_roles') <> '') {
					$limitedRoles = unserialize(get_option('limit_visibility_to_own_items_roles'));
				} else {
					$limitedRoles = array();
				}
				$userRoles = get_user_roles();
				unset($userRoles['super']);
				
				echo '<ul style="list-style-type:none">';
				foreach($userRoles as $role=>$label) {
					echo '<li>';
					echo $view->formCheckbox('limit_visibility_to_own_items_roles[]', $role,
						array('checked'=> (count($limitedRoles) > 0 ? in_array($role, $limitedRoles) : false) ? 'checked' : '')
					);		  
					echo ' ' . __($label);
					echo '</li>';
				}   
				echo '</ul>';
			?>
		</div>
	</div>
</div>

<div class="field">
	<div class="two columns alpha">
		<label><?php echo __('Limit to own Collections')?></label>	
	</div>
	<div class="inputs five columns omega">
		<p class="explanation"><?php echo __("Check the roles that will be able to see only their own Collections (in Admin mode). <br>N.B.: by default, Super User's role is not available for limitation."); ?></p>
		<div class="input-block">		
			<?php 
				if (get_option('limit_visibility_to_own_collections_roles') <> '') {
					$limitedRoles = unserialize(get_option('limit_visibility_to_own_collections_roles'));
				} else {
					$limitedRoles = array();
				}
				$userRoles = get_user_roles();
				unset($userRoles['super']);
				
				echo '<ul style="list-style-type:none">';
				foreach($userRoles as $role=>$label) {
					echo '<li>';
					echo $view->formCheckbox('limit_visibility_to_own_collections_roles[]', $role,
						array('checked'=> (count($limitedRoles) > 0 ? in_array($role, $limitedRoles) : false) ? 'checked' : '')
					);		  
					echo ' ' . __($label);
					echo '</li>';
				}   
				echo '</ul>';
			?>
		</div>
	</div>
</div>
