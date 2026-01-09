// $(".logout").on("click", function(e) {
//   if ($(".menuUser").hasClass("menuUserNoVisible")) {
//     $(".menuUser").removeClass("menuUserNoVisible").addClass("menuUserVisible");
//     $(".logout").addClass("userMenuActivo");
//   }
//   else {
//     $(".menuUser").removeClass("menuUserVisible").addClass("menuUserNoVisible");
//     $(".logout").removeClass("userMenuActivo");
//   }
// });

var figure = $("video").hover( hoverVideo, hideVideo );

function hoverVideo(e) {
    $(this).get(0).play();
}

function hideVideo(e) {
    $(this).get(0).pause();
}

$("#action-del").click(function(e){
  if($(this).hasClass("unactive")) {
    e.stopPropagation();
  }
});

$("#toggle").click(
function(){
  $("#mimenu").toggleClass("shown")
});

$("#micontent").click(function(e) {
    $('#usercollapse').collapse('hide');
});
$("#mimenu").click(function(e) {
    $('#usercollapse').collapse('hide');
});

tinymce.init({
selector: "textarea",
branding: false,
menubar: false,
force_br_newlines : true,
force_p_newlines : false,
resize: false,
plugins: "lists link media code wordcount emoticons",
contextmenu: false,
toolbar: "undo redo | bold italic backcolor | numlist bullist outdent indent | link | media code emoticons",
media_live_embeds: true,
contextmenu_never_use_native: false,
forced_root_block : "",
verify_html : false,
invalid_elements:"div"
});
