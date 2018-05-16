$(document).ready(function() {
    
$.preload( 'http://localhost/konderbetyar/includes/css/img/apper.png',
           'http://localhost/konderbetyar/includes/css/img/soup.png',
           'http://localhost/konderbetyar/includes/css/img/main.png',
           'http://localhost/konderbetyar/includes/css/img/dess.png',
           'http://localhost/konderbetyar/includes/css/img/sal.png',
           'http://localhost/konderbetyar/includes/css/img/basic.png'
);

//--------------------- RECIPE UPLOAD ---------------------------- //

/*
$(document.body).on("submit", "#recUp", function(event){
        //event.preventDefault();

        var formData = $(this).serialize();
        
        $.ajax({
            contentType: "multipart/form-data",
            url: "http://localhost/konderbetyar/rec_up_mod.php",
            type: "POST",
            data: formData,
            
            success: function (returndata) {
               // alert(returndata);
               console.log(formData);
            }
        });
 
        return false;
    });
    
    
    5ad71ccbea16e447462909b1538e79e274678ecb29b99
    
    
    
*/




//------------IMG HOVER--------------//

$("#apper").hover(function(){
    $('#wrapper')
    .animate({opacity: 0}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/apper.png)'})
            .animate({opacity: 1});
    });
//hover out
},function(){
    $('#wrapper')
    .animate({opacity: 1}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/apper.png)'})
            .animate({opacity: 0});
    });
});

$("#soup").hover(function(){
    $('#wrapper')
    .animate({opacity: 0}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/soup.png)'})
            .animate({opacity: 1});
    });
//hover out
},function(){
    $('#wrapper')
    .animate({opacity: 1}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/soup.png)'})
            .animate({opacity: 0});
    });
});

$("#main").hover(function(){
    $('#wrapper')
    .animate({opacity: 0}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/main.png)'})
            .animate({opacity: 1});
    });
//hover out
},function(){
    $('#wrapper')
    .animate({opacity: 1}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/main.png)'})
            .animate({opacity: 0});
    });
});

$("#dess").hover(function(){
    $('#wrapper')
    .animate({opacity: 0}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/dess.png)'})
            .animate({opacity: 1});
    });
//hover out
},function(){
    $('#wrapper')
    .animate({opacity: 1}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/dess.png)'})
            .animate({opacity: 0});
    });
});

$("#sal").hover(function(){
    $('#wrapper')
    .animate({opacity: 0}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/sal.png)'})
            .animate({opacity: 1});
    });
//hover out
},function(){
    $('#wrapper')
    .animate({opacity: 1}, 'fast', function() {
        $(this)
            .css({'background-image': 'url(http://localhost/konderbetyar/includes/css/img/sal.png)'})
            .animate({opacity: 0});
    });
});



// ------------------LINK PREW---------------//

//var recLink;
/*
$( "#mentes" ).on( "click", function(event) {
        event.preventDefault(event);
        //recLink = $(this).val();
        $.ajax({
            url: "https://api.linkpreview.net?key=5ad71ccbea16e447462909b1538e79e274678ecb29b99&q=http://www.mindmegette.hu/kfc-csirke-hazilag.recept/",
            success: function(result){
            console.log(result);
    }, error: function (result) {
        alert("NEM OK");
    }
});
    });

*/
// -------- NAV INDEX REC CAT ----------------------//

var catId;
var subId;

$( ".btnCat" ).on( "click", function(event) {
        event.preventDefault();
        catId = $(this).val();
        
        $('header').animate({'height': '300px'}, 'slow' );
        $('#wrapper').animate({'height': '300px'}, 'slow' );
        $.ajax({
            type        : 'GET',
            url         : "http://localhost/konderbetyar/pub_rec.php?CatId=" + catId,
            success: function (data) {
                $('#dinamic').css("display", "block");
                $( "#dinamic" ).empty();
                $( "#dinamic" ).append(data);
            },
            error: function (data){
                alert("NEM OK");
            }
        });
    });
    
