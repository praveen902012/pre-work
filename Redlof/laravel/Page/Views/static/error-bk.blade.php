@include('page::includes.head')
@include('page::includes.header')
<section class="page-404 body-spacing">
    <div class="container">
        <div class="err-page-content">
            <img src="{!! asset('img/William_Arthur_Ward.jpg') !!}" alt="Willian Arthur Ward" class="img-responsive center-block">
            <div class="quote-holder">
                <p>
                    Our servers are not accepting the request made by you.<br>
                    Possible cause: {{ isset($error['message']) ? $error['message'] : "" }}
                </p>
            </div>
            <div class="err-msg-holder">
                <p>
                    Something went wrong.
                </p>
                <a href="{{ url('') }}" class="btn btn-rounded">Go Home</a>
            </div>
        </div>
    </div>
</section>
@include('page::includes.footer')
@include('page::includes.foot')