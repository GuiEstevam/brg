<div class="modal fade" id="deleteModal{{ $driver->id }}" tabindex="-1"
  aria-labelledby="deleteModalLabel{{ $driver->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('drivers.destroy', $driver) }}">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel{{ $driver->id }}">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir o motorista <strong>{{ $driver->name }}</strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
      </div>
    </form>
  </div>
</div>
