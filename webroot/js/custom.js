$("#masInfo").on("click", function() {
    $("#menuPrincipal").removeClass("activado");
    $("#menuPrincipal").addClass("ocultar");
    $("#menuSecundario").addClass("activado");
});
$("#masInfo2").on("click", function() {
    $("#menuPrincipal").removeClass("activado");
    $("#menuPrincipal").addClass("ocultar");
    $("#menuSecundario2").addClass("activado");
});
$("#volverMenu").on("click", function() {
    $("#menuPrincipal").removeClass("ocultar");
    $("#menuSecundario").removeClass("activado");
    $("#menuSecundario").addClass("ocultar");
});
$("#volverMenu2").on("click", function() {
    $("#menuPrincipal").removeClass("ocultar");
    $("#menuSecundario2").removeClass("activado");
    $("#menuSecundario2").addClass("ocultar");
});
$(".hamburger").on("click", function() {
    $("body").toggleClass("ocultarOverflow");
    // Toggle class "is-active"
    $(".hamburger").toggleClass("is-active");
    $("#menu-full").toggleClass("activado");
    mostrar = $("#menu-full").hasClass("activado");

    if (mostrar) {
        $("#menuPrincipal").addClass("activado");
        // $("#menuSecundario").addClass("activado");
    } else {
        $("#menuPrincipal").removeClass("activado");
        $("#menuSecundario").removeClass("activado");
        $("#menuSecundario2").removeClass("activado");
    }

    // Do something else, like open/close menu
});
