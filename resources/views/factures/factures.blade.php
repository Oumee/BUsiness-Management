@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    @section('title')
    Factures | Yadou Soft
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Factures</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                listes des factures</span>
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

  

@if(session()->has('Add'))
<script>
window.onload = function() 
{
notif({
msg: "{{ session()->get('Add') }}",
type: "success"
})
}
</script>
@endif

@if(session()->has('warning'))
<script>
window.onload = function() 
{
notif({
msg: "{{ session()->get('warning') }}" ,
type: "warning"
})
}
</script>
@endif
 
@if(session()->has('delete'))
<script>
window.onload = function() 
{
notif({
msg: "facture bien été supprimé",
type: "warning"
})
}
</script>
@endif

<!-- row -->
<div class="row">


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="modal-header">
             @can('exporter_facture')
                <a href="/Facturesexport" class="btn btn-primary" title="Exporter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-xlsx" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z"/>
                      </svg>
                    Exporter un fichier
                </a>
                @endcan
            </div>

            <div class="card-header pb-0">

                <form action="/recherche_factures" method="POST"  autocomplete="off">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        <div class="card-header pb-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="remis" id="remis">
                                <label class="form-check-label" for="remis">
                                    Remis
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="remis_partiellement" id="remis_partiellement">
                                <label class="form-check-label" for="remis_partiellement">
                                    Remis partiellement
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="non_remis" id="non_remis">
                                <label class="form-check-label" for="non_remis">
                                    Non remis
                                </label>
                            </div>
                  </div>
    
                 {{-- fjfjfj --}}

                        

                        <div class="col-lg-3" id="start_at">
                            <label for="exampleFormControlSelect1"> De la date </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}"
                                    name="start_at" placeholder="YYYY-MM-DD" type="text">
                            </div><!-- input-group -->
                        </div>

                        <div class="col-lg-3" id="end_at">
                            <label for="exampleFormControlSelect1"> à la date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="end_at"
                                    value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="text">
                            </div><!-- input-group -->
                        </div>


                    </div><br>

                    <div class="row">
                        @can('recherche_facture')
                        <div class="col-sm-1 col-md-1">
                
                            <button class="btn btn-primary">    
                                Recherche
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>
                        
                        </div>
                        @endcan
                    </div>
                    
                </form>

            </div>
             
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50' style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Numero </th>
                                <th class="border-bcottom-0">Date d'émission </th>
                                <th class="border-bcottom-0">Date d'écheance </th>
                                <th class="border-bcottom-0">Status </th>
                                <th class="border-bcottom-0">Client </th>
                                <th class="border-bottom-0">Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($factures as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }} </td>
                                    <td>{{ $x->numero }} </td>
                                    <td>{{ $x->date_emission }} </td>
                                    <td>{{ $x->date_echeance }}   </td>
                                 

                            @if($x->status==0)
                            <td>
                            <span class="badge badge-pill badge-danger ">non remis</span>
                            </td>
                            @endif
                            @if($x->status==1)
                            <td>
                            <span class="badge badge-pill badge-success ">remis</span>
                            </td>
                            @endif
                            @if($x->status==2)
                            <td>
                            <span class="badge badge-pill badge-warning ">remis partiellement</span>
                            </td>
                            @endif
                            <td>{{ $x->vente->client->nom }} {{ $x->vente->client->prenom }}  </td>
                                  
                            <td>
                                        <div class="container mt-5">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="las la-file-invoice"></i>
                                                </button>
                                                
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                 @can('modifier_facture')
                                                    <a class="dropdown-item" href="/ventes/show/{{ $x->vente->id}}" title="modifier">
                                                        <i class="las la-pen"></i> Modifier
                                                    </a>
                                                    @endcan
                                                    @can('telecharger_facture')
                                                    <a class="dropdown-item" href="download/{{$x->id}}" title="Télécharger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                                                            <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
                                                            <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
                                                          </svg> Envoyer facture par email 
                                                    </a>
                                                    @endcan

                                                    @can('imprimer_facture')
                                                    <a class="dropdown-item" href="{{ url('print') }}/{{ $x->id}}" title="Imprimer">
                                                        <i class="las la-print"></i> Imprimer
                                                    </a>
                                                    @endcan
                                                    @can('afficher_facture')
                                                    <a class="dropdown-item" href="{{ url('show') }}/{{ $x->id}}" title="Afficher">
                                                        <i class="las la-eye"></i> Afficher
                                                    </a>
                                                    @endcan
                                                    @can('supprimer_facture')
                                                    <a class="dropdown-item" data-effect="effect-scale" data-id="{{ $x->id }}" data-numero="{{ $x->numero }}" data-toggle="modal" href="#modaldemo9" title="supprimer">
                                                        <i class="las la-trash"></i> Supprimer
                                                    </a>
                                                    @endcan
                                                    @can('modifier_solde_facture')
                                                    <a class="dropdown-item" data-effect="effect-scale" data-id="{{ $x->id }}" data-numero="{{ $x->numero }}" data-toggle="modal" href="#modaldemo10" title="modifier solde">
                                                        <i class="las la-calendar"></i> Modifier Solde  </a>
                                                    @endcan
                                                    </div>
                                            </div>
                                        </div>
                                        
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
 
    <!-- edit -->
   

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer une facture</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="factures/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                        <div class="modal-body">
                        <p> Voulez-vous vraiment supprimer la facture numero :</p><br>
                        
                        <input class="form-control" name="numero" id="numero" type="text" readonly>
                        <input class="form-control" name="id" id="id" type="hidden" >
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-danger">Confirmer</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    {{-- status uppdate --}}
    <div class="modal" id="modaldemo10">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Modifier une facture</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="factures/update" method="post">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}

                        <div class="modal-body">
                        <p> le solde restant est :  </p><br> 
                        <input class="form-control" name="solde" id="solde" type="text" readonly>
                        
                        <p> Ajouter un solde </p><br>
                        <input class="form-control" name="soldeAjouter" id="soldeAjouter" type="text" required >

                        <input class="form-control" name="id" id="id" type="hidden" >
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
<!-- Add -->

 

