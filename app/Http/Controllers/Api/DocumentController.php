<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Document\{ IndexDocument, ShowDocument, StoreDocument, UpdateDocument, DestroyDocument };
use App\Http\Resources\DocumentResource;
use App\Models\Document;

class DocumentController extends Controller
{

    /**
     * Display a listing of the documents.
     *
     * @param  \App\Http\Requests\Api\Document\IndexDocument  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexDocument $request)
    {
        $fields = $request->validated();
        $query = Document::select();

        $documents = $query->paginate($request->input('per_page') ?? null)->appends(request()->query());

        return DocumentResource::collection($documents);
    }

    /**
     * Display the specified document.
     *
     * @param  \App\Models\Document  $document
     * @param  \App\Http\Requests\Api\Document\ShowDocument  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document, ShowDocument $request)
    {
        return new DocumentResource($document);
    }

    /**
     * Store a newly created document in storage.
     *
     * @param  \App\Http\Requests\Api\Document\StoreDocument  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument $request)
    {
        $fields = $request->validated();
        $document = Document::create($fields)->fresh();

        return new DocumentResource($document);
    }

    /**
     * Update the specified document in storage.
     *
     * @param  \App\Models\Document  $document
     * @param  \App\Http\Requests\Api\Document\UpdateDocument  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Document $document, UpdateDocument $request)
    {
        $fields = $request->validated();

        $document->fill($fields);
        $document->save();

        return new DocumentResource($document->fresh());
    }

    /**
     * Remove the specified document from storage.
     *
     * @param  \App\Models\Document  $document
     * @param  \App\Http\Requests\Api\Document\DestroyDocument  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document, DestroyDocument $request)
    {
        $document->delete();
        return response()->json(null, 204);
    }
}
