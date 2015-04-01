/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).bind("mobileinit", function () {
    $.mobile.ajaxEnabled = false;
});


function changeCategory() {
    var list = document.getElementById("list_product");
    if (list != null) {
        var value_list = new Array();
        $("select option:selected").each(function () {
            value_list.push($(this).val());
        });

        console.log(value_list);
        $.post("filtrProduct.php", {value_array: (value_list)}, function (result) {
            $("#list_product").html(result);
            $("#list_product").listview("refresh");
            console.log(result);
        });

    }
}


$("#category").bind("change", function (event, ui) {

    list = document.getElementById("list_product");
    if (list != null) {
        var value_list = new Array();
        $("select option:selected").each(function () {
            value_list.push($(this).val());
        });

        console.log(value_list);
        $.post("filtrProduct.php", {value_array: (value_list)}, function (result) {
            $("#list_product").html(result);
            $("#list_product").listview("refresh");
            console.log(result);
        });

    }
});
                        