<div class="row g-4">
  <div class="col-md-6 form-floating">
    <select name="document_type" id="document_type" class="form-select @error('document_type') is-invalid @enderror"
      required>
      <option value="">Selecione o tipo</option>
      @foreach ($documentTypes as $type)
        <option value="{{ $type }}" @selected(old('document_type', $document->document_type ?? request('document_type')) == $type)>
          {{ ucfirst($type) }}
        </option>
      @endforeach
    </select>
    <label for="document_type">Tipo de Documento *</label>
    @error('document_type')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <input type="text" name="original_name" id="original_name"
      class="form-control @error('original_name') is-invalid @enderror"
      value="{{ old('original_name', $document->original_name ?? '') }}" placeholder="Nome Original" required>
    <label for="original_name">Nome Original *</label>
    @error('original_name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6">
    <label for="file" class="form-label">Arquivo (PDF ou imagem)</label>
    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror"
      accept="application/pdf,image/*">
    @error('file')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if (isset($document) && $document->file_path)
      <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-link mt-2">Ver documento
        atual</a>
    @endif
  </div>
  <div class="col-md-3 form-floating">
    <input type="date" name="expiration_date" id="expiration_date"
      class="form-control @error('expiration_date') is-invalid @enderror"
      value="{{ old('expiration_date', $document->expiration_date ?? '') }}">
    <label for="expiration_date">Data de Expiração</label>
    @error('expiration_date')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
      <option value="valid" @selected(old('status', $document->status ?? '') == 'valid')>Válido</option>
      <option value="expired" @selected(old('status', $document->status ?? '') == 'expired')>Expirado</option>
      <option value="pending" @selected(old('status', $document->status ?? '') == 'pending')>Pendente</option>
      <option value="invalid" @selected(old('status', $document->status ?? '') == 'invalid')>Inválido</option>
    </select>
    <label for="status">Status *</label>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <select name="owner_type" id="owner_type" class="form-select @error('owner_type') is-invalid @enderror" required>
      <option value="">Selecione o tipo do proprietário</option>
      <option value="App\\Models\\Driver" @selected(old('owner_type', $document->owner_type ?? '') === 'App\\Models\\Driver')>Motorista</option>
      <option value="App\\Models\\Vehicle" @selected(old('owner_type', $document->owner_type ?? '') === 'App\\Models\\Vehicle')>Veículo</option>
    </select>
    <label for="owner_type">Tipo do Proprietário *</label>
    @error('owner_type')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <select name="owner_id" id="owner_id" class="form-select @error('owner_id') is-invalid @enderror" required>
      <option value="">Selecione o proprietário</option>
      @if (old('owner_type', $document->owner_type ?? '') === 'App\\Models\\Driver')
        @foreach (\App\Models\Driver::orderBy('name')->get() as $d)
          <option value="{{ $d->id }}" @selected(old('owner_id', $document->owner_id ?? '') == $d->id)>{{ $d->name }}</option>
        @endforeach
      @elseif(old('owner_type', $document->owner_type ?? '') === 'App\\Models\\Vehicle')
        @foreach (\App\Models\Vehicle::orderBy('plate')->get() as $v)
          <option value="{{ $v->id }}" @selected(old('owner_id', $document->owner_id ?? '') == $v->id)>{{ $v->plate }}</option>
        @endforeach
      @endif
    </select>
    <label for="owner_id">Proprietário *</label>
    @error('owner_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <input type="text" name="uploaded_by_user_id" id="uploaded_by_user_id"
      class="form-control @error('uploaded_by_user_id') is-invalid @enderror"
      value="{{ old('uploaded_by_user_id', $document->uploaded_by_user_id ?? '') }}"
      placeholder="ID do Usuário que Enviou" required>
    <label for="uploaded_by_user_id">Usuário que Enviou *</label>
    @error('uploaded_by_user_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <input type="text" name="validated_by_user_id" id="validated_by_user_id"
      class="form-control @error('validated_by_user_id') is-invalid @enderror"
      value="{{ old('validated_by_user_id', $document->validated_by_user_id ?? '') }}"
      placeholder="ID do Usuário que Validou">
    <label for="validated_by_user_id">Usuário que Validou</label>
    @error('validated_by_user_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
<div class="d-flex gap-2 mt-4 justify-content-end">
  <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
  <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
</div>
