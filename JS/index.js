$(document).ready(function (){
    display(4);
    today();
    getProduct(0);
    getWc(0);

});

function today(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#startDate').val(today);
    $('#endDate').val(today);
}

function validateDate(){
    var dateStart = $("#startDate").val();
    var dateEnd = $("#endDate").val();
    
    if (dateEnd < dateStart || dateStart > dateEnd){
        alert("Range of date not valid");
        today();
    }
}

function validateWeek(){
    var weekStart = $("#weekStart").val();
    var weekEnd = $("#weekEnd").val();
    var yearStart = $("#yearStart").val();
    var yearEnd = $("#yearEnd").val();
    
    if(parseInt(weekStart,10) > parseInt(weekEnd,10)){
        alert("not valid range");
        $(".week").each(function() { this.selectedIndex = 0; });
    }        
    if(validateYear(yearStart,yearEnd)){
        alert("year range not validate");
        $(".week").each(function() { this.selectedIndex = 0; });
    }
}

function validatePeriod(){
    var periodStart = $("#periodStart").val();
    var periodEnd = $("#periodEnd").val();
    var yearStart = $("#pYearStart").val();
    var yearEnd = $("#pYearEnd").val();
    
    if( parseInt(periodStart,10) > parseInt(periodEnd,10)){
        alert("not valid range");
        $(".period").each(function() { this.selectedIndex = 0; });
    }
    if(validateYear(yearStart,yearEnd)){
        alert("year range not validate");
        $(".period").each(function() { this.selectedIndex = 0; });
    }
}

function validateYear(yearStart, yearEnd){
    if(yearStart > yearEnd){
        return true;
    }
}

function sendYear(){
    var yearStart = $("#year1").val();
    var yearEnd = $("#year2").val();
    
    if(validateYear(yearStart,yearEnd)){
        alert("year range not validate");
        $(".year").each(function() { this.selectedIndex = 0; });
    }
}

function getProduct(id){
    $.ajax({
        type: "post",
        url: "functions.php",
        data: {'id': id}, 
        success: function(data) { $("#product").html(data); }
    });
};

function getWc(id_area){
    $.ajax({
        type: "post",
        url: "functions.php",
        data: {'id_area': id_area}, 
        success: function(data) { 
            $("#wc").html(data); 
            $('.selectpicker').selectpicker('refresh');
        }
    });
};


$("#buttons :input").change(function() {
    display($(this).val());
});

function display(num){
    if (num == 1){
        $("input", "#dateRange").each(function(){
            $(this).removeAttr("disabled");
        }); 
        $("#dateRange").show();
    }
    else{
        $("input", "#dateRange").each(function(){
            $(this).attr("disabled", "disabled");
        });
        $("#dateRange").hide();
    }
      
     if(num == 2){ 
        $("select", "#weekRange").each(function(){
            $(this).removeAttr("disabled");
        }); 
        $("#weekRange").show();
     }
     else{
         $("select", "#weekRange").each(function(){
            $(this).attr("disabled", "disabled");
        });
        $("#weekRange").hide();
     }

     if(num == 3){
        $("select", "#periodRange").each(function(){
            $(this).removeAttr("disabled");
        }); 
        $("#periodRange").show();
     }
     else{
         $("select", "#periodRange").each(function(){
            $(this).attr("disabled", "disabled");
        });
        $("#periodRange").hide();
     }

     if(num == 4){
        $("select", "#yearRange").each(function(){
            $(this).removeAttr("disabled");
        }); 
        $("#yearRange").show();
     }
     else{
         $("select", "#yearRange").each(function(){
            $(this).attr("disabled", "disabled");
        });
        $("#yearRange").hide();
     }
 }

