@include('page::includes.head')
@include('page::includes.header-static')
<section class="bg-lt-blue body-spacing">
    <div class="container">
        <div class="static-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="">
                        <h2>
                            About Us
                        </h2>
                        <div class="content-static">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras posuere rhoncus est quis blandit. Mauris sit amet sapien a eros sollicitudin pharetra. Integer lorem ex, pulvinar in suscipit vitae, auctor et quam. Aliquam consectetur congue tortor, condimentum fringilla magna finibus eleifend.
                            </p>
                        </div>
                        <div class="content-static">
                            <p>
                                Ut tempor lectus et ligula aliquam condimentum. Sed porta sem leo, ac faucibus risus aliquet pulvinar. Ut sit amet commodo dui. Donec nunc orci, dignissim non scelerisque quis, condimentum at mi. Curabitur bibendum ornare blandit. Ut eget magna dapibus, laoreet neque vel, volutpat nunc.
                            </p>
                        </div>
                    </div>
                    <div class="content-static">
                        <p>
                            Donec aliquam ipsum mauris, eget luctus nisi faucibus tempor. Praesent quis luctus eros, nec ultrices odio. Vestibulum porttitor auctor felis at elementum. Nam vestibulum, eros vel sagittis euismod, eros ante cursus lectus, eu sollicitudin purus orci sed massa. In hac habitasse platea dictumst.
                        </p>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

@if(\AuthHelper::isSignedInWithCookie())
@include('page::includes.footer-static')
@else
@include('page::includes.footer')
@endif

@include('page::includes.foot')