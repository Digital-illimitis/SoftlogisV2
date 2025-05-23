$(function() {
    "use strict";

    // Activation du lien actif dans la sidebar
    var currentUrl = window.location.href;
    $(".metismenu li a").filter(function() {
        return this.href === currentUrl;
    }).addClass("active").parent().addClass("mm-active");

    // Basculement de la sidebar
    $(".toggle-icon").click(function() {
        $(".wrapper").toggleClass("toggled");
        if ($(".wrapper").hasClass("toggled")) {
            $(".sidebar-wrapper").hover(
                function() {
                    $(".wrapper").addClass("sidebar-hovered");
                },
                function() {
                    $(".wrapper").removeClass("sidebar-hovered");
                }
            );
        } else {
            $(".sidebar-wrapper").unbind("mouseenter mouseleave");
        }
    });

    // Bouton "Retour en haut"
    $(document).ready(function() {
        $(window).on("scroll", function() {
            if ($(this).scrollTop() > 300) {
                $(".back-to-top").fadeIn();
            } else {
                $(".back-to-top").fadeOut();
            }
        });
        $(".back-to-top").on("click", function() {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });
    });

    // Activation du plugin Metis Menu
    $("#menu").metisMenu();

	function updateDateTime() {
		fetch('/get-current-datetime')
			.then(response => response.json())
			.then(data => {
				document.getElementById('current-datetime').textContent = data.datetime;
			});
	}

	setInterval(updateDateTime, 1000); // Mise à jour toutes les secondes




});
