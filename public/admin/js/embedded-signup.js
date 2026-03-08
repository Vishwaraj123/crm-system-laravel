$(document).on("submit", "#updateProfileForm", async (event) => {
  event.preventDefault();
  debounceButton();

  const loader = $("#loader");
  const submitBtn = $(".save");

  try {
    $("body").css("cursor", "progress");

    loader.show();
    submitBtn.hide();

    const url = $("#updateProfileForm").attr("action");
    const data = new FormData($("#updateProfileForm")[0]);

    const response = await axios.post(url, data, {
      processData: false,
      contentType: false,
    });

    loader.hide();
    submitBtn.show();

    if (response.data.status) {
      toastr.success(response.data.message);
      $("#updateProfileForm")[0].reset();
      window.location.href = response.data.redirect_to;
    } else {
      toastr.error(response.data.message);
    }

    $("#updateProfileModal").modal("hide");
    $("body").css("cursor", "default");
  } catch (error) {
    loader.hide();
    submitBtn.show();

    if (typeof error.response.data === "string") {
      toastr.error(error.response.data.message);
    } else {
      const errors = error.response.data.errors || {};
      for (const key in errors) {
        const id = `#${key}`;
        $(id).addClass("is-invalid");
        $(id).siblings(".invalid-feedback").html(errors[key][0]);
        $(id).siblings(".invalid-feedback").show();
      }
      toastr.error(error.response.data.message);
    }
    $("body").css("cursor", "default");
  } finally {
    debounceButton();
    $("body").css("cursor", "default");
  }
});


$(document).on("click", ".__js_edit", function () {
  const url = $(this).data("url");
  $("body").css("cursor", "progress");
  axios
    .get(url, {
      params: {
        id: $(this).data("id"),
      },
    })
    .then((response) => {
      if (response.data.status === true) {
        $("#updateProfileModalBody").html(response.data.data);
        $("#updateProfileModal").modal("show");
      } else {
        toastr.error(response.data.message);
      }
      $("body").css("cursor", "default");
    })
    .catch((error) => {
      toastr.error(error.message);
      $("body").css("cursor", "default");
    });
});
