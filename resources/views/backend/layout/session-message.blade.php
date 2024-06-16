@if ($message = Session::get('success'))
    @push('scripts')
        <script src="{{ asset( 'js/vendor/toastr.min.js') }}"></script>
        <script>
            $(function() {
                toastr.success("{{ $message }}", "Succès !", {
                    timeOut: "3000", closeButton: !0
                });
            });
        </script>
    @endpush
@endif
@if ($message = Session::get('info'))
    @push('scripts')
        <script src="{{ asset( 'js/vendor/toastr.min.js') }}"></script>
        <script>
            $(function() {
                toastr.info("{{ $message }}", "Information", {
                    timeOut: "10000", closeButton: !0
                });
            });
        </script>
    @endpush
@endif
@if ($message = Session::get('warning'))
    @push('scripts')
        <script src="{{ asset( 'js/vendor/toastr.min.js') }}"></script>
        <script>
            $(function() {
                toastr.warning("{{ $message }}", "Attention !", {
                    timeOut: "5000", closeButton: !0
                });
            });
        </script>
    @endpush
@endif
@if ($message = Session::get('error'))
    @push('scripts')
        <script src="{{ asset( 'js/vendor/toastr.min.js') }}"></script>
        <script>
            $(function() {
                toastr.error("{{ $message }}", "Erreur !", {
                    timeOut: "5000", closeButton: !0
                });
            });
        </script>
    @endpush
@endif