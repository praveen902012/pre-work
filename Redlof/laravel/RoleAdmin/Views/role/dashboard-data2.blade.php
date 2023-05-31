
		<div class="col-sm-7 col-xs-12">
			<div class="most_visited sm-graph-card">
				Most Visited Pages
				@foreach($data['mvp'] as $item)
				<div class="row">
					<a class="btn btn-link" href="{{$item[0]}}">{{$item[1]}} - {{$item[2]}}</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<div class="top_user sm-graph-card">
				<h6>
					Top 5 active users
				</h6>
				<ol class="">
					@foreach($data['active_users'] as $user)
					<li>
						<a href="">
							<img src="{{$user->photo_thumb}}" class="img-responsive" alt="name">
							<h2>
								{{$user->display_name}}
							</h2>
							<a href="/admin/member/{{$user->id}}">
								<span class="view_p">

									View
								</span>
							</a>
						</a>
					</li>
					@endforeach
				</ol>
			</div>
		</div>
		<div class="col-sm-6 col-xs-12">
			<div class="last_active_app sm-graph-card top_user top_activity">
				<h6>
					Last 5 activities in app
				</h6>

				<ul class="list-unstyled">
					@foreach($data['last_activities'] as $activity)
					<li>
						<a href="">
							<h2>
								{{$activity->user->first_name}} {{$activity->user->last_name}}  {{$activity->activity->display_name}}.
							</h2>
						</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>

