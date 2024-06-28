var fixedLength = 0;
jQuery.validator.addMethod("filesize_max", function (value, element, param) {
    var isOptional = this.optional(element),
        file;
    if (isOptional) {
        return isOptional;
    }
    if ($(element).attr("type") === "file") {
        if (element.files && element.files.length) {
            file = element.files[0];
            return (file.size && file.size <= 52428800);
        }
    }
    return false;
}, "File size is too large.");

$.validator.addMethod('dimension', function (value, element, param) {
    if (element.files.length == 0) {
        return true;
    }
    var file = element.files[0];
    var width = height = 0;
    var tmpImg = new Image();
    var result = '';
    tmpImg.src = window.URL.createObjectURL(file);
    tmpImg.onload = function () {
        width = tmpImg.naturalWidth,
            height = tmpImg.naturalHeight;

        console.log(width);
        console.log(height);
        result = (width <= param[0] && height <= param[1]);
        console.log(result);
        return result;
    }
}, function () {
    return 'Please upload an image with maximum 100 x 100 pixels dimension'
});

jQuery.validator.addMethod("fixedDigits", function (value, element, param) {
    var isOptional = this.optional(element);
    fixedLength = param;

    if (isOptional) {
        return isOptional;
    }

    return ($(element).val().length <= param);
}, function () {
    return "Value cannot exceed " + fixedLength + " characters."
});

jQuery.validator.addMethod("extension", function (value, element, param) {
    param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, "Please select image with a valid extension (.jpg, .jpeg, .png, .gif, .svg)");

jQuery.validator.addMethod("import_extension", function (value, element, param) {
    param = typeof param === "string" ? param.replace(/,/g, '|') : "xls|xlsx";
    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, "Please select file with a valid extension (.xls, .xlsx)");

jQuery.validator.addMethod("docextension", function (value, element, param) {
    param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, "Please select file with a valid extension (.jpg, .jpeg, .png, .doc, .docx, .pdf)");

jQuery.validator.addMethod("decimalPlaces", function (value, element) {
    return this.optional(element) || /^\d+(\.\d{0,2})?$/i.test(value);
}, "Please enter a value with maximum two decimal places.");

jQuery.validator.addMethod("alphanumeric", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
}, "Please enter alphanumeric value.");

jQuery.validator.addMethod("alphanumericspace", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9\s]+$/i.test(value);
}, "Please enter alphanumeric value.");

jQuery.validator.addMethod("exactlength", function (value, element, param) {
    return this.optional(element) || value.length == param;
}, $.validator.format("Please enter exactly {0} characters."));

jQuery.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
}, "Name can have alphabets and space only.");

jQuery.validator.addMethod("contact_number", function (value, element) {
    return this.optional(element) || /^\+[0-9]+[0-9\-]+[0-9]+$/i.test(value);
}, "Incorrect number format");

jQuery.validator.addMethod("non_whitespace", function (value, element) {
    return this.optional(element) || /^(?!\s*$).+/i.test(value);
}, "Incorrect value");

jQuery.validator.addMethod("check_content", function (value, el, param) {
    var content = $(el).summernote('code');
    content = $(content).text().replace(/\s+/g, '');

    return (content !== "");
}, "Incorrect value");

jQuery.validator.addMethod("correctPassword", function (value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{6,}$/i.test(value);
}, "Please fill minimum 6 character Password with uppercase, lowercase, special character and digit");

$.validator.addMethod("greaterThanDate", function (value, element, param) {
    var $otherElement = $(param);
    return new Date('1970-01-01T' + value + 'Z') > new Date('1970-01-01T' + $otherElement.val() + 'Z');
}, "End Time must be greater than start time");


jQuery.validator.addMethod("validate_email", function (value, element) {
    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, "Please enter a valid Email.");


jQuery.validator.addMethod("alphaspace", function (value, element) {
    if (/^([a-zA-Z_\.\-])+\@(([a-zA-Z\-])+\.)+([a-zA-Z]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, "Please enter a valid Email.");



var form_validation = function () {
    // alert('enter');
    var e = function () {
        var form_validate = jQuery(".form-valide").validate({
            ignore: [".note-editor *", "password"],
            errorClass: "invalid-feedback animated fadeInDown",
            errorElement: "div",
            errorPlacement: function (e, a) {
                jQuery(a).closest(".form-group").append(e)
            },
            highlight: function (e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            },
            success: function (e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            },
            rules: {
                "email": {
                    required: !0,
                    validate_email: !0,
                    remote: APP_NAME + "/admin/users/checkUsers"
                },
                "password": {
                    required: !0,
                    minlength: 6,
                    correctPassword: !0
                },
                "confirm-password": {
                    required: !0,
                    equalTo: "#password",
                    correctPassword: !0
                },
                "old-pass": {
                    required: !0,
                },
                "pass": {
                    required: !0,
                    minlength: 6,
                    correctPassword: !0
                },
                "confirm-pass": {
                    required: !0,
                    equalTo: "#pass",
                    correctPassword: !0
                },
                "name": {
                    required: !0,
                    lettersonly: !0,
                    maxlength: 100,
                    minlength: 3
                },
                "image": {
                    extension: "jpeg|png|jpg|gif|svg",
                    filesize_max: !0
                },
                "phone_code": {
                    required: !0,
                    //  number: !0
                },
                "mobile": {
                    required: !0,
                    number: !0,
                    minlength: 8,
                    maxlength: 12
                },
                "description": {
                    required: !0
                }
            },
            messages: {
                "email": {
                    required: "Please provide email address",
                    validate_email: "Please enter a valid email address",
                    remote: "This email is already taken."
                },
                "password": {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                },
                "confirm-password": {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long",
                    equalTo: "Please enter the same password as above"
                },
                "old-pass": {
                    required: "Please provide a old password"
                },
                "pass": {
                    required: "Please provide new password",
                    minlength: "Your password must be at least 6 characters long"
                },
                "confirm-pass": {
                    required: "Please provide confirm password",
                    minlength: "Your password must be at least 6 characters long",
                    equalTo: "Please enter the same password as above"
                },
                
                "name": {
                    required: "Please provide name",
                    // lettersonly: "Please provide lettersonly",
                    maxlength: "Your name max 20 characters long",
                    minlength: "Your name at least 3 characters long"
                },
                
                "image": {
                    required: "Please provide image"
                },
                "phone_code": {
                    required: "Please provide phone code ex. 971",
                    number: "Please enter a valid number format ex. 123"
                },
                "mobile": {
                    required: "Please provide phone number ex. 88888888888",
                    number: "Please enter a valid number format ex. 123",
                    maxlength: "Your phone number max 12 characters long",
                    minlength: "Your phone number at least 8 characters long"
                },
                "description": {
                    required: "Please provide description"
                }
            }
        })
    }
    return {
        init: function () {
            e(); jQuery(".form-control").on("change", function () {
                jQuery(this).valid()
            });
            jQuery("input[type=file]").on("change", function () {
                jQuery(this).valid();
            });
        }
    }
}();
jQuery(function () {
    form_validation.init()
});
