jQuery(document).ready(function () {
  $ = jQuery;
  $.validator.setDefaults({
    ignore: [],
  });

  $(".close").click(function () {
    $(".overlay, .popmessage").fadeOut();
  });
  $("#terms").click(function () {
    var hiddenField = jQuery("#hidden_input");
    val = hiddenField.val();
    hiddenField.val(val === "true" ? "" : "true");
  });

  $("#contact-form").validate({
    submitHandler: function () {
      city17_update_db();
    },
    rules: {
      fname: {
        required: true,
      },
      lname: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      checkme: {
        required: true,
      },
      phone: {
        digits: true,
      },
    },
  });

  function city17_update_db() {
    $.ajax({
      url: php_vars.ajax_url,
      type: "post",
      data: {
        action: "city17_update_db",
        formdata: $("#contact-form").serialize(),
        security: php_vars.security,
      },
      beforeSend: function () {},
      success: function (response) {
        console.log(response);
        if (response == "nodb") {
          alert("intert data base name!");
        } else if (response == "ok") {
          $(".overlay").fadeIn();
          $(".popmessage").fadeIn();
          $(".popmessage-text").html("<p>data saved succsefuly!</p>");
        }
      },
      error: function (err) {
        console.log(err);
      },
    });
  }
});
