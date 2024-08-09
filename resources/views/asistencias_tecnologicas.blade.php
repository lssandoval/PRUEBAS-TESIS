<!-- resources/views/asistencias_tecnologicas.blade.php -->

<x-app-layout>

    <div class="py-12 h-screen overflow-y-auto bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col space-y-6">

                <!-- Carrusel del Glosario -->
                <div class="relative">
                    <!-- Contenido del Carrusel -->
                    <div class="overflow-hidden relative">
                        <div class="flex transition-transform duration-300" id="carouselContent">
                            <!-- Estado 1 -->
                            <div class="flex-shrink-0 w-full bg-white p-4 rounded-lg shadow-md text-sm mb-8">
                                <div class="flex mb-4">
                                    <div class="w-1/4 flex items-center justify-center mr-8">
                                        <i class="fa-solid fa-face-grin-beam-sweat" style="font-size: 9.4375rem;"></i>
                                    </div>
                                    <div class="w-3/4 ml-8">
                                        <h3 class="text-lg font-semibold mb-2">EN ESPERA</h3>
                                        <p class="mb-2">Este es el estado inicial de la solicitud después de ser creada. Indica que la solicitud ha sido registrada pero aún no se ha tomado ninguna acción adicional.</p>
                                        <p class="mb-2"><strong>Acciones Disponibles:</strong></p>
                                        <ul class="list-disc pl-5">
                                            <li><strong>Asignar Técnico:</strong> Al hacer clic en este botón, se abre un modal para seleccionar un técnico.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado 2 -->
                            <div class="flex-shrink-0 w-full bg-white p-4 rounded-lg shadow-md text-sm mb-8">
                                <div class="flex mb-4">
                                    <div class="w-1/4 flex items-center justify-center mr-8">
                                        <i class="fa-solid fa-chalkboard-user" style="font-size: 9.4375rem;"></i>
                                    </div>
                                    <div class="w-3/4 ml-8">
                                        <h3 class="text-lg font-semibold mb-2">ASIGNADO</h3>
                                        <p class="mb-2">Este estado indica que se ha asignado un técnico para la solicitud, pero aún no se ha completado la asistencia.</p>
                                        <p class="mb-2"><strong>Acciones Disponibles:</strong></p>
                                        <ul class="list-disc pl-5">
                                            <li><strong>Ingreso de Solución:</strong> Se habilita un botón para registrar la solución proporcionada.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado 3 -->
                            <div class="flex-shrink-0 w-full bg-white p-4 rounded-lg shadow-md text-sm mb-8">
                                <div class="flex mb-4">
                                    <div class="w-1/4 flex items-center justify-center mr-8">
                                        <i class="fa-solid fa-check" style="font-size: 9.4375rem;"></i>
                                    </div>
                                    <div class="w-3/4 ml-8">
                                        <h3 class="text-lg font-semibold mb-2">EJECUTADO</h3>
                                        <p class="mb-2">El estado "EJECUTADO" indica que la asistencia tecnológica ha sido completada por el técnico.</p>
                                        <p class="mb-2"><strong>Acciones Disponibles:</strong></p>
                                        <ul class="list-disc pl-5">
                                            <li><strong>Visualizar Solución:</strong> El usuario puede revisar los detalles de la solución ingresada.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Controles del Carrusel -->
                        <div class="absolute inset-x-0 bottom-0 flex justify-center space-x-4 py-2">
                            <!-- Aquí se eliminan las flechas de navegación -->
                        </div>
                    </div>
                </div>

                <!-- Tabla de Asistencias Tecnológicas -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-bold">Asistencias Tecnológicas</h1>
                        <!-- Botón para abrir el modal -->
                        <button onclick="toggleModal(true)" class="bg-gray-900 text-gray-900 px-4 py-2 rounded hover:bg-blue-600">
                            Añadir Asistencia
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="bg-white shadow-md rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-yellow-200 via-blue-200 to-red-200">
                                    <tr>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TIPO DE REQUERIMIENTO</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SOLICITANTE</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FECHA DE SOLICITUD</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TIPO DEL BIEN</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ESTADO</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACCIÓN</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($asistencias as $asistencia)
                                    <tr>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $asistencia->tipo_requerimiento }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-500">{{ $asistencia->solicitante }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-500">{{ $asistencia->fecha_solicitud->format('Y-m-d') }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-500">{{ $asistencia->tipo_bien }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-500">{{ $asistencia->estado->nombre }}</td>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-500">
                                            @if ($asistencia->canAssignTechnician())
                                            <button onclick="assignTechnician({{ $asistencia->id }})" class="w-full bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                                Asignar Técnico
                                            </button>
                                            @elseif ($asistencia->canEnterSolution())
                                            <button onclick="enterSolution({{ $asistencia->id }})" class="w-full bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                                Ingreso de Solución
                                            </button>
                                            @elseif ($asistencia->canGenerateReport())
                                            <button onclick="generateReport({{ $asistencia->id }})" class="w-full bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                                Generar Informe
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
     
    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Agregar Asistencia</h2>
            <form action="{{ route('asistencias.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="tipo_requerimiento" class="block text-sm font-medium text-gray-700">Tipo de Requerimiento</label>
                    <input type="text" id="tipo_requerimiento" name="tipo_requerimiento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="solicitante" class="block text-sm font-medium text-gray-700">Solicitante</label>
                    <input type="text" id="solicitante" name="solicitante" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="fecha_solicitud" class="block text-sm font-medium text-gray-700">Fecha de Solicitud</label>
                    <input type="date" id="fecha_solicitud" name="fecha_solicitud" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="tipo_bien" class="block text-sm font-medium text-gray-700">Tipo del Bien</label>
                    <input type="text" id="tipo_bien" name="tipo_bien" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="estado_id" name="estado_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="1">En Espera</option>
                        <option value="2">Asignado</option>
                        <option value="3">Ejecutado</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-gray-800 px-4 py-2 rounded-lg hover:bg-blue-600 transition">Guardar</button>
                    <button type="button" onclick="toggleModal(false)" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Cancelar</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselContent = document.getElementById('carouselContent');
            let offset = 0;

            function moveCarousel() {
                const itemWidth = carouselContent.scrollWidth / carouselContent.children.length;
                offset -= itemWidth;
                if (Math.abs(offset) >= itemWidth * (carouselContent.children.length)) {
                    offset = 0;
                }
                carouselContent.style.transform = `translateX(${offset}px)`;
            }

            setInterval(moveCarousel, 5000); // Cambia cada 5 segundos
        });

        function toggleModal(show) {
            document.getElementById('modal').classList.toggle('hidden', !show);
        }

        function assignTechnician(id) {
            // Lógica para asignar técnico
            console.log('Asignar Técnico para ID:', id);
            // Aquí podrías abrir un modal para seleccionar el técnico
        }

        function enterSolution(id) {
            // Lógica para ingresar solución
            console.log('Ingreso de Solución para ID:', id);
            // Aquí podrías abrir un modal para ingresar la solución
        }

        function generateReport(id) {
            // Lógica para generar informe
            console.log('Generar Informe para ID:', id);
            // Aquí podrías generar el informe o redirigir a una página de informes
        }
    </script>
</x-app-layout>