@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@section('title')
    Entreprise

@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Entreprise</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                listes des entreprises</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('delete'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<!-- row -->
<div class="row">


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    @can('ajouter_entreprise')
                    <a class="btn btn-primary" data-effect="effect-scale"
                    data-toggle="modal" href="#modaldemo8">Ajouter une entreprise</a>
                    @endcan    
                 
                 </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">ICE</th>
                                <th class="border-bottom-0">Nom complet</th>
                                <th class="border-bottom-0">Informations bancaire</th>
                                <th class="border-bottom-0">Site Web</th>
                                <th class="border-bottom-0">Telephone</th>
                                <th class="border-bottom-0">Adresse</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Image</th>
                                <th class="border-bottom-0">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($entreprises as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->ice }}</td>
                                    <td>{{ $x->nom }}</td>
                                    <td>{{ $x->infobanque }}</td>
                                    <td>{{ $x->siteweb }}</td>
                                    <td>{{ $x->telephone }}</td>
                                    <td>{{ $x->adresse }}</td>
                                    <td>{{ $x->email }}</td>
                                    <td>
                                        <img src="{{ asset($x->image) }}" width="50" height="50" class="rounded-circle img-thumbnail">
                                    </td>

                                    <td>
                    @can('modifier_entreprise')
                                     
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                        data-id="{{ $x->id }}" 
                                        data-ice="{{ $x->ice }}"
                                        data-nom="{{ $x->nom }}" 
                                        data-infobanque="{{ $x->infobanque }}"
                                        data-siteweb="{{ $x->siteweb }}"
                                        data-telephone="{{ $x->telephone }}"
                                        data-adresse="{{ $x->adresse }}"
                                        data-email="{{ $x->email }}"
                                        data-toggle="modal"
                                        href="#exampleModal2" 
                                        title="modifier">
                                        <i class="las la-pen"></i>
                                     </a>
                                   @endcan
                            @can('supprimer_entreprise')

                                             <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-nom="{{ $x->nom }}"
                                                data-toggle="modal" href="#modaldemo9" title="supprimer"><i
                                                    class="las la-trash"></i></a>
                                   @endcan
                                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- add -->

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"> Ajouter une entreprise </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('entreprises.store') }}" method="post"enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="ice">ICE</label>
                            <input type="text" class="form-control" id="ice" name="ice">
                        </div>
                    
                        <div class="form-group">
                            <label for="nom">Nom Complet</label>
                            <input type="text" class="form-control" id="nom" name="nom">
                        </div>
                    
                        <div class="form-group">
                            <label for="infobanque">Informations bancaires</label>
                            <input type="text" class="form-control" id="infobanque" name="infobanque">
                        </div>
                    
                        <div class="form-group">
                            <label for="siteweb">Site web</label>
                            <input type="text" class="form-control" id="siteweb" name="siteweb">
                        </div>
                    
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone">
                        </div>
                    
                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse">
                        </div>
                    
                        <div class="form-group">
                            <label for="adresse">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="code_bare">Image<span class="required">*</span></label>
                            <input type="file"  class="form-control"  id="image" name="image"  >
                        </div> 

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Confirmer</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- End Basic modal -->


    </div>
    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier une entreprise</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="entreprises/update" method="post" autocomplete="off"enctype="multipart/form-data">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}


                        <input type="hidden" name="id" id="id" value="">


                        <div class="form-group">
                            <label for="exampleInputEmail1">ice</label>
                            <input type="text" class="form-control" id="ice" name="ice">
                        </div>
 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nom Complet</label>
                            <input type="text" class="form-control" id="nom" name="nom">
                        </div>
 
                        <div class="form-group">
                            <label for="exampleInputEmail1">infobanque</label>
                            <input type="text" class="form-control" id="infobanque" name="infobanque">
                        </div>
 
                        <div class="form-group">
                            <label for="exampleInputEmail1">siteweb</label>
                            <input type="text" class="form-control" id="siteweb" name="siteweb">
                        </div>
 
                        <div class="form-group">
                            <label for="exampleInputEmail1">telephone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone">
                        </div>

                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="code_bare">Image<span class="required">*</span></label>
                            <input type="file"  class="form-control"  id="image" name="image"  >
                        </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer une entreprise</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="entreprises/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p> Voulez-vous vraiment supprimer ?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="nom" id="nom" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-danger">Confirmer</button>
                    </div>
            </div>
            </form>
        </div>
    </div>




    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var ice = button.data('ice');
        var nom = button.data('nom');
        var infobanque = button.data('infobanque');
        var siteweb = button.data('siteweb');
        var telephone = button.data('telephone');
        var adresse = button.data('adresse');
        var email = button.data('email');
 
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #ice').val(ice);
        modal.find('.modal-body #nom').val(nom);
        modal.find('.modal-body #infobanque').val(infobanque);
        modal.find('.modal-body #siteweb').val(siteweb);
        modal.find('.modal-body #telephone').val(telephone);
        modal.find('.modal-body #adresse').val(adresse);
        modal.find('.modal-body #email').val(email);
    });
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var nom = button.data('nom')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #nom').val(nom);
    })

</script>

@endsection
