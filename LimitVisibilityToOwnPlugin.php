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
		set_option('limit_visibility_to_own_items_roles', '0');
		set_option('limit_visibility_to_own_collections_roles', '0');
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
		set_option('limit_visibility_to_own_items_roles',		serialize($post['limit_visibility_to_own_items_roles']));
		set_option('limit_visibility_to_own_collections_roles',	serialize($post['limit_visibility_to_own_collections_roles']));
	}
	
	public function hookConfigForm()
	{
		include 'config_form.php';
	}

	public function filterItemsBrowseParams($params)
	{
		$user = current_user();
		$limitedRoles = unserialize(get_option('limit_visibility_to_own_items_roles'));
		if ($user && count($limitedRoles) > 0 && in_array($user->role, $limitedRoles)) {
			$params['user'] = $user->id;
		}
		return $params;
	}

	public function filterCollectionsBrowseParams($params)
	{
		$user = current_user();
		$limitedRoles = unserialize(get_option('limit_visibility_to_own_collections_roles'));
		if ($user && count($limitedRoles) > 0 && in_array($user->role, $limitedRoles)) {
			$params['user'] = $user->id;
		}
		return $params;
	}
}
