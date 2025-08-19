<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\AuditLogger;

class DocumentController extends Controller
{
    /**
     * Retorna os tipos de documento disponíveis.
     */
    private function getDocumentTypes()
    {
        return [
            'cnh',
            'crlv',
            'comprovante_residencia',
            'contrato_social',
            'outro',
        ];
    }

    public function index()
    {
        $this->authorize('viewAny', Document::class);
        $documents = Document::with('owner', 'uploadedBy', 'validatedBy')->paginate(20);
        $documentTypes = $this->getDocumentTypes();
        $canCreateDocument = Gate::allows('create', Document::class);
        return view('documents.index', compact('documents', 'documentTypes', 'canCreateDocument'));
    }

    public function create()
    {
        $this->authorize('create', Document::class);
        $documentTypes = $this->getDocumentTypes();
        return view('documents.create', compact('documentTypes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Document::class);
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
        AuditLogger::log('created', $document, [], $document->toArray());

        return redirect()->route('documents.show', $document)->with('success', 'Documento cadastrado!');
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);
        $document->load('owner', 'uploadedBy', 'validatedBy');
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $this->authorize('update', $document);
        $documentTypes = $this->getDocumentTypes();
        return view('documents.edit', compact('document', 'documentTypes'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);
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

        $old = $document->getOriginal();
        $document->update($validated);
        AuditLogger::log('updated', $document, $old, $document->toArray());

        return redirect()->route('documents.show', $document)->with('success', 'Documento atualizado!');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        $old = $document->getOriginal();
        $document->delete();
        AuditLogger::log('deleted', $document, $old, []);
        return redirect()->route('documents.index')->with('success', 'Documento removido!');
    }
}
