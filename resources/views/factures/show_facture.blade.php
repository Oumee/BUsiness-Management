@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }

    </style>
@endsection
@section('title')
    Téléchargement de facture  
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Les factures</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                     Téléchargement de facture  </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
@php
       
    $date = new \stdClass();
    $date->current = now()->format('Y-m-d'); // Par exemple, la date et l'heure actuelles
  

@endphp
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title"> Facture </h1>
                            <div class="billed-from">
                                <h6>{{ $factures->entreprise->nom }} <img src="{{ asset($factures->entreprise->image) }}" width="50" height="50" class="rounded-circle img-thumbnail"></h6>
                                <p>{{$factures->entreprise->adresse}}<br>
                                    Telephone N°: {{$factures->entreprise->telephone}}<br>
                                    Email: {{$factures->entreprise->email }}</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Facturé à</label>
                                <div class="billed-to">
                                    <h6>{{ $factures->vente->client->nom}} {{ $factures->vente->client->prenom}}</h6>
                                    <p> {{$factures->vente->client->adresse}}<br>
                                        Telephone N°: {{ $factures->vente->client->telephone }}<br>
                                        Email: {{$factures->vente->client->email}}</p>
                                </div>
                            </div>
                            <div class="col-md">
                                 <p class="invoice-info-row"><span> Facture N°</span>
                                    <span>{{ $factures->numero }}</span></p>
                                <p class="invoice-info-row"><span> Date </span>
                                    <span>{{ $date->current}}</span></p>
                                    <p class="invoice-info-row"><span> Date d'échéance  </span>
                                        <span>{{ $factures->date_echeance }}</span></p>
                               
                             </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">Référence</th>
                                        <th class="tx-center">Prix unitaire </th>
                                        <th class="tx-center">Quantite </th>
                                        <th class="tx-center">Prix total </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                       @php
                                           $i =0;
                                       @endphp
                                        @foreach ($transactions as $item)
                                        <tr>     
                                          @php
                                            $i++;
                                          @endphp
                                        <td>{{$i}}</td>
                                        <td class="tx-12">{{ $item->product->designation }}</td>
                                        <td class="tx-center">{{ number_format($item->prix_vente, 2) }}</td>
                                        <td class="tx-center">{{ $item->quantite }}</td>
                                        <td class="tx-center">{{number_format($item->prix_vente*$item->quantite, 2) }}</td>
                                         {{-- @php
                                        $total = $factures->Amount_collection + $invoices->Amount_Commission ;
                                        @endphp --}}
                                        <td class="tx-right">
                                            {{-- {{ number_format($total, 2) }} --}}
                                        </td>
                                    </tr>

                                        @endforeach

                                    <tr>
                                        <td class="valign-middle" colspan="3" rowspan="5">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">#</label>

                                            </div><!-- invoice-notes -->
                                        </td>
                                    
                                            <td class="tx-right tx-uppercase tx-bold tx-inverse">  Total HT   </td>
                                            <td class="tx-right" colspan="2">
                                                <h4 class="tx-right">{{ number_format($factures->vente->total_ht, 2) }}</h4>
                                            </td>
                                         
                                    </tr>
                                    <tr>
                                        <td class="tx-right">Taux taxe ({{ round(($factures->vente->total_ttc/($factures->vente->total_ht)-1)*100)}}%)</td>
                                        <td class="tx-right" colspan="2">{{ round($factures->vente->total_ttc-$factures->vente->total_ht) }} </td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="tx-right">قيمة الخصم</td>
                                        <td class="tx-right" colspan="2"> {{ number_format($invoices->Discount, 2) }}</td> --}}

                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse"> Total TTC </td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">{{ number_format($factures->vente->total_ttc, 2) }}</h4>
                                        </td>
                                    </tr>
                                     
                                    
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">



                        
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


   

@endsection
