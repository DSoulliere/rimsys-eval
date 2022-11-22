<?php

namespace App\Policies\Api;

use App\Models\{ Document, User };

use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any documents.
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
     * Determine whether the user can view the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     *
     * @return mixed
     */
    public function show(User $user, Document $document)
    {
        return $user->documents->contains($document);
    }

    /**
     * Determine whether the user can create documents.
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
     * Determine whether the user can update the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     *
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        return $user->documents->contains($document);
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     *
     * @return mixed
     */
    public function destroy(User $user, Document $document)
    {
        return $user->documents->contains($document);
    }


    /**
     * Determine whether the user can unlink the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $reader
     * @param  \App\Models\Document  $document
     *
     * @return mixed
     */
    public function unlink(User $user, User $reader, Document $document)
    {
        return $user->reader->id === $user->id;
    }


}
