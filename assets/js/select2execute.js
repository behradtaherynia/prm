jQuery(document).ready(function ($) {
    if ($('select').length > 0) {
        $('select').select2({
            placeholder: "موردی انتخاب کنید...",
            allowClear: true
        });
    }
});

// $(document).ready(function() {
//     $('#select2_service_client').select2({
//         placeholder: "موردی را انتخاب کنید",
//         // allowClear: true
//     });
// });