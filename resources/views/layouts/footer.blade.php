
<footer class="footer footer-default mt-0">
    <div class="d-flex justify-content-between bd-highlight copyright">
        <div class="bd-highlight">
            <a href="{{route('mentionslegales')}}" title="{{__('messages.mentionslegales')}}"><i class="fas fa-balance-scale"></i></a>
        </div>
        {{--<div class="bd-highlight">--}}
            {{--<a href="{{route('aide')}}" title="{{__('messages.aide')}}"><i class="fas fa-question"></i></a>--}}
        {{--</div>--}}
		
		
		
		
		<select class="selectpicker" data-width="fit">
			<option>> Choose your language</option>
				<option data-url="{{url('locale/de')}}" data-content='Deutsch'>Deutsch</option>
				<option data-url="{{url('locale/en')}}" data-content='English'>English</option>
				<option data-url="{{url('locale/es')}}" data-content='Español'>Español</option>
				<option data-url="{{url('locale/fr')}}" data-content='Français'>Français</option>
				<option data-url="{{url('locale/jp')}}" data-content='日本語'>日本語</option>

     
		</select>
				


        <div class="bd-highlight">
            <a href="https://www.cestpasdujdr.fr" target="_blank" title="{{__('messages.propulse')}}"><i class="fas fa-heart"></i></a>
        </div>
    </div>
</footer>


</body>
<!--   Core JS Files   -->
{{--<script src="{{asset('assets/js/core/jquery.min.js')}}" type="text/javascript"></script>--}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('js/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('js/freelancer.js')}}"></script>
<script src="{{asset('js/jquery.touchSwipe.min.js')}}"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="{{asset('js/vendor/sweetalert2.min.js')}}"></script>
@stack('scripts')
@yield('footer_scripts')

<script>
$(function(){
    
	$('.selectpicker').on('change', function(){
		var url = $(this).find(':selected').data('url');
		window.location = url;
	});
});
</script>

</html>