<?php
namespace Redlof\Engine\Seeds;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Models\Permission;
use Models\PermissionRole;

class PermissionTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		DB::table(config('entrust.permissions_table'))->truncate();
		DB::table(config('entrust.permission_role_table'))->truncate();

		$permission_model = config('entrust.permissions_table');
		$viewBackend = new $permission_model;
		$viewBackend->name = 'view_backend';
		$viewBackend->display_name = 'View Backend';
		$viewBackend->system = true;
		$viewBackend->created_at = Carbon::now();
		$viewBackend->updated_at = Carbon::now();
		$viewBackend->save();

		//Find the first role (admin) give it all permissions
		$role_model = config('access.role');
		$role_model = new $role_model;
		$admin = $role_model::first();
		$admin->permissions()->sync(
			[
				$viewBackend->id,
			]
		);

		$permission_model = config('entrust.permission');
		$userOnlyPermission = new $permission_model;
		$userOnlyPermission->name = 'user_only_permission';
		$userOnlyPermission->display_name = 'Test User Only Permission';
		$userOnlyPermission->system = false;
		$userOnlyPermission->created_at = Carbon::now();
		$userOnlyPermission->updated_at = Carbon::now();
		$userOnlyPermission->save();

		$user_model = config('auth.model');
		$user_model = new $user_model;
		$user = $user_model::find(2);
		$user->permissions()->sync(
			[
				$userOnlyPermission->id,
			]
		);

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}