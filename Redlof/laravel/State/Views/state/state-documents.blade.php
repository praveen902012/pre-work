@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h3 class="doc-head">राज्य परियोजना विभाग से RTE 12(1)(c) सत्र 2020-2021 पर आदेश</h3>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row doc-row">
            @forelse($documents as $document)
                <div class="col-sm-3 col-xs-12" style="margin: 20px;">
                    <a  target="_blank" href="{{$document->fmt_doc}}">
                        <div class="hm-card bg-hm-theme ">
                            <div class="heading-header">
                                <h4>
                                    {{ str_limit($document->title,20) }}
                                </h4>
                                {{-- <a ng-click="openPopup('stateadmin/documents/update/{{$document->id}}')" class="btn btn-primary doc-edit-btn" ><i class="fa fa-edit"></i></a> --}}
                                {{-- <a ng-click="create('stateadmin/uploaded/document/delete/{{$document->id}}')" class="btn btn-danger doc-del-btn" ><i class="fa fa-trash"></i></a> --}}
                            </div>
                            <div class="embed-responsive embed-responsive-16by9 text-center">
                                <img src="{{$document->fmt_doc_image}}" class="img-responsive">
                            </div>
                        </div>
                    </a>    
                </div>
            @empty
                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 ">
                    <div class="alert alert-dark" role="alert" style="border: 1px solid gainsboro;">
                        No Documents Added Yet
                    </div>
                </div>
            @endforelse
 		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')