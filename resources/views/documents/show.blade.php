@extends('layouts.app')
@section('title', 'Detalhes do Documento')

@section('content')
  <div class="container px-2 px-md-0">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Documentos</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $document->original_name }}</li>
      </ol>
    </nav>

    <div class="enterprise-form-card p-4 p-md-5 shadow-sm rounded-4 w-100 mx-auto">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span style="font-size:2.2rem;color:#8ee4af;">
            <ion-icon name="document-outline"></ion-icon>
          </span>
          <div>
            <h1 class="mb-0">{{ $document->original_name }}</h1>
            <span class="badge {{ status_badge_class($document->status) }}">
              {{ translate_status($document->status) }}
            </span>
          </div>
        </div>
        <a href="{{ route('documents.index') }}"
          class="btn btn-secondary btn-lg d-none d-md-inline-flex align-items-center gap-2">
          <ion-icon name="arrow-back-outline"></ion-icon> Voltar
        </a>
      </div>
      <div class="mb-3">
        <small class="text-muted">
          Tipo: {{ ucfirst($document->document_type) }} |
          Proprietário: {{ $document->owner->name ?? ($document->owner->title ?? ($document->owner_id ?? '-')) }} |
          Expira em:
          {{ $document->expiration_date ? \Carbon\Carbon::parse($document->expiration_date)->format('d/m/Y') : '-' }}
        </small>
      </div>

      <ul class="nav nav-tabs mb-4" id="documentTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button"
            role="tab">
            <ion-icon name="information-circle-outline"></ion-icon> Dados
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade show active" id="dados" role="tabpanel">
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="document-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Nome Original:</span>
                <span class="ms-2">{{ $document->original_name }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="file-tray-full-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Tipo:</span>
                <span class="ms-2">{{ ucfirst($document->document_type) }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="calendar-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Expiração:</span>
                <span class="ms-2">
                  {{ $document->expiration_date ? \Carbon\Carbon::parse($document->expiration_date)->format('d/m/Y') : '-' }}
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="cloud-download-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Arquivo:</span>
                <span class="ms-2">
                  @if ($document->file_path)
                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-link btn-sm">
                      <ion-icon name="download-outline"></ion-icon> Baixar/Visualizar
                    </a>
                  @else
                    Nenhum arquivo
                  @endif
                </span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="document-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">MIME Type:</span>
                <span class="ms-2">{{ $document->mime_type ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="folder-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Tamanho:</span>
                <span
                  class="ms-2">{{ $document->size ? number_format($document->size / 1024, 2, ',', '.') . ' KB' : '-' }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Proprietário:</span>
                <span
                  class="ms-2">{{ $document->owner->name ?? ($document->owner->title ?? ($document->owner_id ?? '-')) }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="person-add-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Tipo Proprietário:</span>
                <span class="ms-2">{{ $document->owner_type ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="cloud-upload-outline" class="me-2" style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Enviado por:</span>
                <span class="ms-2">{{ $document->uploaded_by_user_id ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="checkmark-done-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Validado por:</span>
                <span class="ms-2">{{ $document->validated_by_user_id ?? '-' }}</span>
              </div>
              <div class="d-flex align-items-center mb-2">
                <ion-icon name="checkmark-circle-outline" class="me-2"
                  style="font-size:1.2rem;color:#8ee4af;"></ion-icon>
                <span class="text-muted">Status:</span>
                <span class="ms-2 badge {{ status_badge_class($document->status) }}">
                  {{ translate_status($document->status) }}
                </span>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('documents.edit', $document) }}" class="btn btn-primary btn-lg px-4">
              <ion-icon name="create-outline"></ion-icon> Editar
            </a>
            <form method="POST" action="{{ route('documents.destroy', $document) }}" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-lg px-4"
                onclick="return confirm('Deseja realmente excluir este documento?')">
                <ion-icon name="trash-outline"></ion-icon> Excluir
              </button>
            </form>
          </div>
        </div>
      </div>
      <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-lg d-md-none w-100 mt-4">
        <ion-icon name="arrow-back-outline"></ion-icon> Voltar
      </a>
    </div>
  </div>
@endsection
