<section class="pagination-block">
	<div class="row" ng-cloak>
		<div class="col-sm-3 col-xs-12">
			<form class="static-form search-filter">
				<div class="form-group form-field">
					<input ng-model="keyword" search-icon input-enter="List.search(keyword)" type="text" class="form-control theme-blur-focus clearable" placeholder="Search here" table-list-search="[[List.ListName]]">
				</div>
			</form>
		</div>
		<div class="col-sm-7 col-xs-12">
			<div class="prev-next pagination-custom">
				<table class="table">
					<td class="no-border">
						<span class="span-cls">
							Page [[List.ListService.currentPage]] of [[List.ListService.totalPage]]
						</span>
					</td>
					<td class="no-border">
						<ul class="list-unstyled list-inline text-left" ng-class="{ 'hide-pagination': !List.ListService.pagination }">
							<li>
								<a href="" ng-click="List.prevPage()" class="next-prev-link">
									<i class="fa fa-chevron-left" aria-hidden="true"></i>
									<span>
										Prev [[List.ListService.pagesize]]
									</span>
								</a>
							</li>
							<li>
								<a href="" ng-click="List.nextPage()" class="next-prev-link">
									<span>
										Next [[List.ListService.pagesize]]
									</span>
									<i class="fa fa-chevron-right" aria-hidden="true"></i>
								</a>
							</li>
						</ul>
					</td>
				</table>
			</div>
		</div>
	</div>
</section>