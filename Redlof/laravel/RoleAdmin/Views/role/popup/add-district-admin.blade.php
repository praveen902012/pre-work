<section class="form-popup" ng-controller="AppController">
  <div style="background-color: white!important;color:black !important;" class="header">
    <h2>
      Add District Administrator
    </h2>
  </div>
  <div class="body" ng-init="formData={}">
    <form name="admin-add-city" class="common-form add-area" ng-submit="create('admin/district/admin/add', formData, 'admin-add-city')">

      <div class="form-group" class="col-sm-6">
        <label>First Name</label>
        <div>
          <input validator="required" valid-method="blur" ng-model="formData.first_name" type="text" class="form-control" id="first_name" placeholder="Enter your first name" required>
        </div>
      </div>

      <div class="form-group" class="col-sm-6">
        <label>Last Name</label>
        <div>
          <input validator="required" valid-method="blur" ng-model="formData.last_name" type="text" class="form-control" id="last_name" placeholder="Enter your last name" required>
        </div>
      </div>

      <div class="form-group" class="col-sm-6">
        <label>Email address</label>
        <div>
          <input validator="required" valid-method="blur" ng-model="formData.email" type="email" class="form-control" id="email" placeholder="Enter email" required>
        </div>
      </div>

      <div class="form-group" class="col-sm-9">
        <label>Phone</label>
        <div>
          <input ng-model="formData.phone" type="tel" class="form-control" id="phone" required placeholder="Enter phone number(s)">
        </div>
      </div>

      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</section>