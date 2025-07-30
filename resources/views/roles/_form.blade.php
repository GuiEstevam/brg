<div class="row g-3">
  <div class="col-md-6">
    <label for="name" class="form-label fw-semibold">Nome do Papel *</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
      placeholder="Ex: admin, operador, veiculo" value="{{ old('name', $role->name ?? '') }}" required autocomplete="off">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">
      Use nomes curtos e sem espaços, exemplo: <i>admin, operador, veiculo</i>.
    </small>
  </div>
  <!-- Campo de empresa removido, todos os papéis são globais -->
  <div class="col-12">
    <label class="form-label fw-semibold mb-1">
      Permissões deste papel <span class="text-danger">*</span>
      <i class="bi bi-info-circle text-muted" tabindex="0" data-bs-toggle="popover"
        data-bs-content="Marque as funcionalidades disponíveis para este papel. Você pode marcar/desmarcar o grupo inteiro."></i>
    </label>
    <fieldset class="border rounded-3 p-3 mt-2">
      <legend class="small text-muted w-auto px-2 mb-2" style="font-size:0.95em">Selecione as permissões desejadas
      </legend>
      @php
        $grouped = collect($permissions)->groupBy(function ($perm) {
            return explode('.', $perm->name, 2)[0];
        });
        $checkedPerms = old('permissions', isset($role) ? $role->permissions->pluck('name')->toArray() : []);
      @endphp
      <div class="row g-4">
        @forelse ($grouped as $group => $perms)
          <div class="col-12 col-md-6 col-xl-4 mb-4">
            <div class="border rounded-2 p-3 h-100">
              <div class="d-flex align-items-center mb-2">
                <input type="checkbox" class="form-check-input me-2 group-check" id="group-{{ $group }}"
                  onclick="toggleGroup('{{ $group }}', this)">
                <label class="fw-bold mb-0 fs-6" for="group-{{ $group }}">
                  {{ ucfirst($group) }}
                </label>
                <small class="text-muted ms-2">(Marcar/Desmarcar grupo)</small>
              </div>
              @foreach ($perms as $perm)
                <div class="form-check mb-1 ms-3">
                  <input class="form-check-input perm-{{ $group }}" type="checkbox" id="perm-{{ $perm->id }}"
                    name="permissions[]" value="{{ $perm->name }}"
                    {{ in_array($perm->name, $checkedPerms) ? 'checked' : '' }}>
                  <label class="form-check-label" for="perm-{{ $perm->id }}">
                    {{ format_permission($perm->name) }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>
        @empty
          <div class="col-12 text-muted">Nenhuma permissão cadastrada.</div>
        @endforelse
      </div>
    </fieldset>
    <small class="form-text text-muted">
      Marcar pelo menos uma permissão para que o papel tenha efeito.
    </small>
    @error('permissions')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-12 d-flex gap-2 justify-content-end mt-3">
    <button type="submit" class="btn btn-primary btn-sm px-3">
      <i class="bi bi-check2"></i> Salvar
    </button>
    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-sm px-3">
      Cancelar
    </a>
  </div>
</div>

@push('scripts')
  <script>
    function toggleGroup(group, groupCheckbox) {
      const perms = document.querySelectorAll('.perm-' + group);
      perms.forEach(perm => perm.checked = groupCheckbox.checked);
    }
    document.addEventListener('DOMContentLoaded', function() {
      const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
      popoverTriggerList.map(function(popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl, {
          trigger: 'focus',
          placement: 'right'
        });
      });
    });
  </script>
@endpush
