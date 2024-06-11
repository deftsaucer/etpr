$(document).ready(function() {
    $('.btn-order').click(function() {
        var productId = $(this).data('product-id');
        var productName = $(this).data('product-name');
        $('#formOrder').find('#productId').val(productId);
        $('#productName').text(productName);
    });
});