//------------------NAV INDEX OWN REC --------------//

var user;

$( "#recOwn" ).on( "click", function(event) {
        event.preventDefault();
        user = $(this).val();
        
        $('header').animate({'height': '300px'}, 'slow' );
        $('#wrapper').animate({'height': '300px'}, 'slow' );
        $.ajax({
            type        : 'GET',
            url         : "http://localhost/konderbetyar/rec_own.php?user=" + user,
            success: function (data) {
                $('#dinamic').css("display", "block");
                $( "#dinamic" ).empty();
                $( "#dinamic" ).append(data);
            },
            error: function (data){
                alert("NEM OK");
            }
        });
    });

var catIdOwn;
$(document.body).on('click', '.btnCatOwn', function() {
    event.preventDefault();
    catIdOwn = $(this).val();
        $.ajax({
            type        : 'GET',
            url         : "http://localhost/konderbetyar/rec_own.php?CatIdOwn=" + catIdOwn,
            success: function (data) {
                //$('#dinamic').css("display", "block");
                $( "#dinamic" ).empty();
                $( "#dinamic" ).append(data);
            },
            error: function (data){
                alert("NEM OK");
            }
        });
    });

//---------------SUBCAT CHECK REC OWN----------------------------//
    
    $(document.body).on('change', '.catcheck', function(){
        subId = $(this).val();
        if (this.checked) {
            $( ".catcheck" ).each(function() {
                var tmp = $(this).val();
                if (tmp !== subId){
                    $(this).removeAttr("checked");
                }
            });
            //checked
            $.ajax({
                type: 'GET',
                url: "http://localhost/konderbetyar/rec_own.php?subId=" + subId + "&CatId=" + catId,
                success: function (data) {
                    $( "#dinamic" ).empty();
                    $( "#dinamic" ).append(data);
                }
            });
            //return;
        }
        else {
            // not checked
            $.ajax({
                type: 'GET',
                url: "http://localhost/konderbetyar/rec_own.php?CatId=" + catId,
                success: function (data) {
                    $( "#dinamic" ).empty();
                    $( "#dinamic" ).append(data);
                }
            });
        }
 
    });
    
    $( document.body ).on( "click", ".submeatOwn", function() {
        var subhus = $(this).val();
        $.ajax({
            type: 'GET',
            url: "http://localhost/konderbetyar/rec_own.php?submeat=" + subhus + "&subId=" + subId + "&CatId=" + catId,
            success: function (data) {
                $("#dinamic").empty();
                $("#dinamic").append(data);
                //document.getElementById("dinrec").innerHTML = data;
            }
        });
        
    });
    
    $(document.body).on('change', '.catcheckOwn', function(){
        subId = $(this).val();
        if (this.checked) {
            $( ".catcheckOwn" ).each(function() {
                var tmp = $(this).val();
                if (tmp !== subId){
                    $(this).removeAttr("checked");
                }
            });
            //checked
            $.ajax({
                type: 'GET',
                url: "http://localhost/konderbetyar/rec_own.php?subId=" + subId + "&CatId=" + catId,
                success: function (data) {
                    $( "#dinamic" ).empty();
                    $( "#dinamic" ).append(data);
                }
            });
            //return;
        }
        else {
            // not checked
            $.ajax({
                type: 'GET',
                url: "http://localhost/konderbetyar/rec_own.php?CatId=" + catId,
                success: function (data) {
                    $( "#dinamic" ).empty();
                    $( "#dinamic" ).append(data);
                }
            });
        }
 
    });
// -------- NAV INDEX REC CAT ----------------------//



$( ".btnProf" ).on( "click", function(event) {
        event.preventDefault();
        
        //$('header').animate({'height': '300px'}, 'slow' );
        //$('#wrapper').animate({'height': '300px'}, 'slow' );
        
    });
    
