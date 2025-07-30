{{-- resources/views/users/_form.blade.php --}}

<ul class="nav nav-tabs mb-4" id="userFormTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="tab-dados" data-bs-toggle="tab" data-bs-target="#dados" type="button">
      <ion-icon name="person-outline"></ion-icon> Dados do Usuário
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="tab-acessos" data-bs-toggle="tab" data-bs-target="#acessos" type="button">
      <ion-icon name="business-outline"></ion-icon> Empresas & Filiais
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="tab-papeis" data-bs-toggle="tab" data-bs-target="#papeis" type="button">
      <ion-icon name="person-badge-outline"></ion-icon> Papéis
    </button>
  </li>
</ul>

<div class="tab-content" id="userFormTabContent">
  {{-- DADOS DO USUÁRIO --}}
  <div class="tab-pane fade show active" id="dados">
    <div class="card table p-4 mb-4">
      <div class="row g-4">
        <div class="col-md-6">
          <label for="name" class="form-label fw-semibold">Nome *</label>
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label fw-semibold">E-mail *</label>
          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}" required>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        {{-- Campos de senha apenas no CREATE --}}
        @if (!isset($user))
          <div class="col-md-6">
            <label for="password" class="form-label fw-semibold">Senha *</label>
            <input type="password" name="password" id="password"
              class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required
              minlength="8">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="password_confirmation" class="form-label fw-semibold">Confirme a senha *</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
              autocomplete="new-password" required minlength="8">
          </div>
        @endif
        {{-- Botão alterar senha apenas no EDIT --}}
        @if (isset($user))
          <div class="col-12 mt-2">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
              data-bs-target="#passwordModal">
              <ion-icon name="key-outline"></ion-icon> Alterar Senha
            </button>
          </div>
        @endif
      </div>
      <div class="row g-4 mt-2">
        <div class="col-md-3">
          <label for="status" class="form-label fw-semibold">Status *</label>
          <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>Ativo</option>
            <option value="inactive" @selected(old('status', $user->status ?? '') === 'inactive')>Inativo</option>
          </select>
          @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
  </div>

  {{-- ACESSOS (EMPRESAS & FILIAIS) --}}
  <div class="tab-pane fade" id="acessos">
    <div class="card table p-4 mb-4">
      <div class="mb-3">
        <div class="fw-semibold mb-1">Empresas *</div>
        <div class="row">
          @foreach ($enterprises as $enterprise)
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-check mb-2">
                <input class="form-check-input empresa-checkbox" type="checkbox" name="enterprises[]"
                  value="{{ $enterprise->id }}" id="empresa-{{ $enterprise->id }}"
                  {{ in_array($enterprise->id, old('enterprises', $userEnterpriseIds ?? [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="empresa-{{ $enterprise->id }}">
                  {{ $enterprise->name }}
                </label>
              </div>
            </div>
          @endforeach
        </div>
        <small class="text-muted" id="empresaCounterText"></small>
        @error('enterprises')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-2">
        <div class="fw-semibold mb-1">Filiais *</div>
        <p class="text-muted mb-2">Selecione a(s) empresa(s) para exibir filiais relacionadas.</p>
        <div id="filialCheckboxArea"></div>
        <small class="text-muted" id="filialCounterText"></small>
        @error('branches')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  {{-- PAPÉIS --}}
  <div class="tab-pane fade" id="papeis">
    <div class="card table p-4 mb-4">
      <label class="form-label fw-semibold mb-2">Papéis *</label>
      <div class="row">
        @php
          $checkedRoles = old('roles', $userRoleNames ?? []);
        @endphp
        @foreach ($roles as $role)
          <div class="col-12 col-md-6 col-lg-4">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                id="role-{{ $role->id }}" {{ in_array($role->name, $checkedRoles) ? 'checked' : '' }}>
              <label class="form-check-label" for="role-{{ $role->id }}">
                {{ ucfirst($role->name) }}
              </label>
            </div>
          </div>
        @endforeach
      </div>
      <small class="text-muted" id="roleCounterText"></small>
      @error('roles')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
    <div class="card table p-4 mb-2">
      <label class="form-label text-muted mb-0">Permissões (em breve)</label>
      <small class="text-muted d-block">Você poderá customizar permissões individualmente por usuário.</small>
    </div>
  </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-3">
  <button type="submit" class="btn btn-primary btn-lg px-4">
    <ion-icon name="checkmark-outline"></ion-icon> Salvar
  </button>
  <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg px-4">
    <ion-icon name="arrow-back-outline"></ion-icon> Cancelar
  </a>
</div>

@if (isset($user))
  @include('users._password_modal', ['user' => $user])
@endif

@push('scripts')
  <script>
    // O mesmo JS que você já possuía para exibir filiais dinâmicas por empresas
    const branchesData = @json($branchesData ?? []);
    let oldBranches = @json(old('branches', $userBranchIds ?? []));

    function renderFiliais(empresasSelecionadas, branchesData, oldBranches) {
      let html = '';
      empresasSelecionadas.forEach(eid => {
        const filiais = branchesData.filter(b => String(b.enterprise_id) === String(eid));
        if (filiais.length) {
          html += `<div class="mb-2"><strong>Empresa: ${filiais[0].enterprise_name}</strong></div>`;
          filiais.forEach(filial => {
            const checked = oldBranches.includes(String(filial.id)) ? 'checked' : '';
            html += `<div class="form-check ms-3 mb-1">
              <input class="form-check-input filial-checkbox" type="checkbox"
                   name="branches[]" value="${filial.id}" id="filial-${filial.id}" ${checked}>
              <label class="form-check-label" for="filial-${filial.id}">${filial.name}</label>
            </div>`;
          });
        }
      });
      document.getElementById('filialCheckboxArea').innerHTML = html ||
        '<div class="text-muted">Nenhuma empresa selecionada.</div>';
      updateCounters();
    }

    function updateCounters() {
      document.getElementById('empresaCounterText').textContent =
        document.querySelectorAll('.empresa-checkbox:checked').length + ' empresa(s) selecionada(s).';
      document.getElementById('filialCounterText').textContent =
        document.querySelectorAll('.filial-checkbox:checked').length + ' filial(is) selecionada(s).';
      document.getElementById('roleCounterText').textContent =
        document.querySelectorAll('input[name="roles[]"]:checked').length + ' papel(is) selecionado(s).';
    }

    document.addEventListener('DOMContentLoaded', function() {
      function getSelectedEmpresas() {
        return Array.from(document.querySelectorAll('.empresa-checkbox:checked')).map(cb => cb.value);
      }
      renderFiliais(getSelectedEmpresas(), branchesData, oldBranches);
      updateCounters();

      document.querySelectorAll('.empresa-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
          renderFiliais(getSelectedEmpresas(), branchesData, oldBranches);
        });
      });
      document.getElementById('filialCheckboxArea').addEventListener('change', updateCounters);
      document.getElementById('papeis').addEventListener('change', updateCounters);
    });
  </script>
@endpush
