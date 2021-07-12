$("#print_js").click(function(e){
    $(".x_content").print({
            globalStyles: true,
            mediaPrint: true,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 7500,
            title: "Invoice",
            doctype: '<!doctype html>'
    });
});

$("#plc-offset").change(function(e){
    $("#table-signature").css("margin-top", $(this).val() + "px")
});