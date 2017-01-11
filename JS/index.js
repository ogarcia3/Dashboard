$(document).ready(function (){
    $("#noti").attr('checked',true);
    $("#year").attr('checked',true);
    display();
    today();
    getProduct(0);
    getWc(0);
});

function today(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#dateInput1').val(today);
    $('#dateInput2').val(today);
}

function validateDate(){
    var dateStart = $("#dateInput1").val();
    var dateEnd = $("#dateInput2").val();
    
    if (dateEnd < dateStart || dateStart > dateEnd){
        alert('Range of date not valid');
        today();
    }
}

function validateWeek(){
    var weekStart = $("#weekStart").val();
    var weekEnd = $("#weekEnd").val();
    var yearStart = $("#yearStart").val();
    var yearEnd = $("#yearEnd").val();
    
    if(parseInt(weekStart,10) > parseInt(weekEnd,10)){
        alert('not valid range');
        $(".week").each(function() { this.selectedIndex = 0; });
    }        
    if(validateYear(yearStart,yearEnd)){
        alert('year range not validate');
        $(".week").each(function() { this.selectedIndex = 0; });
    }
}

function validatePeriod(){
    var periodStart = $("#periodStart").val();
    var periodEnd = $("#periodEnd").val();
    var yearStart = $("#pYearStart").val();
    var yearEnd = $("#pYearEnd").val();
    
    if( parseInt(periodStart,10) > parseInt(periodEnd,10)){
        alert('not valid range');
        $(".period").each(function() { this.selectedIndex = 0; });
    }
    if(validateYear(yearStart,yearEnd)){
        alert('year range not validate');
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
        alert('year range not validate');
        $(".year").each(function() { this.selectedIndex = 0; });
    }
}

function getProduct(id){
    $.ajax({
        type: "post",
        url: "functions.php",
        data: {'id': id}, 
        success: function(data) { $('#products').html(data); }
    });
};

function getWc(id_area){
    $.ajax({
        type: "post",
        url: "functions.php",
        data: {'id_area': id_area}, 
        success: function(data) { $('#wc').html(data); }
    });
};

function display(){
    if ($("#day").is(':checked')){
        $("#datepicker").css({display : "block"});
    }
    else{
        $("#datepicker").css({display : "none"});
    }
      
     if($("#week").is(':checked')){
        $("#semana").css({display: "block"});
     }
     else{
         $("#semana").css({display: "none"});
     }

     if($("#period").is(':checked')){
         $("#periodo").css({display: "block"});
     }
     else{
         $("#periodo").css({display: "none"});
     }

     if($("#year").is(':checked')){
        $("#año").css({display: "block"});
     }
     else{
         $("#año").css({display: "none"});
     }
 }

function page_select(){
    if($("#day").is(':checked')){
        $("#indexForm").prop("action","phpFiles/date.php");
    }
    else if($("#week").is(':checked')){
        $("#indexForm").prop("action","phpFiles/week.php");
    }
    else if($("#period").is(':checked')){
        $("#indexForm").prop("action","phpFiles/period.php");
    }
    else if($("#year").is(':checked')){
        $("#indexForm").prop("action","phpFiles/year.php");
    }
}