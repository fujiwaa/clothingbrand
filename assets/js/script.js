function copyText() {
    /* Get the text field */
    var copyText = document.getElementById("myInput");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    navigator.clipboard
        .writeText(copyText.value)
        .then(function () {
            /* Show the copy message */
            var copyMessage = document.getElementById("copyMessage");
            copyMessage.style.display = "block";

            /* Hide the copy message after 2 seconds */
            setTimeout(function () {
                copyMessage.style.display = "none";
            }, 2000);
        })
        .catch(function (err) {
            console.error("Failed to copy: ", err);
        });
}
