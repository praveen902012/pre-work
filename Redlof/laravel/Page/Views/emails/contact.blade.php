@include('page::emails.inc-mail-header')

<p style="margin: 35px">
	Hi Admin,
</p>

<p style="margin: 35px">
	There is an inquiry request for you. Please find the details below: <br><br>
	Name : {!! $name !!} <br>
	Email : {!! $email !!} <br>
	Message : {!! $usermessage !!} <br>
</p>

<p style="margin:35px">
	Thanks &amp; Regards,<br>
	Team {!! config('redlof.name')!!}
</p>



