<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('users.change_password', $user) }}" autocomplete="off">
      @csrf
      @method('PUT')
      <div class="modal-content border-0">
        <div class="modal-header bg-warning bg-opacity-25 border-0">
          <h5 class="modal-title fw-bold" id="passwordModalLabel">
            <i class="bi bi-key-fill me-2 text-warning"></i>
            Alterar Senha do Usuário
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning mb-4 fw-semibold d-flex align-items-center" style="font-size:1rem;">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            A alteração de senha não pode ser desfeita! Informe uma nova senha segura e, se necessário,
            comunique o usuário.
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">Nova Senha *</label>
            <input type="password" name="new_password" id="new_password"
              class="form-control @error('new_password') is-invalid @enderror" minlength="8"
              autocomplete="new-password" placeholder="Nova senha">
            @error('new_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirmar Nova Senha *</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control"
              minlength="8" autocomplete="new-password" placeholder="Confirme a nova senha">
          </div>
          <div class="form-text text-muted mt-0">
            A senha deve ter no mínimo 8 caracteres.
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-lg"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-key"></i> Salvar Nova Senha
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('passwordModal');
    if (!modal) return;

    function setRequired(state) {
      var n = document.getElementById('new_password');
      var c = document.getElementById('new_password_confirmation');
      if (!n || !c) return;
      if (state) {
        n.setAttribute('required', 'required');
        c.setAttribute('required', 'required');
      } else {
        n.removeAttribute('required');
        c.removeAttribute('required');
      }
    }

    modal.addEventListener('show.bs.modal', function() {
      setRequired(true);
    });
    modal.addEventListener('hidden.bs.modal', function() {
      setRequired(false);
      document.getElementById('new_password').value = '';
      document.getElementById('new_password_confirmation').value = '';
    });
  });
</script>
