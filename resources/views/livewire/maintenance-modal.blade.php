<div wire:ignore.self class="modal fade" id="modalProgramarMantenimientos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalProgramarMantenimientos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            @if($isOpen)
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Mantenimiento Programado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <p>Fecha seleccionada: {{ $selectedDate }}</p>
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <label for="selectedNuevatId" class="form-label">Seleccionar Bien</label>
                        <select id="selectedNuevatId" wire:model="selectedNuevatId" class="form-select">
                            <option value="">Seleccione un bien</option>
                            @foreach($nuevat as $nuevat)
                            <option value="{{ $nuevat->id }}">{{ $nuevat->codigo_bien }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="codigoBien" class="form-label">Código del Bien</label>
                        <input type="text" id="codigoBien" wire:model="codigoBien" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tipoBien" class="form-label">Tipo de Bien</label>
                        <input type="text" id="tipoBien" wire:model="tipoBien" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="usoBien" class="form-label">Uso del Bien</label>
                        <input type="text" id="usoBien" wire:model="usoBien" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="custodioBien" class="form-label">Custodio del Bien</label>
                        <input type="text" id="custodioBien" wire:model="custodioBien" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="horaInicio" class="form-label">Hora de Inicio del Mantenimiento</label>
                        <input type="time" id="horaInicio" wire:model="horaInicio" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="horaFin" class="form-label">Hora de Finalización del Mantenimiento</label>
                        <input type="time" id="horaFin" wire:model="horaFin" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="tecnicoAsignado" class="form-label">Técnico Asignado</label>
                        <input type="text" id="tecnicoAsignado" wire:model="tecnicoAsignado" class="form-control">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-full">Guardar</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