//---------------SUBCAT CHECK ----------------------------//
    
    $(document.body).on('change', '.catcheck', function(){
        subId = $(this).val();
        if (this.checked) {
            $( ".catcheck" ).each(function() {
                var tmp = $(this).val();
                if (tmp !== subId){
                    $(this).removeAttr("checked");
                }
            });
            //checked
            $.ajax({
                type: 'GET',
                url: "http://localhost/konderbetyar/pub_rec.php?subId=" + subId + "&CatId=" + catId,
                success: function (data) {
                    $( "#dinamic" ).empty();
                    $( "#dinamic" ).append(data);
                }
            });
            //return;
        }
        else {
            // not checked
            $.ajax({
                type: 'GET',
                url: "http://localhost/konderbetyar/pub_rec.php?CatId=" + catId,
                success: function (data) {
                    $( "#dinamic" ).empty();
                    $( "#dinamic" ).append(data);
                }
            });
        }
 
    });
    
    $( document.body ).on( "click", ".submeat", function() {
        var subhus = $(this).val();
        $.ajax({
            type: 'GET',
            url: "http://localhost/konderbetyar/pub_rec.php?submeat=" + subhus + "&subId=" + subId + "&CatId=" + catId,
            success: function (data) {
                $("#dinamic").empty();
                $("#dinamic").append(data);
                //document.getElementById("dinrec").innerHTML = data;
            }
        });
        
    });

//------------REGISTRATION----------//

$( "#btn_reg" ).on( "click", function(event) {
        event.preventDefault();  
        $('#reg-success').html("");
        $('#reg-error').html("");
        
        var formData = {
            'name'        : $('#name').val(),
            'password'    : $('#password_reg').val(),
            'secPassword' : $('#secPassword_reg').val(),
            'email'       : $('#email').val(),
            'submit'      : $('input[name=submit]').val()
        };
        $.ajax({
            type        : 'POST',
            url         : "http://localhost/konderbetyar/reg_gen.php",
            data        : formData,
            dataType    : 'json',
            success: function (data) {
                if (data.ret_val){
                    $('#reg-success').html(data.ret);
                    $( "#btn_reg" ).remove(); 
                    $('#btn_ok').css("display", "block");
                } else {
                    $('#reg-error').html(data.ret);
                }
            },
            error: function (data){
            }
        });
    });
    
    $( "#btn_ok" ).on( "click", function(event) {
        event.preventDefault();
        window.location.replace("");
    });
    
    
//-------------LOGIN---------//

$(document.body).on('submit','#login', function(event){
        $.ajax({
            type        : 'POST',
            url         : "http://localhost/konderbetyar/login_val.php",
            data        : $( this ).serialize(),
            success: function (data) {
                document.getElementById("login-success").innerHTML = data;
                window.location.replace("");
            },
            error: function (data){
                document.getElementById("login-error").innerHTML = data;
            }
        });
        event.preventDefault();
    });

 //-------- MODAL FORG_PASS------------//
 
 $('#forg_pass').click(function(event){
    event.preventDefault();
    $('.mod_log').animate({'height': '0px'},);
    $('#mod_log').animate({'height': '0px'}, );
    $('#mod_forg').animate({'height': '100%'},);
    $("#mod_log").css("display", "none");
    $("#mod_forg").css("display", "block");
 });

$(".closeForg").on("click", function(event) {
     event.preventDefault();
     $("#mod_forg").animate({'height': '0px'},);
     $('#mod_log').animate({'height': '100%'},);
     $("#mod_forg").css("display", "none");
    $("#mod_log").css("display", "block");
    modal.style.display = "none";
 });

//--- FORG PASS VAL ---//

$(document.body).on('submit','#submit_forg', function(event){
        $( "[name='kuldes']" ).prop('disabled', true);
        
        $.ajax({
            type        : 'POST',
            url         : "http://localhost/konderbetyar/forg_pass_val.php",
            data        : $( this ).serialize(),
            success: function (data) {
                if (data.ret_val){
                    $('#forg_ok').html(data.ret);
                    $( "#forg_basic_msg" ).remove();
                    $( "#btn_kuld" ).remove(); 
                    $('#forg_btn_ok').css("display", "block");
                    $('#forg_nok').css("display", "none");
                } else {
                    $('#forg_nok').html(data.ret);
                    $( "[name='kuldes']" ).prop('disabled', false);
                }
            },
            error: function (data){
            }
        });
        event.preventDefault();
    });
    
