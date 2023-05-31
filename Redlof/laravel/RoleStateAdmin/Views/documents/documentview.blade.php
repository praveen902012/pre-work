@extends('stateadmin::includes.layout')
@section('content')

<section ng-controller="AppController">

   <div class="container">
        <div class="row">
            <a class="btn btn-info" ng-click="openPopup('stateadmin', 'documents', 'documentadd', 'create-popup-style')"> Add Document </a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @forelse($documents as $document)
                <div class="col-sm-3 col-xs-12" style="margin: 20px;">
                    <a  target="_blank" href="{{$document->fmt_doc}}">
                        <div class="hm-card bg-hm-theme ">
                            <div class="heading-header">
                                <h4>
                                    {{ str_limit($document->title,20) }}
                                </h4>
                                {{-- <a ng-click="openPopup('stateadmin/documents/update/{{$document->id}}')" class="btn btn-primary doc-edit-btn" ><i class="fa fa-edit"></i></a> --}}
                                <a ng-click="create('stateadmin/uploaded/document/delete/{{$document->id}}')" class="btn btn-danger doc-del-btn" ><i class="fa fa-trash"></i></a>
                            </div>
                            <div class="embed-responsive embed-responsive-16by9 text-center">
                                <img src="{{$document->fmt_doc_image}}" class="img-responsive">
                            </div>
                        </div>
                    </a>    
                </div>
            @empty
                <div class="col-sm-6 col-xs-12 offset-3" style="margin: 20px;">
                    <div class="hm-card bg-hm-theme ">
                        <div class="heading-header">
                            <h4 class="text-center">
                                No Documents Added Yet
                            </h4>
                        </div>
                    </div>
                </div>
            @endforelse
           
        </div>
    <div>
</section>


@endsection