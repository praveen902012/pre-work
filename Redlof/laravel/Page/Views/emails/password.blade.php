@include('member::emails.inc-mail-header')

<tr>
	<td>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td style="text-decoration:none;padding: 10px 20px 10px;font-family: Arial;" >
					<h4 style="padding: 10px 15px;">
						Hello,
					</h4>

					<p style="font-size: 14px;font-family: Arial;padding: 0px 15px;line-height: 22px;">
						You are receiving this mail because you chose to reset your password.
						<br><br>
						Click following link to reset your password:
						<a style="font-size: 14px;font-family: Arial;padding: 10px;line-height: 22px;" href="{{ url('password/reset/'.$token) }}">
							Reset Password
						</a>
					</p>
				</td>
			</tr>
		</table>
	</td>
</tr>

@include('member::emails.inc-mail-footer')



