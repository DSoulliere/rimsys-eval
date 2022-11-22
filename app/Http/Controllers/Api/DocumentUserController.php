<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentUser\{ IndexDocumentUser, UpdateDocumentUser, DestroyDocumentUser };
use App\Http\Resources\DocumentResource;
use App\Models\{User, Document};
use Spatie\QueryBuilder\QueryBuilder;

class DocumentUserController extends Controller
{

    /**
     * Display a listing of the document_users.
     *
     * @param  \App\Http\Requests\Api\DocumentUser\IndexDocumentUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, IndexDocumentUser $request)
    {
        $fields = $request->validated();
        $query =  $user->documents();

        $document_users = $query->paginate($request->input('per_page') ?? null)->appends(request()->query());

        return DocumentResource::collection($document_users);
    }

    /**
     * Update the specified document_user in storage.
     *
     * @param  \App\Models\DocumentUser  $document_user
     * @param  \App\Http\Requests\Api\DocumentUser\UpdateDocumentUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Document $document, UpdateDocumentUser $request)
    {
        $user->documents()->syncWithoutDetaching($document);

        return response()->json(null, 202);
    }

    /**
     * Remove the specified document_user from storage.
     *
     * @param  \App\Models\DocumentUser  $document_user
     * @param  \App\Http\Requests\Api\DocumentUser\DestroyDocumentUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Document $document, DestroyDocumentUser $request)
    {
        $user->documents()->detach($document);
        return response()->json(null, 204);
    }
}
