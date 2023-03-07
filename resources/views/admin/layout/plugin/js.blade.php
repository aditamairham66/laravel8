<!--begin::Javascript-->
<script>const hostUrl = "{{ asset('metro/assets') }}";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('metro/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('metro/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/plugins/custom/price-format/jquery.price_format.2.0.min.js') }}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('metro/assets/js/widgets.bundle.js') }}"></script>

<script>
    const ASSET_URL = "{{ asset('/')}}";
    const APP_NAME = "{{ env('APP_NAME')}}";
    const ADMIN_PATH = '{{ adminRoute('') }}';
    const NOTIFICATION_JSON = "{{ adminRoute('notifications/latest-json') }}";
    const NOTIFICATION_INDEX = "{{ adminRoute('notifications') }}";

    const NOTIFICATION_YOU_HAVE = "You Have";
    const NOTIFICATION_NOTIFICATIONS = "Notifications";
    const NOTIFICATION_NEW = "You have a new notification !";
</script>

<script src="{{ asset('metro/assets/js/notification/notif.js') }}"></script>
