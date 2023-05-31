<section class="form-popup" ng-controller="AppController">
	<div class="header">
		<h2>
		Add Degree
		</h2>
	</div>
	<div class="body">
		<form name="add-country" class="common-form add-area" ng-submit="create('admin/degree/add', formData, 'add-country')">
			<div class="form-group">
				<label>
					Name:
				</label>
				<input validator="required" valid-method="blur" type="text" " name="name" ng-model="formData.name" ng-required="true" class="form-control">
			</div>
			<button type="submit" class="btn  btn-success">Submit</button>
		</form>
	</div>
</section>