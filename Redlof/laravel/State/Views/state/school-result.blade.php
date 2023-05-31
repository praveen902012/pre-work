@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height section-spacing cm-content bg-grey">
	<div class="container" ng-controller="AppController">
		<div class="rte-container text-center">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip">
						<h2>
							{{ googletrans('विद्यालय परिणाम', $_COOKIE['lang']) }} <span>
							{{date("Y")}}-{{date("y")+1}}
						</span>
						</h2>
					</div>
					<h3>
						{{ googletrans('क्रुपया अपनी पंजीकरण U.D.I.S.E. कोड को परिणाम जानने हेतु दर्ज करे', $_COOKIE['lang']) }}
					</h3>
					<div class="search-action-result">
						<form name="student-result" id="student-result" ng-submit="create('{{$state->slug}}/school/registration/result', formData, 'student-result')">
							<div class="row">
								<div class="col-sm-9 col-xs-12">
									<div class="form-group">
										<input type="text" name="" placeholder="Search by UDISE Code" class="form-control" ng-model="formData.udise_code">
									</div>
								</div>
								<div class="col-sm-3 col-xs-12">
									<button ng-disabled="inProcess" type="submit" class="btn-theme pull-right">
										<span ng-if="!inProcess">Search</span>
										<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
									</button>
								</div>
							</div>
						</form>
					</div>
					<div class="heading-strip all-pg-heading ">
						<p>
							The results might take some time to load because of heavy traffic. So, please wait for a while *
						</p>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')