$(document).ready(function (){
    getProduct(0);
    getWc(0);
});
function getProduct(id){
    $.ajax({
        type: "post",
        url: "../functions.php",
        data: {'id': id}, 
        success: function(data) { $('#comboProd').html(data); }
    });
};

function getWc(id){
    $.ajax({
        type: "post",
        url: "../functions.php",
        data: {'id_area': id}, 
        success: function(data) { $('#comboWc').html(data); }
    });
};

$(function (){
    $('form').on('submit',function (e){
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: "post.php",
            data: $('form').serialize(),
            success: function (){
                alert('form was submitted');
            }
        });
    });
});