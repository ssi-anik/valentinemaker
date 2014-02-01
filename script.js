/*
* Script by : Syed Sirajul Islam Anik
* Script written for: Valentine maker facebook web app
* Copyright holds: Syed Sirajul Islam Anik.
* Feel Free to ask before you use.
*/

$("#image").load(function(){
    $.ajax({
        // this is called whenever the image loader.gif is loaded. else huh. using slow internet. :)
        url: 'getid.php',
        type: 'POST',
        dataType: 'text',
        success: successFn,
        error: errorFn,
        complete: function(xhr,status){
            // what happens? i'll always be executed ! :/
        }
    })
});

function successFn(result){
    if(result != "refresh page"){
        $("#image").attr("src",result);
        $("#publish").show();
    }
}
function errorFn(xhr, status, statusErr){
    console.log(xhr + "\n" + status + "\n" + statusErr);
}

$("#publish").on("click",function(){
    $.ajax({
        url: "publish.php?photo="+$("#image").attr("src"),
        dataType: "text",
        type: "GET",
        success: function(result){
            if(result == "ok"){
                $("#publish").text("Published").prop("disabled",true);
            }
        },
        error: function(xhr, status, statusErr){
            console.log(xhr + "\n" + status + "\n" + statusErr);
        },
        complete: function(xhr,status){
            //completed;
        }

    });
});

