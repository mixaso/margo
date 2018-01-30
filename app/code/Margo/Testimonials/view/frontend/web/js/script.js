define([
    "jquery",
    "Magento_Customer/js/customer-data"
], function ($, customerData) {
    /** Get the modal */
    var modal = document.getElementById('testimonialModal');

    /** Get the form */
    var form = document.getElementsByClassName('testimonials__form');

    /** Get the no authentication message*/
    var noAuth = document.getElementsByClassName('modalNoAuth');

    /** Get the thank you message*/
    var thnx = document.getElementsByClassName('modalThnx');

    /** Get the button that opens the modal */
    var btn = document.getElementById("open_modal_tst");

    /** Get the <span> element that closes the modal */
    var span = document.getElementsByClassName("close")[0];

    /** Is login form enabled for current customer */
    var isActive = function () {
        var customer = customerData.get('customer');
        if(customer().fullname && customer().firstname)
        {
            return true;
        }
        return false;
    };

    /** redirect url after close modalNoAuth */
    var authUrl = "/customer/account/login/";


    /** When the user clicks on the button, open the modal */
    btn.onclick = function () {
        $(modal).css('display','block');
        if(isActive()) {
            $(form).css('display', 'block');
        }
        else {
            $(noAuth).css('display','block');
            setTimeout(function () {
                $(location).attr('href', authUrl);
            }, 5000)
        }
    };

    /** When the user clicks on <span> (x), close the modal */
    $(span).on('click', function () {
       $(modal).css('display', 'none');
       $(form).css('display', 'none');
       $(noAuth).css('display', 'none');
       $(thnx).css('display', 'none');
    });

    /** When the user clicks anywhere outside of the modal, close it */
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    function main() {
        $(document).on('submit', '.testimonials__form--js', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');

            $.ajax({
                showLoader: true,
                url: url,
                data: $(this).serialize(),
                type: "POST",
                dataType: 'json'
            }).done(function (response) {
                var message = response.message;
                if(response.errors === false) {
                    $(form).css('display', 'none');
                    $(thnx).css('display', 'block');
                    $(form)[0].reset();
                    setTimeout(function () {
                        $('.close').click();
                    }, 5000)
                } else {
                    alert(message);
                }
            });
        });
    };

    return main();
});