{{-- <!-- Edit -->
<script>
    $(document).ready(function() {
        $('#actionSelect').change(function() {
            var selectedOption = $(this).val();
            var venteId = "{{ $x->vente->id }}";
            var numero = "{{ $x->numero }}";
            var id = "{{ $x->id }}";

            switch (selectedOption) {
                case 'edit':
                    window.location.href = "/ventes/show/" + venteId;
                    break;
                case 'view':
                    window.location.href = "{{ url('View_file') }}/" + numero + "/CoverLetter.pdf";
                    break;
                case 'download':
                    window.location.href = "{{ url('Download_file') }}/" + numero + "/CoverLetter.pdf";
                    break;
                case 'delete':
                    $('#modaldemo9').modal('show');
                    // Populate modal with data if necessary
                    break;
                case 'modify_balance':
                    $('#modaldemo10').modal('show');
                    // Populate modal with data if necessary
                    break;
                default:
                    break;
            }
        });
    }); --}}
</script>

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
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal Select2.min js -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
<!--Internal  pickerjs js -->
<script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

 
<script>

    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var date = button.data('date');
        var total_ht = button.data('total_ht');
        var total_ttc = button.data('total_ttc');
        var nom = button.data('nom');
 
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #date').val(date);
        modal.find('.modal-body #total_ht').val(total_ht);
        modal.find('.modal-body #total_ttc').val(total_ttc);
        modal.find('.modal-body #nom').val(nom);

         
        
       
 
    });
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var numero = button.data('numero')

         var modal = $(this)

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #numero').val(numero);
      })

</script>
 


<script>
     
   
    $('#modaldemo10').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)
        var id = button.data('id')
        var numero = button.data('numero')

        var modal = $(this)

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #numero').val(numero);


        $.ajax({
    url: "{{ URL::to('solde') }}/" + id,
    type: "GET",
    dataType: "json",
    success: function(data) {
        console.log(data);

        // Assurer que l'input est vide avant d'ajouter une nouvelle valeur
        $('input[name="solde"]').val('');
        $.each(data, function(key, value) {
                           // $('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
                      $('input[name="solde"]').val(value);
                      console.log('key : ', key);

                        });
        // Si vous voulez ajouter la première valeur de la réponse JSON à l'input
        if (data.length > 0) {
            var firstKey = Object.keys(data)[0];
            var firstValue = data[firstKey];

            console.log('key : ', firstKey);
            console.log('value : ', firstValue);
            modal.find('.modal-body #solde').val(firstValue);

            $('input[name="solde"]').val(firstValue);
        }
    },
    error: function(xhr, status, error) {
        console.log('Error: ' + error);
    }
});

     


      })
    



</script>
 
 
 
  
<script>
    $(document).ready(function() {
        $('select[name="Section"]').on('change', function() {
            var SectionId = $(this).val();
            console.log(SectionId);
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log('success')
                        $('select[name="product"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });
      });
</script>
 
 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();

</script>
 

<script>

    $(document).ready(function() {

        $('#invoice_number').hide();

        $('input[type="radio"]').click(function() {
            if ($(this).attr('id') == 'type_div') {
                $('#invoice_number').hide();
                $('#type').show();
                $('#start_at').show();
                $('#end_at').show();
            } else {
                $('#invoice_number').show();
                $('#type').hide();
                $('#start_at').hide();
                $('#end_at').hide();
            }
        });
    });

</script>
<script>

function removeParentDiv(element)
       {
        element.parentNode.parentNode.remove();
       }
       <!--Internal  Notify js -->
</script>

 
@endsection
