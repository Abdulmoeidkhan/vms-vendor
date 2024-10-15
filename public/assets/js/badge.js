$('.barcode-list').each(function (index, item) {

    $(item).barcode(
        $(item).attr("custom-id"),
        "code128",
        {
            showHRI: false,
            barWidth: 2,
            barHeight: 30,
        }
    );
})