$( "#forg_btn_ok" ).on( "click", function(event) {
        event.preventDefault();
        $('#mod_log').animate({'height': '100%'},);
        $("#mod_forg").css("display", "none");
        $("#mod_log").css("display", "block");
        modal.style.display = "none";
        window.location.replace("");
    });
    
// -------------------Recount----------------//

$(document.body).on('click', '#adagszamol' ,function(){
        var id = $(this).val();
        var recount = $('#adagbe').val();
        //var portion = $(this).getAttribute("data-value");
        var dataValue = $(this).data('value');
        //var buttom = document.querySelector("button");
        //var dataValue = buttom.getAttribute("data-value");
        //alert(id + " ," + recount + "," + dataValue);
        $.ajax({
            type: 'GET',
            url: "http://localhost/konderbetyar/ingred_gen.php?recount=" + recount + "&recId=" + id + "&portion=" + dataValue,
            success: function (data) {
                //alert(data);
                modalRec = document.getElementById('myModalRec');
                $("#ingredHolder").empty();
                $("#ingredHolder").append(data);
                spanRec = document.getElementsByClassName("closeRec")[0];
                modalRec.style.display = "block";
                spanRec.onclick = function() {
                    modalRec.style.display = "none";
                }
            }
        });
        
    });
    
    
//------------------- REC MODAL ---------------- //
var recId;
var modalRec;
var spanRec;
$( document.body ).on( "click", "#rec_modal_open", function(){
        recId = $(this).val();
        $.ajax({
            type        : 'GET',
            url         : "http://localhost/konderbetyar/rec_mod_gen.php?recId=" + recId,
            success: function (data) {
                 modalRec = document.getElementById('myModalRec');
                 $( "#myModalRec" ).empty();
                 $( "#myModalRec" ).append(data);
                 spanRec = document.getElementsByClassName("closeRec")[0];
                 modalRec.style.display = "block";
                 spanRec.onclick = function() {
                    modalRec.style.display = "none";
                 }
                 window.onclick = function(event) {
                    if (event.target == modalRec) {
                        modalRec.style.display = "none";
                    }
                }
                event.preventDefault();
            },
            error: function (data){
                alert("NEM OK");
            }
        });
    });
    
    
//------------------- REC EDIT MODAL ---------------- //
var delId;
$(document.body).on('click', '.delRow' ,function(event){
    event.preventDefault();
    delId = $(this).val();
    //alert (delId);
    $("." + delId).remove();
        });
        
        
$(document.body).on('click', '#addRowEdit' ,function(){
    var count = 0;
    var newRow;
    count++;
    newRow =("NewRow"+count);
    //$("p:not(.intro)")
    //$(".delRow").prop('value', newRow);
    $("#hozzavalo").clone(true, true).contents().addClass(newRow).appendTo('#ingHoldEdit').find("input[type=text],[type=number]").val("");
    
    //$("#repeat").removeClass();
    //$("#repeat").addClass(newRow)
    
   });  
//---------------REC UP MODAL ---------------------//
var modalRecUp;
var spanRecUp;



$( document.body ).on( "click", "#recUpMod", function(){
        $.ajax({
            type        : 'GET',
            url         : "http://localhost/konderbetyar/rec_up_mod.php",
            success: function (data) {
                 modalRecUp = document.getElementById('myModalRecUp');
                 //$( "#myModalRecUp" ).empty();
                 $( "#myModalRecUp" ).append(data);
                 spanRecUp = document.getElementsByClassName("closeRecUp")[0];
                 modalRecUp.style.display = "block";
                 spanRecUp.onclick = function() {
                    modalRecUp.style.display = "none";
                    $( "#myModalRecUp" ).empty();
                 }
                 window.onclick = function(event) {
                    if (event.target == modalRecUp) {
                        modalRecUp.style.display = "none";
                        $( "#myModalRecUp" ).empty();
                    }
                }
                event.preventDefault();
            },
            error: function (){
                alert("NEM OK");
            }
        });
    });


