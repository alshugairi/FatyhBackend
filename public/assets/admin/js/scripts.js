$(document).ready(function() {

    $('#filterForm').submit(function (e){
        e.preventDefault();
        dataTable.ajax.reload();
        $('#filterSidebar').removeClass('open');
    });
    $('#filterBtn').on('click', function() {
        $('#filterSidebar').addClass('open');
    });

    $('#closeSidebar').on('click', function() {
        $('#filterSidebar').removeClass('open');
    });

    $('.page-name').first().keypress(function(e) {
        if (e.which == 32) {
            e.preventDefault();
            let currentValue = $(this).val();
            $(this).val(currentValue + '-');

            $('.slug-input').val($(this).val().toLowerCase());
            $('.slug-preview').text($(this).val().toLowerCase());
        }
    });

    $('.page-name').first().on('input', function() {
        let text = $(this).val().toLowerCase();
        $('.slug-input').val(text);
        $('.slug-preview').text(text);
    });

    $('.slug-input').keypress(function(e) {
        if (e.which == 32) {
            e.preventDefault();
            let currentValue = $(this).val();
            $(this).val(currentValue + '-');
            $('.slug-preview').text($(this).val());
        }
    });

});
function slugify(text) {
    return text
        .toLowerCase()
        .replace(/[^\w\s-]+/g, '')    // Remove non-word chars except spaces and hyphens
        .replace(/--+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')           // Trim - from start
        .replace(/-+$/, '');          // Trim - from end
}
