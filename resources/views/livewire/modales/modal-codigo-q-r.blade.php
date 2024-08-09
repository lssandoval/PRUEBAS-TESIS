<div>
    <div id="modalQR" class="modal fade" tabindex="-1" aria-labelledby="modalQRLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQRLabel">QR del Bien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>ID: <span id="modalQRId"></span></p>
                    <p>Código Bien: <span id="modalQRCodigoBien"></span></p>
                    <div id="modalQRCode"></div>
                    {{-- <button type="button" class="btn btn-primary btnGenerarQRModal" id="btnGenerarQR">Generar QR</button> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>