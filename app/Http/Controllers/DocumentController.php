<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('owner', 'uploadedBy', 'validatedBy')->paginate(20);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_path' => 'required|string|max:255',
            'document_type' => 'required|string|max:50',
            'original_name' => 'required|string|max:255',
            'mime_type' => 'required|string|max:100',
            'size' => 'required|integer',
            'expiration_date' => 'nullable|date',
            'status' => 'required|string|max:30',
            'owner_id' => 'required|integer',
            'owner_type' => 'required|string|max:100',
            'uploaded_by_user_id' => 'nullable|exists:users,id',
            'validated_by_user_id' => 'nullable|exists:users,id',
        ]);

        $document = Document::create($validated);

        return redirect()->route('documents.show', $document)->with('success', 'Documento cadastrado!');
    }

    public function show(Document $document)
    {
        $document->load('owner', 'uploadedBy', 'validatedBy');
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'file_path' => 'required|string|max:255',
            'document_type' => 'required|string|max:50',
            'original_name' => 'required|string|max:255',
            'mime_type' => 'required|string|max:100',
            'size' => 'required|integer',
            'expiration_date' => 'nullable|date',
            'status' => 'required|string|max:30',
            'owner_id' => 'required|integer',
            'owner_type' => 'required|string|max:100',
            'uploaded_by_user_id' => 'nullable|exists:users,id',
            'validated_by_user_id' => 'nullable|exists:users,id',
        ]);

        $document->update($validated);

        return redirect()->route('documents.show', $document)->with('success', 'Documento atualizado!');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Documento removido!');
    }
}
