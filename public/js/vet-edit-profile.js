document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Edit Profile loaded.");


    /* =====================================================
       LOAD SAVED PROFILE
       ===================================================== */

    const savedProfile =
        localStorage.getItem("happyPawsVetProfile");

    if (savedProfile) {

        try {

            const profile =
                JSON.parse(savedProfile);

            setValue("full-name", profile.full_name);
            setValue("email", profile.email);
            setValue("phone", profile.phone);
            setValue("date-of-birth", profile.date_of_birth);
            setValue("gender", profile.gender);

            setValue("license-number", profile.license_number);
            setValue("license-expiry", profile.license_expiry);
            setValue("specialization", profile.specialization);
            setValue("experience", profile.experience);
            setValue("position", profile.position);
            setValue("clinic", profile.clinic);

            setValue("degree", profile.degree);
            setValue("institution", profile.institution);
            setValue("bio", profile.bio);

        } catch (error) {

            console.log("Could not load saved profile.");

        }
    }


    function setValue(id, value) {

        const element =
            document.getElementById(id);

        if (element && value !== undefined) {
            element.value = value;
        }
    }


    /* =====================================================
       BIO CHARACTER COUNT
       ===================================================== */

    const bio =
        document.getElementById("bio");

    const bioCount =
        document.getElementById("bio-count");

    function updateBioCount() {

        if (!bio || !bioCount) {
            return;
        }

        if (bio.value.length > 500) {
            bio.value =
                bio.value.substring(0, 500);
        }

        bioCount.textContent =
            bio.value.length;
    }

    if (bio) {
        bio.addEventListener(
            "input",
            updateBioCount
        );

        updateBioCount();
    }


    /* =====================================================
       SAVE PROFILE
       ===================================================== */

    const form =
        document.getElementById("edit-profile-form");

    if (form) {

        form.addEventListener("submit", function (event) {

            event.preventDefault();


            const profile = {

                full_name:
                    getValue("full-name"),

                email:
                    getValue("email"),

                phone:
                    getValue("phone"),

                date_of_birth:
                    getValue("date-of-birth"),

                gender:
                    getValue("gender"),


                license_number:
                    getValue("license-number"),

                license_expiry:
                    getValue("license-expiry"),

                specialization:
                    getValue("specialization"),

                experience:
                    getValue("experience"),

                position:
                    getValue("position"),

                clinic:
                    getValue("clinic"),


                degree:
                    getValue("degree"),

                institution:
                    getValue("institution"),

                bio:
                    getValue("bio")
            };


            localStorage.setItem(
                "happyPawsVetProfile",
                JSON.stringify(profile)
            );


            alert("Profile changes saved successfully.");


            window.location.href =
                "index.php?url=vet/profile";

        });

    }


    function getValue(id) {

        const element =
            document.getElementById(id);

        return element
            ? element.value.trim()
            : "";
    }


    /* =====================================================
       PROFILE PHOTO UPLOAD
       ===================================================== */

    const photoUpload =
        document.getElementById("photo-upload");

    const profileImage =
        document.getElementById("profile-image");

    const headerProfileImage =
        document.getElementById(
            "header-profile-image"
        );


    if (photoUpload) {

        photoUpload.addEventListener(
            "change",
            function () {

                const file =
                    this.files[0];

                if (!file) {
                    return;
                }


                if (!file.type.startsWith("image/")) {

                    alert(
                        "Please select an image file."
                    );

                    this.value = "";

                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        const imageData =
                            event.target.result;


                        if (profileImage) {
                            profileImage.src =
                                imageData;
                        }


                        if (headerProfileImage) {
                            headerProfileImage.src =
                                imageData;
                        }


                        localStorage.setItem(
                            "happyPawsVetPhoto",
                            imageData
                        );

                    };


                reader.readAsDataURL(file);

            }
        );

    }


    /* =====================================================
       LOAD SAVED PHOTO
       ===================================================== */

    const savedPhoto =
        localStorage.getItem(
            "happyPawsVetPhoto"
        );

    if (savedPhoto) {

        if (profileImage) {
            profileImage.src =
                savedPhoto;
        }

        if (headerProfileImage) {
            headerProfileImage.src =
                savedPhoto;
        }
    }


    /* =====================================================
       REMOVE PHOTO
       ===================================================== */

    const removePhoto =
        document.getElementById("remove-photo");


    if (removePhoto) {

        removePhoto.addEventListener(
            "click",
            function () {

                const confirmed =
                    confirm(
                        "Are you sure you want to remove the profile photo?"
                    );

                if (!confirmed) {
                    return;
                }


                localStorage.removeItem(
                    "happyPawsVetPhoto"
                );


                if (profileImage) {

                    profileImage.src =
                        "images/happy_paws_logo.png";

                }


                if (headerProfileImage) {

                    headerProfileImage.src =
                        "images/happy_paws_logo.png";

                }

            }
        );

    }


    /* =====================================================
       CERTIFICATE UPLOAD
       ===================================================== */

    const certificateUpload =
        document.getElementById(
            "certificate-upload"
        );

    const certificateFileName =
        document.getElementById(
            "certificate-file-name"
        );


    if (certificateUpload) {

        certificateUpload.addEventListener(
            "change",
            function () {

                const file =
                    this.files[0];

                if (!file) {
                    return;
                }


                certificateFileName.textContent =
                    file.name;


                localStorage.setItem(
                    "happyPawsCertificateName",
                    file.name
                );


                alert(
                    "Certificate selected: " +
                    file.name
                );

            }
        );

    }


    /* =====================================================
       LOAD CERTIFICATE NAME
       ===================================================== */

    const savedCertificate =
        localStorage.getItem(
            "happyPawsCertificateName"
        );


    if (
        savedCertificate &&
        certificateFileName
    ) {

        certificateFileName.textContent =
            savedCertificate;

    }


    /* =====================================================
       ADD QUALIFICATION
       ===================================================== */

    const addQualification =
        document.getElementById(
            "add-qualification"
        );


    if (addQualification) {

        addQualification.addEventListener(
            "click",
            function () {

                alert(
                    "Another qualification can be added here."
                );

            }
        );

    }


    /* =====================================================
       ACCOUNT SETTINGS
       ===================================================== */

    const changePassword =
        document.getElementById(
            "change-password"
        );


    if (changePassword) {

        changePassword.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                alert(
                    "Change Password page will be available here."
                );

            }
        );

    }


    const changeEmail =
        document.getElementById(
            "change-email"
        );


    if (changeEmail) {

        changeEmail.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                alert(
                    "Change Email page will be available here."
                );

            }
        );

    }

});