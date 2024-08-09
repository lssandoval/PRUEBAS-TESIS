<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalSubirComponentes" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Cambio modal-sm por modal-lg para hacerlo más grande -->
        <div class="modal-content">
            <div class="modal-header bg-gray-800 shadow text-white pb-2 pt-2">
                <h6 class="modal-title fw-normal text-uppercase">Ingrese la lista de Bienes</h6>
                <button type="button" class="btn btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subirArchivoComponentes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Cargar UN archivo de Excel actualizado de los Componentes Tecnológicos. </label>
                        <input class="form-control" type="file" id="formFile" name="archivo" accept=".xls, .xlsx">
                        <span class="badge bg-success" id="nombreArchivo"></span>
                    </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading></span> Subir Archivo</button>
                </form>
            </div>
        </div>
    </div>
</div>
