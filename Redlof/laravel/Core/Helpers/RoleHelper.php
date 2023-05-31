<?php
namespace Redlof\Core\Helpers;

use Models\Role;
use Models\RoleUser;
use Exceptions\EntityNotFoundException;
use Redlof\Engine\Auth\Repositories\RoleRepo;

/**
 * Role Helper class
 */
class RoleHelper {
	protected $role;
	function __construct(RoleRepo $role) {
		$this->role = $role;
	}

	public static function getRolesForUserSwitch() {
		$Data = array();

		$Data['roles'] = RoleUser::where('user_id', \AuthHelper::getCurrentUser()->id)->with(['role'])->get();

		return $Data;
	}

	public static function getRolebyUserEmail($email) {
		$Data = array();

		$User = \DB::table('users')->where('email', $email)->first();
		if (!$User) {
			throw new EntityNotFoundException("We don't see a user with this credentials.");
		}

		$Role = \DB::table('role_user')->where('user_id', $User->id)->first();

		if (!$Role) {
			throw new EntityNotFoundException("We don't see a user with this credentials.");
		}

		$RoleId = $Role->role_id;

		$Data['role'] = \DB::table('roles')->find($RoleId);
		if (!$Data['role']) {
			throw new EntityNotFoundException("We don't see a user with this credentials.");
		}

		$Data['user'] = $User;
		return $Data;
	}

	/**
	 * Get Role Id by Name
	 */
	public static function getRoleId($rolename) {
		$RoleId = Role::where('name', $rolename)->first();
		return $RoleId->id;
	}

	public static function getRoleObj($name) {
		return \DB::table('roles')->where('name', $name)->first();
	}

	public static function getRoleName($role_id, $format = false) {
		// Get Auth user role
		$RoleName = Role::find($role_id)->name;

		if ($format == true) {
			$FormattedRoleName = ucwords($RoleName);
			return $FormattedRoleName;
		}

		return $RoleName;
	}

	public static function getRolebyUserId($id) {
		$RoleId = \DB::table('role_user')->where('user_id', $id)->first()->role_id;
		return \DB::table('roles')->find($RoleId);
	}

	public static function getAllRoles() {
		// call the getalllist from base repo
		// We have used model instead of repo coz this class has static function so we won't be able to use this here
		$roles = Role::get();
		return $roles;
	}
}