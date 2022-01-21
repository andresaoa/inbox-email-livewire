<div wire:ignore>

    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="inserto" style="display:none">
        <strong id="texto"></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <table class="table table-striped custom-table bg-white" id="usuarios">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">USUARIO CALLCENTER</th>
                <th scope="col">PERMISOS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $item)
                <tr scope="row">
                    <td>
                        {{ $item->id }}
                    </td>
                    <td>
                        {{ $item->{'usuario'} }}
                    </td>
                    <td class="pl-0">
                        <div class="d-flex align-items-center">
                            <label class="custom-control ios-switch">
                                <label class="custom-control ios-switch">
                                    <input type="checkbox" class="ios-switch-control-input"
                                        onclick="mifun({{ $item->id }},{{ $item->estado == null ? 0 : $item->estado }})"
                                        {{ $item->estado == 1 ? 'checked' : '' }}>
                                    <span class="ios-switch-control-indicator"></span>
                                </label>
                            </label>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $('#usuarios').DataTable({
            "scrollX": false,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });

        function mifun(id, estado) {
            console.log(id);
            if (estado == 0) {
                $("#inserto").show();
                $("#texto").html("Se Inserto con exito!");
                setTimeout(function() {
                    $('#inserto').hide()
                }, 4000);
            } else {
                $("#inserto").show();
                $("#texto").html("Se elimino con exito!");
                setTimeout(function() {
                    $('#inserto').hide()
                }, 4000);
            }
            window.livewire.emit('agregaroeliminar', id, estado)
        }
    </script>
</div>
