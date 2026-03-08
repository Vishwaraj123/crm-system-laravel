$(document).ready(function () {
  $("#template_name").on("input", function () {
    const input = $(this).val();
    const sanitizedInput = input
      .replace(/[^\w\s]/gi, "")
      .replace(/\s+/g, "_")
      .toLowerCase();
    $(this).val(sanitizedInput);
    const count = sanitizedInput.length;
    $("#nameCharCount").text("Characters: " + count + " / 512");
  });
  $(document).on("click", ".__js_delete", function () {
    confirmationAlert(
      $(this).data("url"),
      $(this).data("id"),
      "Yes, Delete It!"
    );
  });
  const confirmationAlert = (
    url,
    data_id,
    button_test = "Yes, Confirmed it!"
  ) => {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: button_test,
    }).then((confirmed) => {
      if (confirmed.isConfirmed) {
        axios
          .post(url, { data_id: data_id })
          .then((response) => {
            refreshDataTable();
            console.log(response);
            Swal.fire(
              response.data.message,
              response.data.status == true ? "deleted" : "error",
              response.data.status == true ? "success" : "error"
            );
          })
          .catch((error) => {
            console.log(error);
            Swal.fire(error.response);
            refreshDataTable();
          });
      }
    });
  };
  const refreshDataTable = () => {
    $("#dataTableBuilder").DataTable().ajax.reload();
  };
  // Function to toggle template fields
  let firstLoad = true;

  window.toggleTemplateFields = function () {
    const selectedCategory = $('input[name="template_category"]:checked').val();
    // console.log("Selected:", selectedCategory);

    // Only clear inputs if this is not the first load
    if (!firstLoad) {
      // Clear regular form fields (text inputs or textareas)
      $("#header_text, #message_body, #footer_text").val("");

      // Clear visual preview content
      $(
        "#_message_body_text, #_footer_text, #_footer_btn, #message-header"
      ).html("");

      // Reset file inputs
      $("#header_image, #header_video, #header_document").each(function () {
        $(this).val("");
        $(this).replaceWith($(this).clone(true)); // `true` keeps event listeners
      });

      // Optional: Clear buttons or other sections
      $("#append-call-to-action").empty();
      $("#append-quick-reply").empty();
    }

    // Show/hide fields based on category
    if (selectedCategory === "AUTHENTICATION") {
      let copyCodeText = $("#copyCodeText").val("Copy Code");
      $("#auth_template_fields").show();
      $(
        "#custom_template_fields, #carousel_template_fields, #template_type_field"
      ).hide();

      // Default authentication preview
      $("#_message_body_text").html("<b>{{1}}</b> is your verification code.");
      $("#message_body").val("{{1}} is your verification code.");

      $("#_footer_btn").html(`
      <button class="btn btn-template w-100 border-top">
        <i class="las la-copy"></i> ${copyCodeText.val()}
      </button>
    `);
    } else if (selectedCategory === "MARKETING") {
      $("#template_type_field").show();
      $(
        "#custom_template_fields, #auth_template_fields, #carousel_template_fields"
      ).hide();

      const templateType = $("#template_type").val();
      // console.log("Template Type:", templateType);/

      if (templateType === "CUSTOM") {
        $("#custom_template_fields").show();
      } else if (templateType === "MEDIA_CARD_CAROUSEL") {
        $("#carousel_template_fields").show();
        initCarouselCards();
      }
    } else {
      $(
        "#template_type_field, #auth_template_fields, #carousel_template_fields"
      ).hide();
      $("#custom_template_fields").show();
    }

    // Set firstLoad to false after the first run
    firstLoad = false;
  };

  /*
    ===========================================
    Script for Marketing and Utility Templates 
    ===========================================
  */
  $("#quick_reply").on("input", function () {
    var count = $(this).val().length;
    $("#buttonCharCount").text("Characters: " + count + " / 25");
  });
  function toggleHeaderSections(selectedValue) {
    // Hide all sections initially
    $(
      "#headerTextSection, #headerImageSection, #headerAudioSection, #headerVideoSection, #headerDocumentSection"
    ).hide();
    // $("#message-header").empty();

    // Show the appropriate section based on the selected value
    switch (selectedValue) {
      case "TEXT":
        $("#buttonSection").show();
        $("#footerSection").show();
        $("#headerTextSection").show();
        break;
      case "IMAGE":
        $("#buttonSection").show();
        $("#footerSection").show();
        $("#headerImageSection").show();
        break;
      case "AUDIO":
        $("#buttonSection").show();
        $("#footerSection").show();
        $("#headerAudioSection").show();
        break;
      case "VIDEO":
        $("#buttonSection").show();
        $("#footerSection").show();
        $("#headerVideoSection").show();
        break;
      case "DOCUMENT":
        $("#buttonSection").show();
        $("#footerSection").show();
        $("#headerDocumentSection").show();
        break;
      default:
        break;
    }
  }

  // Function to detect variables or specific patterns in the header text
  function detectPatterns(text) {
    const regex = /{{\s*\d+\s*}}/g; // Regex to detect {{variable}} patterns
    const matches = text.match(regex); // Find all matches
    return matches || []; // Return the array of matches or an empty array
  }
  // Function to remove all but the first variable pattern
  function retainFirstVariable(text) {
    const patterns = detectPatterns(text);
    if (patterns.length > 1) {
      const firstPattern = patterns[0];
      const cleanedText = text.replace(regex, (match, index) => {
        return index === 0 ? match : "";
      });
      return cleanedText;
    }
    return text;
  }

  $(document).on("input", ".live_preview_header", function () {
    try {
      updateHeaderTransformedText();
    } catch (error) {
      console.error("An error occurred:", error);
    }
  });

  $(document).ready(function () {
    try {
      updateHeaderTransformedText();
    } catch (error) {
      console.error("An error occurred:", error);
    }
  });

  function updateHeaderTransformedText() {
    const headerType = $("#header_type").val();

    // ✅ Only update message-header if type is TEXT
    if (headerType !== "TEXT") return;

    let new_header = $("#header_text").val();

    $(".live_preview_header").each(function () {
      const variableId = $(this).attr("id").split("_")[1];
      const variableValue = $(this).val();
      const variablePattern = new RegExp(`\\{\\{${variableId}\\}\\}`, "g");

      if (variableValue.trim() !== "") {
        // Use the actual variable ID pattern
        new_header = new_header.replace(variablePattern, variableValue);
      }
    });

    $("#message-header").html(new_header);
  }

  // Function to update the sample header content based on detected patterns
  function updateSampleHeaderContent(patterns) {
    const sampleHeader = $("#sample-header");
    const sampleHeaderContent = $("#sample-header-contant");
    if (patterns.length > 0) {
      sampleHeader.show();
      sampleHeaderContent.empty();
      if (patterns.length > 1) {
        toastr.error(
          "Only one variable is allowed in the header text. Extra variables are removed."
        );
      }
      patterns.forEach((pattern) => {
        const inputField = `
            <div class="form-group">
                <label for="pattern_${pattern}">Input for variable ${pattern}<span class="text-danger">*</span></label>
                <input type="text" class="form-control live_preview_header"  id="pattern_${pattern}" name="header_variable[]" placeholder="Enter value for variable ${pattern}" required><div class="invalid-feedback text-danger"></div>
            </div>`;
        sampleHeaderContent.append(inputField); // Add the new input to the container
      });
    } else {
      sampleHeader.hide();
    }
  }

  $("#header_text").on("input", function () {
    const newHeaderText = $(this).val();

    // Only update the message-header if header type is TEXT
    if ($("#header_type").val() === "TEXT") {
      $("#message-header").text(newHeaderText);
    }

    const count = newHeaderText.length;
    $("#headerCharCount").text("Characters: " + count + " / 60");

    let headerText = newHeaderText;
    headerText = retainFirstVariable(headerText);
    const detectedPatterns = detectPatterns(headerText);
    updateSampleHeaderContent(detectedPatterns);

    $(this).val(headerText);
  });

  function transformText(text) {
    // Strikethrough for text like: ~Welcome~
    text = text.replace(/~(.*?)~/g, "<del>$1</del>");
    // Italic for text like: _Use code {{2}} at checkout._
    text = text.replace(/_(.*?)_/g, "<i>$1</i>");
    // Bold for text like: *Sale ends on 30th June 2024.*
    text = text.replace(/\*(.*?)\*/g, "<b>$1</b>");
    // Monospace for text like: ```Welcome```
    text = text.replace(/```(.*?)```/g, "<code>$1</code>");
    // Replace newlines with <br>
    text = text.replace(/\n/g, "<br>");
    return text;
  }

  // Function to detect variables in the message body
  function detectVariables(text) {
    const variablePattern = /\{\{(\d+)\}\}/g; // Regular expression for variables like {{1}}, {{2}}, etc.
    const matches = [];
    let match;
    while ((match = variablePattern.exec(text)) !== null) {
      if (!matches.includes(match[1])) {
        matches.push(match[1]);
      }
    }
    return matches; // Return array of variable numbers
  }

  $("#message_body").on("input", function () {
    const newMessageBody = $(this).val().replace(/\n/g, "<br>");
    const transformedText = transformText(newMessageBody);
    $("#_message_body_text").html(transformedText);

    const count = newMessageBody.length;
    $("#charCount").text(`Characters: ${count} / 1024`);
    const detectedVariables = detectVariables(newMessageBody);
    updateSampleBodyContent(
      detectedVariables,
      $("#sample-body"),
      $("#sample-body-contant")
    );
  });

  function updateSampleBodyContent(variables, sampleBody, sampleBodyContent) {
    // console.log("variables", variables);

    if (variables.length > 0) {
      sampleBody.show();
      sampleBodyContent.empty();

      variables.forEach((variable) => {
        const inputField = `
        <div class="form-group">
          <label for="variable_${variable}">Value for variable &#123;&#123;${variable}&#125;&#125;<span class="text-danger">*</span></label>
          <input type="text" class="form-control live_preview" id="variable_${variable}" name="body_variable[]" placeholder="Enter value for variable &#123;&#123;${variable}&#125;&#125;" required>
          <div class="invalid-feedback text-danger"></div>
        </div>`;
        sampleBodyContent.append(inputField);
      });
    } else {
      sampleBody.hide();
    }
  }
  function updateCardSampleBodyContent(
    cardIndex,
    variables,
    sampleBody,
    sampleBodyContent
  ) {
    // console.log("variables", variables);

    if (variables.length > 0) {
      sampleBody.show(); // make container visible
      sampleBodyContent.empty();

      variables.forEach((variable) => {
        const inputField = `
      <div class="form-group">
        <label for="variable_${cardIndex}_${variable}">
          Value for variable &#123;&#123;${variable}&#125;&#125;<span class="text-danger">*</span>
        </label>
        <input type="text"
               class="form-control live_preview"
               id="variable_${cardIndex}_${variable}"
               name="card_body_variable[${cardIndex}][]"
               placeholder="Enter value for variable &#123;&#123;${variable}&#125;&#125;"
               ${sampleBody.is(":visible") ? "required" : ""}>
        <div class="invalid-feedback text-danger"></div>
      </div>`;
        sampleBodyContent.append(inputField);
      });
    } else {
      sampleBody.hide();
      sampleBodyContent.empty(); // important: clear hidden inputs
    }
  }

  // Event delegation for input event on .live_preview elements
  $(document).on("input", ".live_preview", function () {
    updateTransformedText();
  });
  $(document).ready(function () {
    // Trigger updateTransformedText on page load
    updateTransformedText();
  });

  function updateTransformedText() {
    let newMessageBody = $("#message_body").val().replace(/\n/g, "<br>");
    let transformedText = transformText(newMessageBody);
    $(".live_preview").each(function () {
      const variableId = $(this).attr("id").split("_")[1];
      const variableValue = $(this).val();
      const variablePattern = new RegExp(`\\{\\{${variableId}\\}\\}`, "g");
      if (variableValue.trim() !== "") {
        transformedText = transformedText.replace(
          variablePattern,
          variableValue
        );
      }
    });
    $("#_message_body_text").html(transformedText);
  }

  // $("#message_body").trigger("input"); // Ensure initial detection and updating
  function hasVariables(text) {
    const variablePattern = /\{\{.*?\}\}/g;
    return variablePattern.test(text);
  }

  function validateFooterText() {
    const footerText = $("#footer_text").val(); // Get the current footer text
    const notice = $("#footerVariableNotice"); // The notice to display if variables are detected
    if (hasVariables(footerText)) {
      $("#footer_text").val(""); // Clear the text if variables are found
      notice.show(); // Display the notice
    } else {
      notice.hide(); // Hide the notice if no variables are found
    }
  }
  $("#footer_text").on("input", function () {
    const newFooterText = $(this).val();
    $("#_footer_text").text(newFooterText);
    const count = newFooterText.length;
    $("#footerCharCount").text("Characters: " + count + " / 60");
    validateFooterText();
  });
  $("#footer_text").trigger("input");

  // Display a notice section
  $("<div>", {
    id: "footerVariableNotice", // ID for the notice
    class: "alert alert-warning", // Bootstrap alert class
    text: "Variables are not supported in the footer.", // Notice message
    style: "display:none;", // Initially hidden
  }).insertAfter("#footer_text"); // Insert after the footer text field

  // When the document is ready, set the correct initial state
  var initialSelectedValue = $("#header_type").val();
  toggleHeaderSections(initialSelectedValue);

  $("#header_type").on("change", function () {
    var selectedValue = $(this).val();
    toggleHeaderSections(selectedValue);
  });

  // Function to toggle sections based on the current button type
  function toggleButtonTypeSections(buttonType) {
    if (buttonType === "CTA") {
      $("#call-to-action-section").show();
      $("#quick_reply-section").hide(); // Hide quick reply section when CTA is selected
      $("#append-quick-reply").empty();
    } else if (buttonType === "QUICK_REPLY") {
      $("#call-to-action-section").hide();
      $("#quick_reply-section").show(); // Show quick reply section when quick reply is selected
      $("#append-call-to-action").empty();
    } else {
      $("#call-to-action-section").hide();
      $("#quick_reply-section").hide(); // Hide both if none is selected
      $("#append-call-to-action").empty();
      $("#append-quick-reply").empty();
    }
  }
  var initialButtonType = $('input[name="button_type"]:checked').val();
  toggleButtonTypeSections(initialButtonType);
  $('input[name="button_type"]').on("change", function () {
    var selectedButtonType = $(this).val();
    $("#_footer_btn").html("");
    $(".add_call_to_action, .add-quick-reply-btn").removeClass("disabled");
    toggleButtonTypeSections(selectedButtonType);
  });
  // var initialButtonType = $('input[name="button_type"]:checked').val();
  // toggleButtonTypeSections(initialButtonType);
  // $('input[name="button_type"]').on("change", function () {
  //   var selectedButtonType = $(this).val();
  //   toggleButtonTypeSections(selectedButtonType);
  // });
  // Event listener for removing a card
  // $(document).on("click", ".remove-card", function () {
  //   var card = $(this).closest(".card"); // Get the closest card
  //   var cardId = card.attr("id"); // Get the card's unique ID
  //   card.remove(); // Remove the card
  //   $("#" + cardId + "_preview").remove();
  // });

  // Initial update of "Add Button" options when the document is ready
  $(document).ready(function () {
    updateAddButtons();
  });

  // Function to enable or disable the "Add Button" option based on the maximum card count
  function toggleAddButton(actionType) {
    var maxCards = $("a[data-action='" + actionType + "']").data("max"); // Get the maximum number of cards allowed
    var cardCount = $(
      "#append-button .card[data-action='" + actionType + "']"
    ).length; // Get the current card count for the given actionType
    var addButton = $("a[data-action='" + actionType + "']"); // Get the corresponding "Add Button" option

    if (cardCount >= maxCards) {
      addButton.addClass("disabled"); // Disable the "Add Button" option
    } else {
      addButton.removeClass("disabled"); // Enable the "Add Button" option
    }
  }

  function updateAddButtons() {
    // Loop through each action type
    [
      "visit_website",
      "call_phone_number",
      "copy_offer_code",
      "quick_reply",
    ].forEach(function (actionType) {
      console.log(actionType);
      toggleAddButton(actionType); // Update the "Add Button" option for the current action type
    });
  }

  $(document).on("click", ".remove-card", function () {
    var card = $(this).closest(".card"); // Get the closest card
    var cardId = card.attr("id"); // Get the card's unique ID
    card.remove(); // Remove the card
    $("#" + cardId + "_preview").remove();

    // Enable the corresponding "Add Button" option if the max limit is not reached
    var actionType = card.data("action");

    var maxAllowed = $(
      ".add_call_to_action[data-action='" + actionType + "']"
    ).data("max");
    var maxAllowed1 = $(
      ".add-quick-reply-btn[data-action='" + actionType + "']"
    ).data("max");

    var cardCount = $(
      "#append-button .card[data-action='" + actionType + "']"
    ).length;

    if (cardCount < maxAllowed) {
      $(".add_call_to_action[data-action='" + actionType + "']").removeClass(
        "disabled"
      );
    }
    if (cardCount < maxAllowed1) {
      $(".add-quick-reply-btn[data-action='" + actionType + "']").removeClass(
        "disabled"
      );
    }
    updateAddButtons(); // Update the "Add Button" options after removing a card
  });

  let cardIdCounter = 0;
  function generateUniqueId() {
    return Math.random().toString(36).substr(2, 9); // Create a unique ID with random numbers and letters
  }

  $(".add_call_to_action").on("click", function () {
    var actionType = $(this).data("action");
    var cardCount = $("#append-call-to-action .card").length; // Get the current card count
    var maxCards = 3; // Define the maximum number of cards allowed
    if (cardCount >= maxCards) {
      toastr.error("You can only add up to three buttons.");
      return; // Exit without adding a new card
    }
    var maxButtonsAllowed = parseInt($(this).data("max"));

    var currentButtonCount = $(
      "#call-to-action-section .c-card[data-action='" + actionType + "']"
    ).length;
    if (currentButtonCount >= maxButtonsAllowed) {
      toastr.error(
        "You have reached the maximum limit for adding " +
          actionType.replace(/_/g, " ") +
          " buttons."
      );
      return;
    }
    // console.log(maxButtonsAllowed);
    // console.log(currentButtonCount);
    cardIdCounter++;
    var uniqueId = generateUniqueId(); // Create a unique identifier for this card
    // const uniqueId = "card_" + cardIdCounter;
    var content = "";
    if (actionType === "visit_website") {
      content = `
            <div class="card mt-2 c-card" data-action="visit_website" id="${uniqueId}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="type_of_action" class="d-block">Type of Action<span class="text-danger">*</span></label>
                            <select name="type_of_action[]" id="type_of_action" class="form-select" required>
                                <option value="URL">Visit Website</option>
                            </select><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-3">
                            <label for="button_text" class="d-block">Button Text<span class="text-danger">*</span></label>
                            <input type="text" class="form-control button_text_input" name="button_text[]" placeholder="Enter button text" maxlength="20"  required><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-5">
                            <label for="website_url" class="d-block">Website URL<span class="text-danger">*</span></label>
                            <input type="url" class="form-control" name="button_value[]" placeholder="Enter website URL" maxlength="2000" required><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-1 text-end mt-4">
                            <button type="button" class="btn btn-danger text-white remove-card"><i class="las la-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>`;
    } else if (actionType === "call_phone_number") {
      content = `
            <div class="card mt-2 c-card" data-action="call_phone_number" id="${uniqueId}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="type_of_action" class="d-block">Type of Action<span class="text-danger">*</span></label>
                            <select name="type_of_action[]" id="type_of_action" class="form-select" required>
                                <option value="PHONE_NUMBER">Call Phone Number</option>
                            </select><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-3">
                            <label for="button_text" class="d-block">Button Text<span class="text-danger">*</span></label>
                            <input type="text" class="form-control button_text_input" name="button_text[]" placeholder="Enter button text" maxlength="20" required><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-5">
                            <label for="phone_number" class="d-block">Phone Number<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="button_value[]" placeholder="Enter phone number" maxlength="20" required><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-1 text-end mt-4">
                            <button type="button" class="btn btn-danger text-white remove-card"><i class="las la-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>`;
    } else if (actionType === "copy_offer_code") {
      content = `
            <div class="card mt-2 c-card" data-action="copy_offer_code" id="${uniqueId}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="type_of_action" class="d-block">Type of Action<span class="text-danger">*</span></label>
                            <select name="type_of_action[]" id="type_of_action" class="form-select" required>
                                <option value="COPY_CODE">Copy Offer Code</option>
                            </select><div class="invalid-feedback text-danger"></div>
                            <input type="hidden" class="form-control button_text_input" name="button_text[]" placeholder="Enter button text" maxlength="20">
                        </div>
                        <div class="col-3">
                            <label for="button_text" class="d-block">Button Text<span class="text-danger">*</span></label>
                            <input type="text" class="form-control button_text_input" name="button_value[]" placeholder="Enter button text" required><div class="invalid-feedback text-danger"></div>
                        </div>
                        <div class="col-1 text-end mt-4 ">
                            <button type="button" class="btn btn-danger text-white remove-card"><i class="las la-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>`;
    }
    $("#append-call-to-action").append(content);
    var buttonText = $("input[name='button_text[]']").last().val(); // Get the last button text
    var buttonContainer = $("#_footer_btn .tmp-btn-list");
    if (buttonContainer.length === 0) {
      $("#_footer_btn").append(
        `<div class="tmp-btn-list text-center border-top-0 mt-2"></div>`
      );
      buttonContainer = $("#_footer_btn .tmp-btn-list"); // Reassign after creating
    }
    var buttonText = $("input[name='button_text[]']").last().val(); // Get the last button text
    var buttonPreview = "";
    switch (actionType) {
      case "visit_website":
        buttonPreview = `<button class="btn btn-template w-100 border-top" id="${uniqueId}_preview"><i class="las la-external-link-alt"></i> Read More</button>`;
        break;
      case "call_phone_number":
        buttonPreview = `<button class="btn btn-template w-100 border-top" id="${uniqueId}_preview"><i class="las la-phone"></i> Call Us</button>`;
        break;
      case "copy_offer_code":
        buttonPreview = `<button class="btn btn-template w-100 border-top" id="${uniqueId}_preview"><i class="las la-copy"></i> Copy Code</button>`;
        break;
    }
    buttonContainer.append(buttonPreview);
    if (currentButtonCount + 1 >= maxButtonsAllowed) {
      $(this).addClass("disabled");
    }
    if (cardCount + 1 >= maxCards) {
      $(".add_call_to_action").addClass("disabled");
    }
  });

  $(".add-quick-reply-btn").on("click", function () {
    var actionType = $(this).data("action");
    var cardCount = $("#append-quick-reply .card").length; // Get the current card count
    var maxCards = 8; // Define the maximum number of cards allowed
    // if (cardCount >= maxCards) {
    //   toastr.error("You can only add up to eight buttons.");
    //   return; // Exit without adding a new card
    // }
    var maxButtonsAllowed = parseInt($(this).data("max"));
    // console.log(maxButtonsAllowed);
    var currentButtonCount = $(
      "#append-quick-reply .c-card[data-action='" + actionType + "']"
    ).length;
    // console.log(maxButtonsAllowed);

    if (currentButtonCount >= maxButtonsAllowed) {
      toastr.error(
        "You have reached the maximum limit for adding " +
          actionType.replace(/_/g, " ") +
          " buttons."
      );
      return;
    }
    var uniqueId = generateUniqueId(); // Create a unique identifier for this card
    var actionType = $(this).data("action");
    var content = "";
    content = `
            <div class="card mt-2 c-card" data-action="quick_reply" id="${uniqueId}">
                <div class="card-body">
                    <div class="row">
                    <div class="col">
                    <label for="button_text" class="d-block">Button Text<span class="text-danger">*</span></label>
                    <input type="text" class="form-control button_text_input" name="button_text[]" placeholder="Enter button text" required>
                    </div>
                        <div class="col-1 text-end mt-4">
                            <button type="button" class="btn btn-danger text-white remove-card"><i class="las la-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>`;
    $("#append-quick-reply").append(content);
    var buttonContainer = $("#_footer_btn .tmp-btn-list");
    if (buttonContainer.length === 0) {
      $("#_footer_btn").append(
        `<div class="tmp-btn-list text-center border-top-0 mt-2"></div>`
      );
      buttonContainer = $("#_footer_btn .tmp-btn-list"); // Reassign after creating
    }
    var buttonPreview = "";
    buttonPreview = `<button class="btn btn-template w-100 border-top" data-action="${actionType}" data-max="8" id="${uniqueId}_preview"><i class="las la-reply"></i>Quick Reply</button>`;
    buttonContainer.append(buttonPreview);
    if (currentButtonCount + 1 >= maxButtonsAllowed) {
      $(this).addClass("disabled");
    }
    if (cardCount + 1 >= maxCards) {
      $(".add_call_to_action").addClass("disabled");
    }
  });

  // Event listener for input in button_text[] to update the corresponding preview
  $(document).on("input", "input[name='button_text[]']", function () {
    var cardId = $(this).closest(".card").attr("id"); // Get the card's unique ID
    var buttonText = $(this).val(); // Get the text value
    var previewButton = $(`#${cardId}_preview`); // Find the preview button
    var icon = previewButton.find("i"); // Find the icon element
    previewButton
      .contents()
      .filter(function () {
        return this.nodeType === Node.TEXT_NODE;
      })
      .remove(); // Remove all text nodes
    previewButton.append(` ${buttonText}`); // Append the new text after the icon
  });

  // Function to set the required attribute based on the selected header type
  // function updateRequiredAttribute(headerType) {
  //   // Remove required attribute from all header fields initially
  //   $(
  //     "#header_text, #header_image, #header_video, #header_audio, #header_document"
  //   ).removeAttr("required");
  //   // Add the required attribute to the specific field based on the selected header type
  //   switch (headerType) {
  //     case "TEXT":
  //       $("#header_text").attr("required", true);
  //       break;
  //     case "IMAGE":
  //       $("#header_image").attr("required", true);
  //       break;
  //     case "VIDEO":
  //       $("#header_video").attr("required", true);
  //       break;
  //     case "AUDIO":
  //       $("#header_audio").attr("required", true);
  //       break;
  //     case "DOCUMENT":
  //       $("#header_document").attr("required", true);
  //       break;
  //     default:
  //       // No header or unknown type, no required attributes
  //       break;
  //   }
  // }
  // // Event listener for changes in the header type
  // $("#header_type").on("change", function () {
  //   $("#message-header").html("");
  //   $(
  //     "#header_image, #header_video, #header_audio, #header_document, #header_text"
  //   ).val("");
  //   const selectedHeaderType = $(this).val();
  //   updateRequiredAttribute(selectedHeaderType);
  // });
  // // Call the function initially in case of default or pre-selected value
  // updateRequiredAttribute($("#header_type").val()); // Ensure correct setup on page load
  // // Event listener for changes in the image file input
  function handleFileChange(
    input,
    validationMessage,
    allowedTypes,
    maxSizeMB,
    displayFunction
  ) {
    const fileInput = input[0];
    if (!fileInput.files.length) {
      validationMessage.text(
        `Please upload a ${allowedTypes.join(" or ")} file.`
      );
      return;
    }
    const file = fileInput.files[0];
    if (!allowedTypes.includes(file.type)) {
      validationMessage.text(
        `Only ${allowedTypes.join(", ")} files are allowed.`
      );
      return;
    }
    const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB
    if (fileSizeMB > maxSizeMB) {
      validationMessage.text(`The file must be ${maxSizeMB} MB or smaller.`);
      return;
    }
    const reader = new FileReader();
    reader.onload = function (e) {
      displayFunction(e.target.result);
    };
    if (file) {
      reader.readAsDataURL(file);
    }
    validationMessage.text("");
  }

  $("#header_image").change(function () {
    handleFileChange(
      $(this),
      $("#imageValidationMessage"),
      ["image/jpeg", "image/png", "image/gif"],
      5,
      function (result) {
        const img = $("<img>").attr("src", result);
        $("#message-header").empty().append(img);
      }
    );
  });

  $("#header_video").change(function () {
    handleFileChange(
      $(this),
      $("#validationMessage"),
      ["video/mp4", "video/avi", "video/mov", "video/wmv"],
      16,
      function (result) {
        const video = $("<video controls>").attr("src", result);
        $("#message-header").empty().append(video);
      }
    );
  });

  $("#header_audio").change(function () {
    handleFileChange(
      $(this),
      $("#audioValidationMessage"),
      ["audio/mpeg", "audio/wav", "audio/ogg"],
      10,
      function (result) {
        const audio = $("<audio controls>").attr("src", result);
        $("#message-header").empty().append(audio);
      }
    );
  });

  $("#header_document").change(function () {
    handleFileChange(
      $(this),
      $("#pdfValidationMessage"),
      ["application/pdf"],
      10,
      function (result) {
        const pdf = $("<iframe>")
          .attr("src", result)
          .attr("width", "100%")
          .attr("height", "400px");
        $("#message-header").empty().append(pdf);
      }
    );
  });
  // Update the button text
  $("#button_text").on("input", function () {
    var newButtonText = $(this).val();
    $("#_button_text").text(newButtonText);
  });
  $("#carousel_message_body").on("input", function () {
    const newMessageBody = $(this).val().replace(/\n/g, "<br>");

    const transformedText = transformText(newMessageBody);
    $("#_message_body_text").html(transformedText);

    const count = newMessageBody.length;
    $("#charCount").text(`Characters: ${count} / 1024`);
    const detectedVariables = detectVariables(newMessageBody);
    updateSampleBodyContent(
      detectedVariables,
      $("#carousel-sample-body"),
      $("#carousel-sample-body-contant")
    );
  });
  $(document).on("input", ".card-body-textarea", function () {
    console.log("Card Body Textarea Input Detected");

    const index = $(this).data("index");
    const bodyText = $(this).val();
    const variables = detectVariables(bodyText);
    const sampleBody = $(`#card-sample-body-${index}`);
    const sampleBodyContent = $(`#card-sample-body-content-${index}`);
    updateCardSampleBodyContent(
      index,
      variables,
      sampleBody,
      sampleBodyContent
    );
    const previewSelector = document.querySelector(
      `#card-body-textarea-${index}`
    );
    console.log(previewSelector);

    // Check if preview card exists
    if (previewSelector) {
      console.log("Preview card exists");
      previewSelector.textContent = bodyText;
    } else {
      // Create and append a new card dynamically
      const newCard = `
      <div class="carousel-item ${index === 0 ? "active" : ""}">
    <div class="card mx-auto border-0">
      <img src="" class="card-img-top carousel-image p-2" alt="carousel-image-${index}" data-index="${index}">
      <div class="card-body text-center p-2">
        <p class="card-text mb-2" id="card-body-textarea-${index}" data-index="${index}">${
        bodyText || ""
      }</p>
        
        <!-- Placeholder for buttons (same ID pattern) -->
        <button id="cardBtn_${index}_0"
          class="btn btn-template w-100 border-top rounded-0 border-radius-0">
          <i class="las la-reply"></i>
        </button>

        <button id="cardBtn_${index}_1"
          class="btn btn-template w-100 border-top rounded-0 border-radius-0">
          <i class="las la-reply"></i>
        </button>
      </div>
    </div>
  </div>`;
      console.log(newCard);

      $(".carousel-inner").append($(newCard));
      // Update new card's icons based on first card
      for (let btnIndex = 0; btnIndex <= 1; btnIndex++) {
        const type = getButtonTypeFromFirstCard(btnIndex);
        updateIconsForAllCards(btnIndex, type);
      }
    }
  });

  /*
    =====================================
    Script for Authentication Template
    =====================================
*/

  // Toggle expiry time section visibility
  $("#addExpiryTime").on("change", function () {
    if ($(this).is(":checked")) {
      $("#expiryTimeOptions").show();
      let expiryTime = $("#expiryTime").val();
      $("#_footer_text").text(
        "This code expires in " + expiryTime + " minutes."
      );
      $("#expiryTime").on("input", function () {
        expiryTime = $("#expiryTime").val();
        $("#_footer_text").text(
          "This code expires in " + expiryTime + " minutes."
        );
      });
    } else {
      $("#expiryTimeOptions").hide();
      $("#_footer_text").text("");
    }
  });
  $("#addSecurityRecommendation").on("change", function () {
    if ($(this).is(":checked")) {
      $("#_message_body_text").append(
        "\tFor your security, do not share this code."
      );
      $("#message_body").val(
        "<b>\u007B\u007B1\u007D\u007D</b> is your verification code. For your security, do not share this code."
      );
    } else {
      $("#_message_body_text").html(
        "<b>\u007B\u007B1\u007D\u007D</b> is your verification code."
      );
      $("#message_body").val(
        $("#_message_body_text").val(
          "<b>\u007B\u007B1\u007D\u007D</b> is your verification code."
        )
      );
    }
  });
  // Character counter for copy code input
  $("#copyCodeText").on("input", function () {
    const length = $(this).val().length;
    let copyCodeText = $(this).val();
    $("#_footer_btn").html(`
            <button class="btn btn-template w-100 border-top"><i class="las la-copy"></i> ${copyCodeText}</button>
        `);
    $("#copyCodecharCount").text(length + "/25");
  });

  // Trigger initial state
  $("#addExpiryTime").trigger("change");

  /*
 Script for Carousel
 */
  const maxCards = 10;
  const carouselSection = document.getElementById("carouselSection");
  const wrapper = document.getElementById("carouselItemsWrapper");

  $("#templateType").on("change", function () {
    // Clear previous cards on every change
    wrapper.innerHTML = "";

    if (type === "MEDIA_CAROUSEL_CARD") {
      carouselSection.show();
      carouselSection.find("select, input, textarea").prop("required", true);
      $("#carousel_message_body").prop("required", true);
      $("#message_body").val($("#carousel_message_body").val());
      $("#message_body").prop("required", false);
    } else {
      carouselSection.hide();
      carouselSection.find("select, input, textarea").prop("required", false);
      $("#carousel_message_body").prop("required", false);
      $("#message_body").prop("required", true);
    }
  });
  function generateCard(index) {
    const isRequired = index < 2; // ✅ Only first 2 cards are required
    const cardData = existingCarousel[index] || {};
    const mediaType = cardData.header?.toLowerCase() || "";
    const bodyText = cardData.body || "";
    const buttons = cardData.buttons || [];
    // console.log(buttons);

    let buttonHtml = "";
    if (buttons) {
      buttons.forEach((btn, btnIndex) => {
        if (!btn) return;
        console.log(`Button ${btnIndex}:`, btn);

        const type = btn.type || "quick_reply";
        const labelValue = btn.text || "";
        const urlValue = btn.url || "";
        const phoneValue = btn.phone_number || "";
        console.log(type);

        buttonHtml += `
    <div class="button-item mb-3 border rounded p-2" data-btn-index="${btnIndex}">
      <div class="row mb-2">
      <div class="col-md-4">
        <label>Type</label>
        ${
          index === 0
            ? `
          <select name="cards[${index}][buttons][${btnIndex}][type]" class="form-control btn-type-select" data-index="${index}" data-btn="${btnIndex}">
            <option value="QUICK_REPLY" ${
              type == "QUICK_REPLY" ? "selected" : ""
            }>Quick Reply</option>
            <option value="URL" ${type == "URL" ? "selected" : ""}>URL</option>
            <option value="PHONE_NUMBER" ${
              type == "PHONE_NUMBER" ? "selected" : ""
            }>Phone Number</option>
          </select>
        
        `
            : `
        <input type="hidden" name="cards[${index}][buttons][${btnIndex}][type]" value="${type}">
            <span class="form-control-plaintext">${type
              .replace("_", " ")
              .toUpperCase()}</span>`
        }
              </div>
        <div class="col-md-8">
          <label>Label</label>
          <input type="text" name="cards[${index}][buttons][${btnIndex}][text]" data-index="${index}" data-btn-index="${btnIndex}" class="form-control card-button-label" value="${labelValue}">
        </div>
      </div>
      <div class="row btn-value-row" id="btn-value-row-${index}-${btnIndex}">
        ${
          type === "URL"
            ? `<div class="col-12"><label>URL</label><input type="url" name="cards[${index}][buttons][${btnIndex}][value]" class="form-control" value="${urlValue}"></div>`
            : type === "PHONE_NUMBER"
            ? `<div class="col-12"><label>Phone Number</label><input type="text" name="cards[${index}][buttons][${btnIndex}][value]" class="form-control" value="${phoneValue}"></div>`
            : ""
        }
      </div>
      ${
        index === 0
          ? `<div class="text-end mt-2">
               <button type="button" class="btn btn-danger btn-sm remove-carousel-button" data-btn-index="${btnIndex}">
                 <i class="las la-trash"></i> Delete
               </button>
             </div>`
          : ""
      }
    </div>`;
      });
    }

    let cardHtml = `<div class="card mb-4 p-3 border" data-index="${index}">
    <h5>Card ${index + 1}${
      index === 0
        ? ' <span class="text-danger">(Configure Buttons Here)</span>'
        : ""
    }</h5>
    
    <div class="row mb-3">
      <div class="col-md-4">
        <label>Media Type${
          isRequired ? '<span style="color: red">*</span>' : ""
        }</label>
        <select name="cards[${index}][media_type]" class="form-control media-type-select" ${
      isRequired ? "required" : ""
    } data-index="${index}">
          <option value="">Select</option>
          <option value="image" ${
            mediaType === "image" ? "selected" : ""
          }>Image</option>
          <option value="video" ${
            mediaType === "video" ? "selected" : ""
          }>Video</option>
        </select>
      </div>
      <div class="col-md-8">
        <label>Upload Media${
          isRequired ? '<span style="color: red">*</span>' : ""
        }</label>
        <input type="file" name="cards[${index}][media]" class="form-control media-upload" data-index="${index}">
      </div>
    </div>

    <div class="mb-3">
      <label>Card Body Text${
        isRequired ? '<span style="color: red">*</span>' : ""
      }</label>
      <textarea class="form-control card-body-textarea" name="cards[${index}][body]" rows="2" ${
      isRequired ? "required" : ""
    } data-index="${index}">${bodyText}</textarea>
      <div class="card-sample-body mt-2" id="card-sample-body-${index}" style="display: none;">
        <label class="mb-1 d-block">Variables:</label>
        <div id="card-sample-body-content-${index}"></div>
      </div>

    </div>

    <!-- Button type radio -->
          <div class="mb-3">
      <label>Buttons (max 2)</label>
      ${
        index === 0
          ? `
        <button type="button" class="btn btn-sm btn-outline-primary add-button" data-index="${index}">
          + Add Button
        </button>`
          : ""
      }
      <div class="button-wrapper mt-2" data-index="${index}"> ${buttonHtml}</div>
    </div>
`;
    return cardHtml;
  }

  window.initCarouselCards = function () {
    console.log("initCarouselCards");

    for (let i = 0; i < maxCards; i++) {
      wrapper.insertAdjacentHTML("beforeend", generateCard(i));
    }
    syncButtonsToOtherCards(); // 💥 Immediately apply to others
    // carouselSection.style.display = 'block';
  };

  // Toggle between CTA and Quick Reply sections
  wrapper.addEventListener("change", function (e) {
    if (e.target.classList.contains("btn-type-select")) {
      const type = e.target.value;
      const index = e.target.dataset.index;
      const btnIndex = e.target.dataset.btn;
      console.log("Button type changed", { type, index, btnIndex });

      const valueRow = document.querySelector(
        `#btn-value-row-${index}-${btnIndex}`
      );

      valueRow.innerHTML = "";
      if (type == "URL") {
        console.log("Updating to URL type for button", btnIndex);

        updateIconsForAllCards(btnIndex, type); // Changes all icons to external link
        valueRow.innerHTML = `
      <div class="col-12">
        <label>URL<span style="color: red">*</span></label>
        <input type="url" name="cards[${index}][buttons][${btnIndex}][value]" class="form-control"  placeholder="https://example.com">
      </div>
    `;
      } else if (type == "PHONE_NUMBER") {
        updateIconsForAllCards(btnIndex, type); // Changes all to phone
        valueRow.innerHTML = `
      <div class="col-12">
        <label>Phone Number<span style="color: red">*</span></label>
        <input type="text" name="cards[${index}][buttons][${btnIndex}][value]" class="form-control"  placeholder="918888888888">
      </div>
    `;
      } else {
        updateIconsForAllCards(btnIndex, type); // Changes all to reply
      }
      // No value needed for quick_reply
      syncButtonsToOtherCards(); // Apply type changes to other cards
    }
    if (e.target.classList.contains("media-upload")) {
      const fileInput = e.target;
      const index = fileInput.dataset.index;
      const file = fileInput.files[0];

      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = document.querySelector(
            `.carousel-image[data-index="${index}"]`
          );
          if (img) {
            img.src = e.target.result;
          }
        };
        reader.readAsDataURL(file);
      }
    }
  });
  function updateIconsForAllCards(btnIndex, type) {
    console.log("Updating icons for all cards", { btnIndex, type });

    const iconClassMap = {
      url: ["las", "la-external-link-alt"],
      phone_number: ["las", "la-phone"],
      quick_reply: ["las", "la-reply"],
    };

    const newIconClasses = iconClassMap[type.toLowerCase()] || [
      "las",
      "la-reply",
    ];

    // Assuming max 10 cards (0 to 9)
    for (let cardIndex = 0; cardIndex < 10; cardIndex++) {
      const cardBtn = document.getElementById(
        `cardBtn_${cardIndex}_${btnIndex}`
      );
      console.log("Updating button icon", { cardBtn, cardIndex, btnIndex });

      if (cardBtn && cardBtn.children.length > 0) {
        const icon = cardBtn.children[0];

        // Clear old icon classes
        icon.classList.remove(...icon.classList);

        // Add new icon classes
        icon.classList.add(...newIconClasses);
      }
    }
  }
  function getButtonTypeFromFirstCard(btnIndex) {
    const firstCardBtn = document.getElementById(`cardBtn_0_${btnIndex}`);
    if (firstCardBtn && firstCardBtn.children.length > 0) {
      const icon = firstCardBtn.children[0];
      if (icon.classList.contains("la-external-link-alt")) return "URL";
      if (icon.classList.contains("la-phone")) return "PHONE_NUMBER";
      if (icon.classList.contains("la-reply")) return "QUICK_REPLY";
    }
    return "QUICK_REPLY"; // default fallback
  }

  wrapper.addEventListener("click", function (e) {
    if (e.target.classList.contains("add-button")) {
      const index = parseInt(e.target.dataset.index);
      if (index !== 0) return;

      const card = document.querySelector(`.card[data-index="${index}"]`);
      const wrapper = card.querySelector(".button-wrapper");
      if (wrapper.children.length >= 2) {
        toastr.error("Maximum 2 buttons allowed.");
        return;
      }

      const btnIndex = wrapper.children.length;
      const newButtonHtml = getButtonInputHtml(index, btnIndex, true);
      wrapper.insertAdjacentHTML("beforeend", newButtonHtml);

      syncButtonsToOtherCards(); // 💥 Immediately apply to others
    }
  });
  wrapper.addEventListener("input", function (e) {
    if (e.target.classList.contains("card-button-label")) {
      const input = e.target;
      const buttonLabel = input.value;
      const cardIndex = input.dataset.index;
      const btnIndex = input.dataset.btnIndex;

      console.log(
        `Updating button text for card ${cardIndex}, button ${btnIndex}`
      );

      const previewSelector = `cardBtn_${cardIndex}_${btnIndex}`;
      const previewButton = document.getElementById(previewSelector);

      if (previewButton) {
        // Clear existing text nodes after the icon and set new label
        const icon = previewButton.querySelector("i");

        // Remove all existing text nodes (not the <i>)
        [...previewButton.childNodes].forEach((node) => {
          if (node.nodeType === Node.TEXT_NODE) {
            previewButton.removeChild(node);
          }
        });

        // Add a new text node with a space and the updated label
        previewButton.appendChild(document.createTextNode(" " + buttonLabel));
      }
    }
  });

  document.addEventListener("click", function (e) {
    if (e.target.closest(".remove-carousel-button")) {
      const btnWrapper = e.target.closest(".button-item");
      if (btnWrapper) {
        btnWrapper.remove();
      }
      syncButtonsToOtherCards(); // 💥 Immediately apply to others
    }
  });

  // initCarouselCards();
  document.querySelector("form").addEventListener("submit", function (e) {
    const cards = document.querySelectorAll("#carouselItemsWrapper .card");

    cards.forEach((card) => {
      const bodyTextarea = card.querySelector("textarea[name*='[body]']");
      if (!bodyTextarea.value.trim()) {
        // If body is empty, remove all inputs inside this card
        const inputs = card.querySelectorAll("input, select, textarea");
        inputs.forEach((el) => (el.disabled = true)); // ❌ Prevent submission
      }
    });
  });

  function syncButtonsToOtherCards() {
    const firstCard = document.querySelector(".card[data-index='0']");
    const btnItems = firstCard.querySelectorAll(".button-item");

    const config = Array.from(btnItems).map((item, i) => {
      const typeSelect = item.querySelector(".btn-type-select");
      return typeSelect ? typeSelect.value : "quick_reply"; // fallback
    });

    for (let i = 1; i < 10; i++) {
      const card = document.querySelector(`.card[data-index="${i}"]`);
      const wrapper = card.querySelector(".button-wrapper");
      wrapper.innerHTML = "";

      config.forEach((type, btnIndex) => {
        const html = getButtonInputHtml(i, btnIndex, false, type);
        wrapper.insertAdjacentHTML("beforeend", html);
      });
    }
  }

  $(document).on("submit", "#whatsapp-template-form", async (event) => {
    event.preventDefault();
    debounceButton1();
    try {
      const url = $("#whatsapp-template-form").attr("action");
      const data = new FormData($("#whatsapp-template-form")[0]);
      const response = await axios.post(url, data, {
        processData: false,
        contentType: false,
      });
      console.log(response);
      if (response.data.status) {
        toastr.success(response.data.message);
        $("#whatsapp-template-form")[0].reset(); // Reset the form
        window.location.href = response.data.redirect_to;
      } else {
        toastr.error(response.data.message);
      }
      // location.reload();
    } catch (error) {
      console.log(error.response);

      if (typeof error.response.data === "string") {
        toastr.error(error.response.data.message);
      } else {
        const errors = error.response.data.errors || {};
        for (const key in errors) {
          const id = `#${key}`;
          console.log(id);
          $(id).addClass("is-invalid");
          $(id).siblings(".invalid-feedback").html(errors[key][0]);
          $(id).siblings(".invalid-feedback").show();
        }
        toastr.error(error.response.data.message);
      }
    } finally {
      debounceButton1();
    }
  });

  $(document).on("submit", "#whatsapp-template-update", async (event) => {
    event.preventDefault();
    debounceButton1();
    try {
      const url = $("#whatsapp-template-update").attr("action");
      const data = new FormData($("#whatsapp-template-update")[0]);
      const response = await axios.post(url, data, {
        processData: false,
        contentType: false,
      });
      console.log(response);
      if (response.data.status) {
        toastr.success(response.data.message);
        $("#whatsapp-template-update")[0].reset(); // Reset the form
        window.location.href = response.data.redirect_to;
      } else {
        toastr.error(response.data.message);
      }
      // location.reload();
    } catch (error) {
      console.log(error);
      if (typeof error.response.data === "string") {
        toastr.error(error.response.data.message);
      } else {
        const errors = error.response.data.errors || {};
        for (const key in errors) {
          const id = `#${key}`;
          console.log(id);
          $(id).addClass("is-invalid");
          $(id).siblings(".invalid-feedback").html(errors[key][0]);
          $(id).siblings(".invalid-feedback").show();
        }
        toastr.error(error.response.data.message);
      }
    } finally {
      debounceButton1();
    }
  });

  /* Time */
  var deviceTime = $(".status-bar .time");
  var messageTime = $(".message .time");

  function updateTime() {
    deviceTime.text(moment().format("h:mm"));
  }
  updateTime();
  setInterval(updateTime, 1000);
  messageTime.text(moment().format("h:mm A"));
  const debounceButton1 = () => {
    let preloader = $("#preloader");
    let saveButton = $(".save");

    if (preloader.hasClass("d-none")) {
      preloader.removeClass("d-none");
      saveButton.addClass("d-none");
    } else {
      preloader.addClass("d-none");
      saveButton.removeClass("d-none");
    }
  };

  // function initializeSortable() {
  //   var sortable = new Sortable(document.getElementById("append-button"), {
  //     animation: 150,
  //     onUpdate: function (evt) {
  //       var item = evt.item;
  //       var items = sortable.toArray();
  //     },
  //   });
  // }

  // // Reinitialize SortableJS after appending new contact data
  // function reinitializeSortable() {
  //   if (typeof Sortable !== "undefined") {
  //     initializeSortable();
  //   }
  // }

  // // Initialize SortableJS on page load
  // document.addEventListener("DOMContentLoaded", function () {
  //   initializeSortable();
  // });
  document.addEventListener("DOMContentLoaded", function () {
    const maxCards = 10;
    const carouselSection = document.getElementById("carouselSection");
    const wrapper = document.getElementById("carouselItemsWrapper");

    function initCarouselCards() {
      for (let i = 0; i < maxCards; i++) {
        wrapper.insertAdjacentHTML("beforeend", generateCard(i));
      }
      // carouselSection.style.display = 'block';
    }
    initCarouselCards();
  });
  document.querySelector("form").addEventListener("submit", function (e) {
    const cards = document.querySelectorAll("#carouselItemsWrapper .card");

    cards.forEach((card) => {
      const bodyTextarea = card.querySelector("textarea[name*='[body]']");
      if (!bodyTextarea.value.trim()) {
        // If body is empty, remove all inputs inside this card
        const inputs = card.querySelectorAll("input, select, textarea");
        inputs.forEach((el) => (el.disabled = true)); // ❌ Prevent submission
      }
    });
  });
  function getButtonInputHtml(
    cardIndex,
    btnIndex,
    isSelectable = false,
    type = "quick_reply",
    buttons = null
  ) {
    const labelValue =
      buttons && buttons[btnIndex] ? buttons[btnIndex].text : "";
    const urlValue =
      buttons && buttons[btnIndex] ? buttons[btnIndex].url : "";
    const phoneValue =
      buttons && buttons[btnIndex] ? buttons[btnIndex].phone : "";
    const valueInput = {
      url: `
      <div class="col-12">
        <label>URL</label>
        <input type="url" name="cards[${cardIndex}][buttons][${btnIndex}][value]" class="form-control" placeholder="https://example.com" value="${urlValue}">
      </div>
    `,
      phone_number: `
      <div class="col-12">
        <label>Phone Number</label>
        <input type="text" name="cards[${cardIndex}][buttons][${btnIndex}][value]" class="form-control" placeholder="+919999999999" value="${phoneValue}">
      </div>
    `,
      quick_reply: "",
    };

    return `
    <div class="button-item mb-3 border rounded p-2">
      <div class="row mb-2">
        <div class="col-md-4">
          <label>Type</label>
          ${
            isSelectable
              ? `
            <select name="cards[${cardIndex}][buttons][${btnIndex}][type]" class="form-control btn-type-select" data-index="${cardIndex}" data-btn="${btnIndex}">
              <option value="QUICK_REPLY" ${
                type == "QUICK_REPLY" ? "selected" : ""
              }>Quick Reply</option>
              <option value="URL" ${
                type == "URL" ? "selected" : ""
              }>URL</option>
              <option value="PHONE_NUMBER" ${
                type == "PHONE_NUMBER" ? "selected" : ""
              }>Phone Number</option>
            </select>`
              : `
            <input type="hidden" name="cards[${cardIndex}][buttons][${btnIndex}][type]" value="${type}">
            <span class="form-control-plaintext">${type
              .replace("_", " ")
              .toUpperCase()}</span>
          `
          }
        </div>
        <div class="col-md-8">
          <label>Label</label>
          <input type="text" name="cards[${cardIndex}][buttons][${btnIndex}][text]" data-index="${cardIndex}" data-btn-index="${btnIndex}" class="form-control card-button-label" value="${labelValue}" placeholder="Enter button text">
        </div>
      </div>
      <div class="row btn-value-row" id="btn-value-row-${cardIndex}-${btnIndex}">
        ${valueInput[type.toLowerCase()]}
      </div>
      ${
        cardIndex === 0
          ? `<div class="text-end mt-2">
                 <button type="button" class="btn btn-danger btn-sm remove-carousel-button" data-btn-index="${btnIndex}">
                   <i class="las la-trash"></i> Delete
                 </button>
               </div>`
          : ""
      }
    </div>
  `;
  }

  function syncButtonsToOtherCards() {
    const firstCard = document.querySelector(".card[data-index='0']");
    const btnItems = firstCard.querySelectorAll(".button-item");
    // console.log(btnItems, firstCard);

    const config = Array.from(btnItems).map((item, i) => {
      const typeSelect = item.querySelector(".btn-type-select");
      return typeSelect ? typeSelect.value : "quick_reply"; // fallback
    });
    for (let i = 1; i < 10; i++) {
      const buttons = existingCarousel[i]?.buttons; // get buttons from other cards
      // console.log(buttons);

      const card = document.querySelector(`.card[data-index="${i}"]`);
      const wrapper = card.querySelector(".button-wrapper");
      wrapper.innerHTML = "";

      config.forEach((type, btnIndex) => {
        const html = getButtonInputHtml(i, btnIndex, false, type, buttons);
        wrapper.insertAdjacentHTML("beforeend", html);
      });
    }
  }
});
