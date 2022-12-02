<?php

namespace App\Policies\Api;

use App\Models\{ User };

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can unlink the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $reader
     *
     * @return mixed
     */
    public function isUser(User $user, User $reader)
    {
        return $reader->id === $reader->id;
    }

    /**
     * Determine whether the user can view any users.
     *
     * @param  \App\Models\User  $user
     *
     * @return mixed
     */
    public function index(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     *
     * @return mixed
     */
    public function show(User $reader, User $readable)
    {
        return $reader->id === $readable->id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $user
     *
     * @return mixed
     */
    public function store(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $editor
     * @param  \App\Models\User  $editable
     *
     * @return mixed
     */
    public function update(User $editor, User $editable)
    {
        return $editor->is($editable);
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $editor
     * @param  \App\Models\User  $editable
     *
     * @return mixed
     */
    public function destroy(User $editor, User $editable)
    {
        return false;
    }
}
