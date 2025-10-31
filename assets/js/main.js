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

  $("#install-form").on("submit", function (e) {
    e.preventDefault();
    const $form = $(this);

    const system_details = {};
    const admin_details = {};
    let fileReadCount = 0;

    const fileInputs = $form.find("input[type=file]");
    const totalFiles = fileInputs.length;

    function sendIfReady() {
      if (fileReadCount >= totalFiles) {
        const payload = {
          system_details,
          admin_details,
        };

        console.log("JSON payload ready:", payload);

        $.ajax({
          url: `${base_url}auth/action.php?action=installation`,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify(payload),
          dataType: "json",
          beforeSend: function () {
            $form
              .find("button[type=submit]")
              .prop("disabled", true)
              .text("Saving...");
          },
          success: function (response) {
            console.log("Server response:", response);
            if (response.status === 1) {
              Swal.fire({
                icon: "success",
                title: "Installation Complete",
                text: response.message || "Library system activated!",
                timer: 2500,
                showConfirmButton: false,
              }).then(() => (window.location.href = response.url));
            } else {
              Swal.fire({
                icon: "error",
                title: "Installation Failed",
                text: response.message || "Check your inputs and try again.",
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            Swal.fire({
              icon: "error",
              title: "Installation Failed",
              text: "AJAX request failed. Check console for details.",
            });
          },
          complete: function () {
            $form
              .find("button[type=submit]")
              .prop("disabled", false)
              .text("ACTIVATE LIBRARY SYSTEM");
          },
        });
      }
    }

    // Process all file inputs
    fileInputs.each(function () {
      const name = $(this).attr("name");
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          if (name.startsWith("system")) {
            system_details[name] = e.target.result; // System logo
          } else {
            admin_details[name] = e.target.result; // Admin profile pic
          }
          fileReadCount++;
          sendIfReady();
        };
        reader.readAsDataURL(file);
      } else {
        if (name.startsWith("system")) system_details[name] = null;
        else admin_details[name] = null;
        fileReadCount++;
        sendIfReady();
      }
    });

    // Collect non-file inputs
    $("#step-1")
      .find("input:not([type=file])")
      .each(function () {
        const name = $(this).attr("name");
        if (name) system_details[name] = $(this).val() || "";
      });

    $("#step-2")
      .find("input:not([type=file])")
      .each(function () {
        const name = $(this).attr("name");
        if (name) admin_details[name] = $(this).val() || "";
      });

    // If there are no file inputs, send immediately
    if (totalFiles === 0) {
      fileReadCount = 1;
      sendIfReady();
    }
  });

  $("#login").on("submit", function (e) {
    e.preventDefault();

    const username = $("#university-id").val().trim();
    const password = $("#password").val();

    if (!username || !password) {
      Swal.fire({
        icon: "warning",
        title: "Missing Info",
        text: "Please enter your username/email and password.",
      });
      return;
    }

    $.ajax({
      url: `${base_url}auth/action.php?action=login`, // your PHP login endpoint
      type: "POST",
      data: { username: username, password: password },
      dataType: "json",
      beforeSend: function () {
        $("#login button[type=submit]")
          .prop("disabled", true)
          .text("Logging in...");
      },
      success: function (res) {
        if (res.status === 1) {
          Swal.fire({
            icon: "success",
            title: "Login Successful",
            text: "Redirecting...",
            timer: 1500,
            showConfirmButton: false,
          }).then(() => {
            window.location.href = res.redirect_url;
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Login Failed",
            text: res.message || "Check your credentials.",
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Login AJAX error:", error);
        Swal.fire({
          icon: "error",
          title: "Login Failed",
          text: "Something went wrong. Try again.",
        });
      },
      complete: function () {
        $("#login button[type=submit]").prop("disabled", false).text("Log In");
      },
    });
  });

  $("body").on("click", "#logout", function (e) {
    e.preventDefault();
    const $this = $(this);
    $.ajax({
      url: base_url + "auth/action.php?action=logout",
      method: "POST",
      dataType: "json",
      beforeSend: function () {
        $this.text("Logging out.");
      },
      success: function (response) {
        if (response.status == 1) {
          window.location.href =
            base_url + (response.redirect_url || "index.php");
        } else {
          console.log(response.message);
        }
      },
      error: function () {
        console.error("AJAX error");
      },
    });
  });
  /* END LIBRARIAN SETTING PROFILE */

  
});
