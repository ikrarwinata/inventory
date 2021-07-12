$("#cb-row-parent").change(function(){
    var parent = this;
    $(".cb-row").each(function(){
        this.checked = parent.checked;
        if(parent.checked){
            $(this).closest("tr").removeClass("no-print");
        }else{
            $(this).closest("tr").addClass("no-print");
        }
    })
});

$(".cb-row").change(function(){
    if(this.checked){
        $(this).closest("tr").removeClass("no-print");
    }else{
        $(this).closest("tr").addClass("no-print");
    }
})

$("#bc-print").click(function(e){
    e.preventDefault();

    $(".table-col-barcode").removeClass("no-print");
    $(".table-col-label").removeClass("no-print");
    $(".table-col-judul").removeClass("no-print");
    $("#table-header-barcode").removeClass("no-print");
    $("#table-header-label").removeClass("no-print");
    $("#table-header-judul").removeClass("no-print");

    $(".table-col-label").addClass("no-print");
    $(".table-col-judul").addClass("no-print");
    $("#table-header-label").addClass("no-print");
    $("#table-header-judul").addClass("no-print");
    $("#table-print").print({
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
            title: "Barcode",
            doctype: '<!doctype html>'
    });
});

$("#bcl-print").click(function(e){
    e.preventDefault();

    $(".table-col-barcode").removeClass("no-print");
    $(".table-col-label").removeClass("no-print");
    $(".table-col-judul").removeClass("no-print");
    $("#table-header-barcode").removeClass("no-print");
    $("#table-header-label").removeClass("no-print");
    $("#table-header-judul").removeClass("no-print");

    $(".table-col-judul").addClass("no-print");
    $("#table-header-judul").addClass("no-print");
    $("#table-print").print({
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
            title: "Barcode",
            doctype: '<!doctype html>'
    });
});

$("#l-print").click(function(e){
    e.preventDefault();

    $(".table-col-barcode").removeClass("no-print");
    $(".table-col-label").removeClass("no-print");
    $(".table-col-judul").removeClass("no-print");
    $("#table-header-barcode").removeClass("no-print");
    $("#table-header-label").removeClass("no-print");
    $("#table-header-judul").removeClass("no-print");

    $(".table-col-barcode").addClass("no-print");
    $(".table-col-judul").addClass("no-print");
    $("#table-header-barcode").addClass("no-print");
    $("#table-header-judul").addClass("no-print");
    $("#table-print").print({
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
            title: "Barcode",
            doctype: '<!doctype html>'
    });
});