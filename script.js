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
    $("#image").attr("src",result);
    $("#publish").show();
}
function errorFn(xhr, status, statusErr){
    console.log(xhr + "\n" + status + "\n" + statusErr);
}

$("#publish").on("click",function(){
    $.ajax({
        url: "publish.php?photo="+$("#image").attr("src"),
        dataType: "text",
        success: function(result){
            console.log(result);
        },
        error: function(xhr, status, statusErr){
            console.log(xhr + "\n" + status + "\n" + statusErr);
        },
        complete: function(xhr,status){
            //completed;
        }

    });
});
/*   
function successFn(result){
if(result == "Success"){
$.ajax({
//another ajax call for image load
url: 'imagemaker.php',
type: 'POST',
dataType: 'text',
success: function(result){
if(isNaN(result)){
$("#image").attr("src",result);
$("#image").load(function(){
$("#publish").show().text("Publish on my wall");
});
} else{
errorFn(result,"status","StatusErr");
}
},
error: errorFn,
complete: function(xhr,status){
// i again have nothing to do with this, 
// because i've actually nothing to do :D :p
}
});
} else if(result == "Homo"){
$("#image").attr("src","images/homo.png");
$("#publish").show().text("Publish on my wall");
} else{
$("#image").attr("src","images/error.png");
$("#publish").show().prop("disabled",true).text("Error Occured");
}
}

function errorFn(xhr, status, statusErr){
$("#image").attr("src","images/error.png");
$("#publish").show().prop("disabled",true).text("Error Occured");
console.log(xhr+"\n"+status+"\n"+statusErr);
}


$("#publish").click(function(){
alert("ok");
});
*/
/*$("#publish").on("click",function(){
$.ajax({
url: 'publish.php',
dataType: 'text',
type: "post",
success: pubSuc,
error: pubErr,
complete: function(){
// i've got nothing to do here;
}
})
});
function pubSuc(result){
if(result == "yes"){
$("#publish").text("Published on your wall").prop("disabled",true);
}
else if( result == 'no'){
$("#publish").text("Error Occured").prop("disabled",true);
$("#image").attr("src","images/error.png");
}
}
function pubErr(xhr,stt,stterr){
$("#publish").text("Error Occured").prop("disabled",true);
$("#image").attr("src","images/error.png");
}
var i = 0 ;
$("#image").load(function(){
++i;
if(i==1){
$.ajax({
url: "getid.php",
type: "POST",
dataType: "text",
success: successFn,
error: errorFn,
complete: function(xhr, status){
//;
}
})
}
});
function successFn(res){
if(res=="Success"){
$("#image").attr("src","imagemaker.php");
$("#publish").show();

} else if(res == "Homo"){
$("#image").attr("src","images/homo.png");
$("#show").prop("disabled",false).text("Publish").attr("id","publish");
} else if(res == "Refresh page"){
history.go(0)
} else{
errorFn("error","fbapi","fberr");
}
}
function errorFn (xhr, status, sttsErr){
$("#image").attr("src","images/error.png");
$("#publish").text("Error Occured").prop("disabled",true);
}*/