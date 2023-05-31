@include('page::emails.inc-mail-header')

<tr>
	<td>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td style="text-decoration:none;padding: 10px 20px 10px;font-family: Arial;" >
					<h4 style="padding: 10px 15px;">
						Hello {{$first_name}},
					</h4>

					<p style="font-size: 14px;font-family: Arial;padding: 0px 15px;line-height: 22px;">
						You are receiving this mail because you chose to reset your password.
						<br><br>
						New password: {{$password}} 
					</p>
				</td>
			</tr>
		</table>
	</td>
</tr>

@include('page::emails.inc-mail-footer')



