document.addEventListener("DOMContentLoaded", function () {

    const navLinks = document.querySelectorAll(".nav-link");

    const sections = document.querySelectorAll(
        "#home-section, #about, #services, #contact"
    );


    /*
     * Smooth scrolling
     */

    navLinks.forEach(function (link) {

        link.addEventListener("click", function (event) {

            const targetId = this.getAttribute("href");

            if (!targetId || !targetId.startsWith("#")) {
                return;
            }

            const target = document.querySelector(targetId);

            if (!target) {
                return;
            }

            event.preventDefault();

            target.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        });

    });


    /*
     * Change active navigation item
     * according to the current section
     */

    const observer = new IntersectionObserver(
        function (entries) {

            entries.forEach(function (entry) {

                if (!entry.isIntersecting) {
                    return;
                }

                let activeId = entry.target.id;

                if (activeId === "home-section") {
                    activeId = "home";
                }

                navLinks.forEach(function (link) {

                    link.classList.remove("active");

                    if (
                        link.getAttribute("href") ===
                        "#" + activeId
                    ) {
                        link.classList.add("active");
                    }

                });

            });

        },
        {
            threshold: 0.35
        }
    );


    sections.forEach(function (section) {
        observer.observe(section);
    });


    /*
     * Close any URL hash issue when
     * clicking the logo.
     */

    const logo = document.querySelector(".logo");

    if (logo) {

        logo.addEventListener("click", function (event) {

            const homeSection =
                document.querySelector("#home-section");

            if (homeSection) {

                event.preventDefault();

                homeSection.scrollIntoView({
                    behavior: "smooth"
                });

            }

        });

    }

});

function focusLoginCard() {

    const loginCard = document.getElementById("login");

    if (!loginCard) {
        return;
    }

    loginCard.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });

}