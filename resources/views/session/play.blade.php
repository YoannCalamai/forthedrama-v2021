@extends('bootstrap')
@section('content')
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">



                <h3 class="text-white" id="code-room">{{ $code_room }}</h3>
                <input type="hidden" name="carte_active" id="carte_active" value="{{ $carte_active }}">
                <div class="card card-nav-tabs instruction d-flex ">

                    <div class="card-body text-center align-items-center d-flex ">
                        @if( $carte_active == -1)
                            <p> {{__('messages.playtexte1')}}
                             {{__('messages.playtexte2')}}
                            <strong> {{ $code_room }}</strong>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between bd-highlight copyright">
                    <div class="p-2 bd-highlight">
                        <button class="btn btn-danger mr-2" id="previous" style="display:none" title="{{__('messages.precedent')}}"> <i class="fas fa-arrow-left"></i> </button>
                    </div>
                    <div class="p-2 bd-highlight">
                        <button class="btn btn-default mt-0" id="xcard" title="{{__('messages.cartex')}}"> <i class="fas fa-times"></i> </button>
                    </div>
                    <div class="p-2 bd-highlight">
                        <button class="btn btn-primary ml-2" id="next" title="{{__('messages.suivant')}}">  <i class="fas fa-arrow-right"></i> </button>
                    </div>
                </div>


            </div>
        </header>



    @push('scripts')
        <script>
            // $(function() {
            //     $(".main-container").swipe( {
            //         swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            //             if( direction == "left" ){
            //                 tirerCarte();
            //             }
            //             if( direction == "right" ){
            //                 retourCarte();
            //             }
            //             if( direction == null ){
            //                 event.preventDefault();
            //                 event.stopPropagation();
            //             }
            //         },
            //         threshold:0,
            //         excludedElements: "label, button, input, select, textarea"
            //     });
            // });


            $(document).keydown(function(e) {
                switch(e.which) {
                    case 37: // left
                        if($("#previous").is(":visible")){
                            retourCarte();
                        }
                        break;

                    case 38: // up
                        break;

                    case 39: // right
                        if($("#next").is(":visible")){
                            tirerCarte();
                        }
                        break;

                    case 40: // down
                        xcard();
                        break;

                    default: return; // exit this handler for other keys
                }
                e.preventDefault(); // prevent the default action (scroll / move caret)
            });

            $(document).ready(function(){
                tirerCarteSansIncrement();
                $("#next").click(function(){
                    tirerCarte();
                });
                $("#previous").click(function(){
                    retourCarte();
                });

                $("#xcard").click(function(){
                    xcard();
                });

            });

            function xcard(){
                $( ".card" ).effect( "shake" );
                $.ajax({
                    type: "POST",
                    url: '{{route('xcard')}}',
                    data: {
                        id_session: '{{ $id_session }}',
                        code_room: '{{ $code_room }}',
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {

                    },
                    error: function (jqXHR, exception) {

                    }
                });
            }

            function tirerCarte(element){
                var carte_active = $('#carte_active').val();
                $.ajax({
                    type: "POST",
                    url: '{{route('distribue')}}',
                    data: {
                        id_session: '{{ $id_session }}',
                        code_room: '{{ $code_room }}',
                        carte_active: carte_active,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {

                        // factoriser tout le code ci-dessous
                        if(res.carte){
                            $('#carte_active').val( res.carte_active );
                            $('.card-body').html ( '<p>' + res.carte + '</p>');

                            if( res.carte_active != -1 ){
                                $('#previous').show();
                            }else{
                                $('#previous').hide();
                            }

                            if( res.carte_finale == 1){
                                $('#next').hide();
                                $('.card-body').html ( '<h3><?php trans('messages.cartefinale'); ?></h3><p>' + res.carte + '</p>');
                            }else{
                                $('#next').show();
                            }

                            if( res.carte_type.toLowerCase() == 'instruction' ){
                                $('.card').addClass('instruction');
                                $('.card').removeClass('finale');
                                $('.card').removeClass('question');
                            }
                            if( res.carte_type.toLowerCase() == 'question' ){
                                $('.card').removeClass('instruction');
                                $('.card').removeClass('finale');
                                $('.card').addClass('question');
                            }
                            if( res.carte_type.toLowerCase() == 'finale' ){
                                $('.card').removeClass('question');
                                $('.card').removeClass('instruction');
                                $('.card').addClass('finale');
                            }

                        }else{
                        }
                    },
                    error: function (jqXHR, exception) {

                    }
                });
            }
            function tirerCarteSansIncrement(element){
                var carte_active = $('#carte_active').val();
                $.ajax({
                    type: "POST",
                    url: '{{route('distribueSansIncrement')}}',
                    data: {
                        id_session: '{{ $id_session }}',
                        code_room: '{{ $code_room }}',
                        carte_active: carte_active,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        // factoriser tout le code ci-dessous
                        if(res.carte){
                            $('#carte_active').val( res.carte_active );
                            $('.card-body').html ( '<p>' + res.carte + '</p>');
                            if( res.carte_active != 0 ){
                                $('#previous').show();
                            }else{
                                $('#previous').hide();
                            }
                            if( res.carte_finale == 1){
                                $('#next').hide();
                                $('.card-body').html ( '<h3><?php trans('messages.cartefinale'); ?></h3><p>' + res.carte + '</p>');
                            }else{
                                $('#next').show();
                            }


                            if( res.carte_type.toLowerCase() == 'instruction' ){
                                $('.card').addClass('instruction');
                                $('.card').removeClass('finale');
                                $('.card').removeClass('question');
                            }
                            if( res.carte_type.toLowerCase()  == 'question' ){
                                $('.card').removeClass('instruction');
                                $('.card').removeClass('finale');
                                $('.card').addClass('question');
                            }
                            if( res.carte_type.toLowerCase()  == 'finale' ){
                                $('.card').removeClass('question');
                                $('.card').removeClass('instruction');
                                $('.card').addClass('finale');
                            }
                        }
                    },
                    error: function (jqXHR, exception) {

                    }
                });
            }
            function retourCarte(element){
                var carte_active = $('#carte_active').val();
                $.ajax({
                    type: "POST",
                    url: '{{route('retourCarte')}}',
                    data: {
                        id_session: '{{ $id_session }}',
                        code_room: '{{ $code_room }}',
                        carte_active: carte_active,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        // factoriser tout le code ci-dessous
                        if(res.carte){
                            $('#carte_active').val( res.carte_active );
                            $('.card-body').html ( '<p>' + res.carte + '</p>');
                            if( res.carte_active == 0){
                                $('#previous').hide();
                            }else{
                                $('#previous').show();
                            }

                            $('#next').show();

                            if( res.carte_type.toLowerCase()  == 'instruction' ){
                                $('.card').addClass('instruction');
                                $('.card').removeClass('finale');
                                $('.card').removeClass('question');
                            }
                            if( res.carte_type.toLowerCase()  == 'question' ){
                                $('.card').removeClass('instruction');
                                $('.card').removeClass('finale');
                                $('.card').addClass('question');
                            }
                            if( res.carte_type.toLowerCase()  == 'finale' ){
                                $('.card').removeClass('question');
                                $('.card').removeClass('instruction');
                                $('.card').addClass('finale');
                            }
                        }else{
                        }
                    },
                    error: function (jqXHR, exception) {

                    }
                });
            }
        </script>


        @if( isset( $code_room )  )
            <script>
                // Enable pusher logging - don't include this in production
                // Pusher.logToConsole = true;

                var pusher = new Pusher('1e1141b22179b33d00be', {
                    cluster: 'eu',
                    forceTLS: true
                });

                var channel = pusher.subscribe('channel-{{ $code_room }}');
                channel.bind('distribue_carte', function(data) {
                    afficheNouvelleCarte( data );
                });
                channel.bind('xcard', function(data) {
                    $( ".card" ).effect( "shake" );
                });

                function afficheNouvelleCarte( carte ){


                    $('#carte_active').val( carte.carte_active );
                    $('.card-body').html ( '<p>' + carte.carte + '</p>');

                    if( carte.carte_finale == 1){
                        $('#next').hide();
                        $('.card-body').html ( '<h3><?php trans('messages.cartefinale'); ?></h3><p>' + carte.carte + '</p>');
                    }else{
                        $('#next').show();
                    }


                    if( carte.carte_type.toLowerCase()  == 'instruction' ){
                        $('.card').removeClass('question');
                        $('.card').removeClass('finale');
                        $('.card').addClass('instruction');
                    }
                    if( carte.carte_type.toLowerCase()  == 'question' ){
                        $('.card').removeClass('instruction');
                        $('.card').removeClass('finale');
                        $('.card').addClass('question');
                    }
                    if( carte.carte_type.toLowerCase()  == 'finale' ){
                        $('.card').removeClass('question');
                        $('.card').removeClass('instruction');
                        $('.card').addClass('finale');
                    }

                }

            </script>
        @endif


    @endpush

@endsection

