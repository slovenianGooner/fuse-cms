<?php

namespace App\Console\Commands;

use App\Enum\Permission;
use App\Enum\Role;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;

class SyncFusePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fuse:sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command syncs all roles and their permissions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->syncPermissionsFromEnum();
        $this->syncRolesFromEnum();

        foreach (config('fuse.permissions') as $role => $permissions) {
            if ($permissions === '*') {
                $this->assignPermissions(Role::tryFrom($role), [...Permission::cases()]);
            } else if (is_array($permissions)) {
                $this->assignPermissions(Role::tryFrom($role), $permissions);
            }
        }
    }

    private function syncPermissionsFromEnum(): void
    {
        $enums = [...Permission::cases()];

        foreach ($enums as $enum) {
            SpatiePermission::firstOrCreate(['name' => $enum]);
        }

        SpatiePermission::whereNotIn('name', collect($enums)->pluck('value'))->delete();
    }

    private function syncRolesFromEnum(): void
    {
        $enums = [...Role::cases()];

        foreach ($enums as $enum) {
            SpatieRole::firstOrCreate(['name' => $enum->value]);
        }

        SpatieRole::whereNotIn('name', collect($enums)->pluck('value'))->delete();
    }

    private function assignPermissions(Role $role, array $permissions): void
    {
        SpatieRole::findByName($role->value)?->syncPermissions($permissions);
    }
}
