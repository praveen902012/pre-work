@include('state::emails.inc-mail-header')

<tr>
	<td>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td style="text-decoration:none;padding: 10px 20px 10px;font-family: Arial;" >
					<h4 style="padding: 10px 15px;font-size: 14px;font-family: Lato;padding: 0px 15px;line-height: 22px;color: #6f7784;"">
						Hello {{$first_name}} {{$middle_name}} {{$last_name}},
					</h4>

					<p style="font-size: 14px;font-family: Lato;padding: 0px 15px;line-height: 22px;color: #6f7784;">
						Your RTE registration number is {{$registration_no}}. Use this number for future reference.
						<br><br>
					</p>
				</td>
			</tr>
		</table>
	</td>
</tr>

@include('state::emails.inc-mail-footer')



