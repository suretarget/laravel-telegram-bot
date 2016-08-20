<?php

namespace SumanIon\TelegramBot\Support;

use Illuminate\Support\Facades\DB;
use SumanIon\TelegramBot\TelegramBotPermission;

trait ManagesBotUserPermissions
{
    /**
     * A user may have many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(TelegramBotPermission::class, 'telegram_bot_pivot');
    }

    /**
     * Get permission object from string.
     *
     * @param  mixed $permission
     *
     * @return \SumanIon\TelegramBot\TelegramBotPermission
     */
    public function getPermission($permission)
    {
        if ($permission instanceof TelegramBotPermission) {
            return $permission;
        }

        return TelegramBotPermission::where('name', $permission)->firstOrFail();
    }

    /**
     * Check if user has a specific permission.
     *
     * @param  mixed  $permission
     *
     * @return boolean
     */
    public function hasPermission($permission)
    {
        $permission = $this->getPermission($permission);

        return !!DB::table('telegram_bot_pivot')
                   ->where('telegram_bot_user_id', $this->id)
                   ->where('telegram_bot_permission_id', $permission->id)
                   ->first();
    }

    /**
     * Add a new permission to user.
     *
     * @param mixed $permission
     */
    public function addPermission($permission)
    {
        if (!$this->hasPermission($permission)) {

            $permission = $this->getPermission($permission);

            DB::table('telegram_bot_pivot')->insert([
                'telegram_bot_user_id' => $this->id,
                'telegram_bot_permission_id' => $permission->id
            ]);
        }
    }

    /**
     * Delete permission from the user.
     *
     * @param  mixed $permission
     *
     * @return void
     */
    public function removePermission($permission)
    {
        $permission = $this->getPermission($permission);

        DB::table('telegram_bot_pivot')
           ->where('telegram_bot_user_id', $this->id)
           ->where('telegram_bot_permission_id', $permission->id)
           ->delete();
    }

    /**
     * Delete all permissions from the user.
     *
     * @return void
     */
    public function removeAllPermissions()
    {
        DB::table('telegram_bot_pivot')
           ->where('telegram_bot_user_id', $this->id)
           ->delete();
    }
}