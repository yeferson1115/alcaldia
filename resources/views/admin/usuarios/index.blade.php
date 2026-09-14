@extends('layouts.app')

@section('title', 'Usuarios')
@section('page_title', 'Usuarios')



@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Usuarios</h2>
                
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">               
                @can('Crear Usuarios')
                    <a href="{{ url('user/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i data-feather='user-plus'></i> Nuevo usuario</a>
                @endcan
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Usuarios</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th>#</th>
                                        <th>Acciones</th>
                                        <th>Nombre completo</th>
                                        <th>Usuario</th>
                                        <th>Género</th>
                                        <th>Tipo</th>
                                        <th>Correo electrónico</th>
                                        <th>Acceso</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr class="odd row{{ $user->id }}">

                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @can('Editar Usuarios')
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('user', [$user->id,'edit']) }}" title="Editar"><i class="ti ti-edit"></i> </a>
                                            @endcan
                                            @can('Eliminar Usuarios')
                                            <!--<a class="btn btn-danger waves-effect waves-float waves-light" href="{{ url('user', [$user->id,'edit']) }}"><i data-feather='trash-2'></i> </a>-->
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('user',[$user->id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i class="ti ti-trash"></i></button>
                                                </div>
                                            </form>
                                            @endcan
                                            </td>
                                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        @if ($user->genero == 'F')
                                        <td><i class="fa fa-female" aria-hidden="true" style="font-size: 30px;color: #f3adb9;"></i></td>
                                        @else
                                        <td><i class="fa fa-male" aria-hidden="true" style="font-size: 30px;color: #4242ad;"></i></td>
                                         @endif


                                        <td>
                                            @if($user->hasRole('Admin')) <b>Administrador</b> @endif
                                            @if($user->hasRole('Lider')) <b>Lider</b> @endif 
                                            @if($user->hasRole('Asesor')) <b>Asesor</b> @endif 
                                            @if($user->hasRole('Backoffice')) <b>Backoffice</b> @endif 
                                            @if($user->hasRole('Recepción')) <b>Recepción </b> @endif 
                                            @if($user->hasRole('Auxiliar Contable')) <b>Auxiliar Contable</b> @endif 
                                            @if($user->hasRole('Director(a) Recursos Humanos')) <b>Director(a) Recursos Humanos</b> @endif 
                                            @if($user->hasRole('Scaneer')) <b>Scaneer</b> @endif 
                                        </td>
                                        <td>{{ $user->email  }}</td>
                                        
                                        <td>
                                            @if($user->status==1)
                                            <span class="badge  text-white bg-success">Activo</span>
                                            @endif
                                            @if($user->status==0)
                                            <span class="badge  text-white bg-danger">Inactivo</span>
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

