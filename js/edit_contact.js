"use strict";


function edit_contact(id, e) {

    $('tr').each(function () {
        if ($(this).attr('id') == id) {
            $(this).find('.glyphicon-pencil').removeClass('glyphicon-pencil').addClass('glyphicon-saved');

            let fname = $(this).find('.first_name');
            fname.wrapInner("<input type='text' name='first_name' value=" + fname.text() + ">");
            let lname = $(this).find('.last_name');
            lname.wrapInner("<input type='text' name='last_name' value=" + lname.text() + ">");
            let email = $(this).find('.email');
            email.wrapInner("<input type='text' name='email_name' value=" + email.text() + ">");
            let phone = $(this).find('.phone');
            phone.wrapInner("<input type='text' name='phone_name' value=" + phone.text() + ">");
        }

        // $(this).find('.glyphicon-saved').on('click', function(){
        //     $.ajax({
        //         url: 'api/users/' + id,
        //         type: 'PUT',
        //         data: data,
        //         success : '',
        //     })
        // });
    });
}

