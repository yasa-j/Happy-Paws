document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Medical Records loaded.");

    const tabs = document.querySelectorAll(".records-tab");
    const tabContents = document.querySelectorAll(".records-tab-content");
    const searchInput = document.getElementById("patient-search");

    // -------------------------
    // Tabs
    // -------------------------
    tabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            const selectedTab = this.dataset.tab;

            tabs.forEach(function (item) {
                item.classList.remove("active");
            });

            tabContents.forEach(function (content) {
                content.classList.remove("active");
            });

            this.classList.add("active");

            const selectedContent =
                document.getElementById(selectedTab + "-tab");

            if (selectedContent) {
                selectedContent.classList.add("active");
            }

            if (searchInput) {
                searchInput.value = "";
                resetPatientSearch();
            }
        });

    });


    // -------------------------
    // Patient Search
    // -------------------------
    if (searchInput) {

        searchInput.addEventListener("input", function () {

            const searchText =
                this.value.toLowerCase().trim();

            const mainRecord =
                document.querySelector(".main-record-card");

            if (mainRecord) {

                const patientData =
                    mainRecord.dataset.patient.toLowerCase();

                mainRecord.style.display =
                    patientData.includes(searchText)
                        ? ""
                        : "none";
            }


            const upcomingRecords =
                document.querySelectorAll(".upcoming-record");

            upcomingRecords.forEach(function (record) {

                const patientData =
                    record.dataset.patient.toLowerCase();

                record.style.display =
                    patientData.includes(searchText)
                        ? ""
                        : "none";
            });


            const patientRows =
                document.querySelectorAll(".patient-record-row");

            patientRows.forEach(function (row) {

                const patientData =
                    row.dataset.patient.toLowerCase();

                row.style.display =
                    patientData.includes(searchText)
                        ? ""
                        : "none";
            });

        });

    }


    // -------------------------
    // Reset Search
    // -------------------------
    function resetPatientSearch() {

        const mainRecord =
            document.querySelector(".main-record-card");

        if (mainRecord) {
            mainRecord.style.display = "";
        }

        document
            .querySelectorAll(".upcoming-record")
            .forEach(function (record) {
                record.style.display = "";
            });

        document
            .querySelectorAll(".patient-record-row")
            .forEach(function (row) {
                row.style.display = "";
            });
    }

});