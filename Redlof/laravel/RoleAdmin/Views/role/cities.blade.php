@extends('admin::includes.layout')
@section('content')
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="label-admin">
					<h4>
						Cities
					</h4>
					<span class="pull-right">
						<button class="btn btn-default btn-xs" ng-click="openPopup('admin', 'role', 'add-city', 'create-popup-style')">
							Add
						</button>
					</span>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
