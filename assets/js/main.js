$(document).ready(function () {
  
  $("#systemLogo").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#systemLogoPreview").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });


   $("body").on("submit", "#install-form", function (e) {
    e.preventDefault();

   

    $.ajax({
      url: base_url + "auth/action.php?action=save_installation_data",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: function () {
        $form.find("button").prop("disabled", true).text("Installing..");
      },
      success: function (response) {
        if (response.status == 1) {
          Swal.fire({
            icon: "success",
            title: "Installation Complete",
            text: response.message,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500
          }).then(() => {
            // redirect to main system
            window.location.href = base_url + "src/";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            confirmButtonText: "Try Again"
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        Swal.fire({
          icon: "error",
          title: "AJAX Request Failed",
          text: "Please check your connection or backend.",
        });
      },
      complete: function () {
        $form.removeClass("processing");
        $form.find("button").prop("disabled", false).text("INSTALL SYSTEM");
      },
    });
  });

  $("#systemLogo").on("change", function (event) {
    const fileInput = event.target;
    const preview = $(".preview");

    preview.empty();

    const files = fileInput.files;
    for (const file of files) {
      if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.attr("src", e.target.result);
          $("input[name=system_logo]").attr("value", e.target.result);
        };
        reader.readAsDataURL(file);
      } else {
        const para = $("<p>").text(
          `File ${file.name} is not a valid image file.`
        );
        preview.append(para);
      }
    }
  });
  /* END LIBRARIAN SETTING PROFILE */
});
