<div>
    <div class="modal fade" id="modalMantenimiento" tabindex="-1" aria-labelledby="modalMantenimientoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMantenimientoLabel">Registrar Mantenimiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para asignar valores a los campos de mantenimiento -->
                    <form wire:submit.prevent="guardarMantenimiento">
                        <div class="form-group">
                            <label for="codigoBien" class="form-label">Código Bien</label>
                            <input wire:model.defer="codigo_bien" type="text" class="form-control" id="codigoBien" name="txtcodigo_bienR">
                            @error('codigo_bien') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tipoMantenimiento">Tipo de Mantenimiento</label>
                            <select wire:model.defer="tipo_mantenimiento" class="form-control" id="tipoMantenimiento" name="tipo_mantenimiento">
                                <option value="">Seleccionar</option>
                                <option value="preventivo">Preventivo</option>
                                <option value="correctivo">Correctivo</option>
                            </select>
                            @error('tipo_mantenimiento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div id="detalleMantenimiento" style="display: none;">
                            <div class="form-group">
                                <label for="detallePreventivo">Detalle de Mantenimiento Preventivo</label>
                                <select wire:model.defer="detalle_preventivo" class="form-control" id="detallePreventivo" name="detalle_preventivo">
                                    <option value="">Seleccionar</option>
                                    <option value="fuera_vigencia">Mantenimiento a equipos fuera de vigencia tecnológica</option>
                                    <option value="dentro_vigencia">Mantenimiento a equipos dentro de vigencia tecnológica</option>
                                </select>
                                @error('detalle_preventivo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="observacionMantenimiento">Observación</label>
                            <textarea wire:model.defer="observacion_mantenimiento" class="form-control" id="observacionMantenimiento" name="observacion_mantenimiento"></textarea>
                            @error('observacion_mantenimiento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="recomendacionMantenimiento">Recomendación</label>
                            <textarea wire:model.defer="recomendacion_mantenimiento" class="form-control" id="recomendacionMantenimiento" name="recomendacion_mantenimiento"></textarea>
                            @error('recomendacion_mantenimiento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fechaMantenimiento">Fecha de Mantenimiento</label>
                            <input wire:model.defer="fecha_mantenimiento" type="date" class="form-control" id="fechaMantenimiento" name="fecha_mantenimiento">
                            @error('fecha_mantenimiento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tecnicoMantenimiento">Técnico de Mantenimiento</label>
                            <input wire:model.defer="tecnico_mantenimiento" type="text" class="form-control" id="tecnicoMantenimiento" name="tecnico_mantenimiento">
                            @error('tecnico_mantenimiento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="guardarMantenimiento">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('openModal', (codigoBien) => {
            Livewire.emit('setCodigoBien', codigoBien);
            var myModal = new bootstrap.Modal(document.getElementById('modalMantenimiento'));
            myModal.show();
        });
    });
</script>
@endpush
