<?php
class LimitVisibilityToOwnPlugin extends Omeka_Plugin_AbstractPlugin
{

	protected $_hooks = array(
		'install',
		'uninstall',
		'initialize',
		'config',
		'config_form'
	);

	protected $_filters = array(
		'items_browse_params',
		'collections_browse_params'
	);

	public function hookInstall()
	{
		set_option('limit_visibility_to_own_items_roles', '');
		set_option('limit_visibility_to_own_collections_roles', '');
	}

	public function hookUninstall()
	{
		delete_option('limit_visibility_to_own_items_roles');
		delete_option('limit_visibility_to_own_collections_roles');
	}
	
	public function hookInitialize()
	{
		add_translation_source(dirname(__FILE__) . '/languages');
	}

	public function hookConfig($args)
	{
		$post = $args['post'];
		set_option('limit_visibility_to_own_items_roles',		(isset($post['limit_visibility_to_own_items_roles']) ? serialize($post['limit_visibility_to_own_items_roles']) : ''));
		set_option('limit_visibility_to_own_collections_roles',	(isset($post['limit_visibility_to_own_items_roles']) ? serialize($post['limit_visibility_to_own_collections_roles']) : ''));
	}
	
	public function hookConfigForm()
	{
		include 'config_form.php';
	}

	public function filterItemsBrowseParams($params)
	{
		if (!is_admin_theme()) return $params;
		
		$user = current_user();
		if (get_option('limit_visibility_to_own_items_roles') <> '') {
			$limitedRoles = unserialize(get_option('limit_visibility_to_own_items_roles'));
			if ($user && count($limitedRoles) > 0 && in_array($user->role, $limitedRoles)) {
				$params['user'] = $user->id;
			}
		}
		return $params;
	}

	public function filterCollectionsBrowseParams($params)
	{
		if (!is_admin_theme()) return $params;
		
		$user = current_user();
		if (get_option('limit_visibility_to_own_collections_roles') <> '') {
			$limitedRoles = unserialize(get_option('limit_visibility_to_own_collections_roles'));
			if ($user && count($limitedRoles) > 0 && in_array($user->role, $limitedRoles)) {
				$params['user'] = $user->id;
			}
		}
		return $params;
	}
}
