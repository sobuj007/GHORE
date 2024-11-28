function copyRow(
    mainBox,
    firstRow,
    rows,
    customFunction = "",
    functionParameter = ""
) {
    // Copy first row
    var copy = $(firstRow).clone();
    // Hide new row
    copy.hide();
    // init row id
    var last_row_id = $(rows).last().attr("id");

    var last_row_number = parseInt(
        last_row_id.match(/^([a-zA-Z]+)(\d+)$/)[2],
        10
    );

    // init row id
    var newID = "row" + (last_row_number + 1);
    // chagne id to new row
    copy.attr("id", newID);

    // insert remove button
    copy.find(".remove_action").append(
        '<button type="button" class="btn btn-danger btn-icon row-delete" title="Remove" data-row="' +
        newID +
        '"><i class="ri-delete-bin-5-line"></i></button>'
    );
    // show new row with animation
    setTimeout(() => {
        copy.slideDown();
    }, 50);
    // re-initial fonticonpicker
    // iconPickerInit('#' + newID + ' select#social-icon-select');
    var selector;
    if (functionParameter) {
        selector = "#" + newID + " " + functionParameter;
    }
    customFunction ? customFunction(selector) : "";
    // appent new row to main box
    $(mainBox).append(copy);
}
// Row Item remove
$(document).on("click", ".row-delete", function (e) {
    e.preventDefault();
    // get row id
    var row = "#" + $(this).data("row");
    // hide and remove row
    $(row).hide("slow", function () {
        $(row).remove();
    });
});

// filepond init
FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageResize,
    FilePondPluginFilePoster
);

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
    },
});

function slugify(str) {
    var $slug = "";
    var trimmed = $.trim(str);
    $slug = str
        .replace(" ", "-")
        .replace(/[^a-z0-9-]/gi, "-")
        .replace(/-+/g, "-")
        .replace(/^-|-$/g, "");
    return $slug.toLowerCase();
}
