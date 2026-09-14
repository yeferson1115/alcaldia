@extends('layouts.app')

@section('title', 'Acuerdo de Pago')
@section('page_title', 'Acuerdo de Pago')



@section('content')

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Consultar estado de Cuenta</h4>
                        <p>Ingrese su numero de documento para validar la información</p>
                    </div>
                    <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('acuerdo-de-pago.search') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="document" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" id="document" name="document" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




@endsection
@push('scripts')
<script>
    $('.delete-user').click(function(e){

        e.preventDefault();
        var _target=e.target;
        let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
        let token = $(this).attr('data-token');
        var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea eliminar el usuario?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            var data = $('#user_delete').serialize();
            $.ajax({
              url: href,
              headers: {'X-CSRF-TOKEN': token},
              type: 'DELETE',
              cache: false,
    	      data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                console.log(json);
                Swal.fire(
                    'Muy bien!',
                    'Usuario Eliminado correctamente',
                    'success'
                    ).then((result) => {
                        location.reload();

                    });

              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);

              }
           });

        }
        })

    });
</script>

@endpush