$(document.body).on('click', '#addRow' ,function(){
    $("#repeat").clone(true, true).contents().appendTo('#hozzavalo').find("input[type=text],[type=number]").val("");
   });
    
 $(document.body).on('click', '.recLink' ,function(){
     $('.recOwn').css("color", "#ffffff");
     $('.recLink').css("color", "#000000");
     $('#kulsoLink').css("display", "block");
     $('.ingHold').css("display", "none");
     $('.procHold').css("display", "none");
     $('.portHold').css("display", "none");
     $('.imgHold').css("display", "none");
     $('.remarcHold').css("display", "block");
     
     
   }); 
   
 $(document.body).on('click', '.recOwn' ,function(){
     $('.recOwn').css("color", "#000000");
     $('.recLink').css("color", "#ffffff");
     $('#kulsoLink').css("display", "none");
     $('.remarcHold').css("display", "none");
     $('.ingHold').css("display", "block");
     $('.procHold').css("display", "block");
     $('.portHold').css("display", "block");
   });
   
if($("#logIn").length != 0){  
//--------------MODAL LOGIN--------------//
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var logIn = document.getElementById("logIn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
logIn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
}



//--------MODAL REG---------------------//
if($("#signUp").length != 0){ 
var modalReg = document.getElementById('myModalReg');

// Get the button that opens the modal
var signUp = document.getElementById("signUp");

// Get the <span> element that closes the modal
var spanReg = document.getElementsByClassName("closeReg")[0];

// When the user clicks on the button, open the modal
signUp.onclick = function() {
    modalReg.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
spanReg.onclick = function() {
    modalReg.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modalReg) {
        modalReg.style.display = "none";
    }
}

}

});

//subactegory//
function get_sub(cat) {
     $.ajax({
        type: 'GET',
        url: "http://localhost/konderbetyar/rec_up_mod.php?cat=" + cat,
        success: function (data) {
            $("#submenu").css("display", "block");
            document.getElementById("submenu").innerHTML = data;
        }
    });
}

//huskategory
    
function husok(subcat) {
    $.ajax({
        type: 'GET',
        url: "http://localhost/konderbetyar/rec_up_mod.php?subcat=" + subcat,
        success: function (data) {
            $("#submenu2").css("display", "block");
            document.getElementById("submenu2").innerHTML = data;
        }
    });
}

// SPAJSZ

function spajszba(spaId) {
        $.ajax({
            type: 'GET',
            url: "http://localhost/konderbetyar/addToo.php?spaId=" + spaId,
            success: function (data) {
                //alert(data);
                $("#sapjszHolder").empty();
                $("#sapjszHolder").append(data);
            }
        });

    }
    
function spajszRemove(spaRemId) {
        $.ajax({
            type: 'GET',
            url: "http://localhost/konderbetyar/addToo.php?spaRemId=" + spaRemId,
            success: function (data) {
                //alert(data);
                $("#sapjszHolder").empty();
                $("#sapjszHolder").append(data);
            }
        });

    }
        
// EDIT

function btnEdit(recId) {
    var modalRec;
    var spanRecEdit;
        $.ajax({
            type: 'GET',
            url: "http://localhost/konderbetyar/rec_edit.php?recId=" + recId,
            success: function (data) {
                modalRec = document.getElementById('myModalRec');
                //alert(data);
                $("#myModalRec").empty();
                $("#myModalRec").append(data);
                spanRecEdit = document.getElementsByClassName("closeRecEdit")[0];
                modalRec.style.display = "block";
                 spanRecEdit.onclick = function() {
                    modalRec.style.display = "none";
                 }
            }
        });

    }
    

  