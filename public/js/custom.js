$(document).ready(function() {
    $('#service_add_more').click(function() {
        var rental_dates_clone = $('.rental_dates').first().clone();    
        var inputs = rental_dates_clone.find('input, textarea');  
        var newIndex = parseInt($('#service_add_more').attr('newIndex')) + 1;  

        rental_dates_clone.attr('class', function(index, className) {
            return className.replace(/rental_date_\d+/, 'rental_date_' + newIndex);
        });      
        
        inputs.each(function() {
            var name = $(this).attr('name').replace('[1]', '[' + newIndex + ']');
            $(this).attr('name', name);
            var originalInput = $('input[name="' + name.replace(/\[\d\]/, '[1]') + '"]');
            if ($(this).is('.copy_value')) {
                $(this).val(originalInput.val()); 
            } else if ($(this).is(':checkbox')) {
                $(this).prop('checked', false);
            } else {
                $(this).val(''); 
            }
        });
        rental_dates_clone.find('.arrival_time_div').removeClass('arrival_time_div_show');
        rental_dates_clone.find('.departure_time_div').removeClass('departure_time_div_show');   

        $('.rental_dates_div').append(rental_dates_clone);
        $('#service_add_more').attr('newIndex', newIndex);
        
        if ($('.rental_dates').length > 1) {
            $('.service_minus_div').show();
        } else {
            $('.service_minus_div').hide();
        }
    });

    $(document).on('click', '.checkin', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.rental_dates').find('.arrival_time_div').addClass('arrival_time_div_show');
            $(this).closest('.rental_dates').find('.arrival_time').prop('required', true);
            $('.arrival_time_div').show();
        } else {
            $(this).closest('.rental_dates').find('.arrival_time_div').removeClass('arrival_time_div_show');
            $(this).closest('.rental_dates').find('.arrival_time').prop('required', false);
            $('.arrival_time_div').hide();
        }
    });
    $(document).on('click', '.checkout', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.rental_dates').find('.departure_time_div').addClass('departure_time_div_show');
            $(this).closest('.rental_dates').find('.departure_time').prop('required', true);
             $('.departure_time_div').show();
        } else {
            $(this).closest('.rental_dates').find('.departure_time_div').removeClass('departure_time_div_show');
            $(this).closest('.rental_dates').find('.departure_time').prop('required', false);
            $('.departure_time_div').hide();
        }
    });

});






$(document).on('click', '.service_minus', function() {
    $(this).closest('.rental_dates').remove();
    if ($('.rental_dates').length > 1) {
        $('.service_minus_div').show();
    } else {
        $('.service_minus_div').hide();
    }
});



$(document).ready(function() {
    $(document).on('click', '.service_add_more_tr', function() {
        var originalRow = $('.services_table tbody .clone_tr').last();
        var newRow = originalRow.clone(); 
        var newIndex = parseInt($('.service_add_more_tr').attr('newIndex')) + 1; 
        var originalTrunitValue = originalRow.find('.copy_value').val();
        var originalTrroomcodeValue = originalRow.find('.copy_room_code').val();

         newRow.attr('class', function(index, className) {
            return className.replace(/unit_item_\d+/, 'unit_item_' + newIndex);
        });

        newRow.find('.arrival_time').removeClass('arrival_time_show');
        newRow.find('.departure_time').removeClass('departure_time_show');

        newRow.find('.copy_value:first').val(originalTrunitValue);

        newRow.find('input:not(.copy_value), textarea').val('');

        newRow.find('input[type="checkbox"]').prop('checked', false).val(1);
        newRow.find('input, textarea, select, checkbox').attr('name', function(index, oldName) {
            return oldName.replace(/\[\d+\]/g, '[' + newIndex + ']');
        });

        // Check the original row's .checkout checkbox
        var isChecked = originalRow.find('.checkout').is(':checked');
        // If the original .checkout was checked, disable the new .checkout
        if (isChecked) {
            newRow.find('.checkin').prop('disabled', true);
        } else {
            newRow.find('.checkin').prop('disabled', false);
        }

        $('tbody').append(newRow);
        $('.service_add_more_tr').attr('newIndex', newIndex);
        if ($('.services_table tbody tr').length > 1) {
            $('.service_minus_more_tr').show();
        } else {
            $('.service_minus_more_tr').hide();
        }
    });

    $(document).on('click', '.checkin', function() {
        if ($(this).is(':checked')) {
            $(this).closest('tr').find('.arrival_time').addClass('arrival_time_show').prop('required', true);
        } else {
            $(this).closest('tr').find('.arrival_time').removeClass('arrival_time_show').prop('required', false);
        }
    });
     $(document).on('click', '.checkout', function() {
        if ($(this).is(':checked')) {
            $(this).closest('tr').find('.departure_time').addClass('departure_time_show').prop('required', true);
        } else {
            $(this).closest('tr').find('.departure_time').removeClass('departure_time_show').prop('required', false);
        }
    });

});





$(document).on('click', '.service_minus_more', function() {
    $(this).closest('tr').remove();
    if ($('.services_table tbody tr').length > 1) {
        $('.service_minus_more_tr').show();
    } else {
        $('.service_minus_more_tr').hide();
    }
});



/*$(document).ready(function() {
    $('#service_form,#service_form_mobile').on('submit', function(e) {
        e.preventDefault();         
        var formData = $(this).serialize();        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.status === 'success') {
                     $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                     setTimeout(function() {
                       window.location.href = response.redirect;
                    }, 1000);
                     
                } else {
                     $('#message').html('<div class="alert alert-success">An error occurred.</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while processing the request.');
            }
        });
    });
});*/


$(document).ready(function() {
    $('#service_form_mobile').on('submit', function(e) {
        e.preventDefault();         
        var formData = $(this).serialize();        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json', 
            success: function(response) {
                $('.error-msg').remove();
                $('.error-row').removeClass('error-row');
                if (response.status === 'success') {
                     $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                     setTimeout(function() {
                       window.location.href = response.redirect;
                    }, 1000);                     
                } else {
                     $('#message').html('<div class="alert alert-danger">An error occurred.</div>');                     
                     $.each(response.errors, function (key, error) {
                         var $errorRow = '<div class="alert alert-danger error-msg error-row-' + key + '" data-key="' + key + '"><div colspan="12">' + error + '</div>' +'</div>';
                         $('.rental_dates_div').find('.rental_date_' + key).after($errorRow);
                         $('.rental_dates_div').find('.rental_date_' + key).addClass('error-row');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while processing the request.');
            }
        });
    });
});



$(document).ready(function() {
    $('#service_form').on('submit', function(e) {
        e.preventDefault();         
        var formData = $(this).serialize();        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json', 
            success: function(response) {
                $('.error-msg').remove();
                $('.error-row').removeClass('error-row');
                if (response.status === 'success') {
                     $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                     setTimeout(function() {
                       window.location.href = response.redirect;
                    }, 1000);                     
                } else {
                     $('#message').html('<div class="alert alert-danger">An error occurred.</div>');                     
                     $.each(response.errors, function (key, error) {
                         var $errorRow = '<tr class="alert alert-danger error-msg error-row-' + key + '" data-key="' + key + '"><td colspan="12">' + error + '</td>' +'</tr>';
                         $('tbody').find('.unit_item_' + key).after($errorRow);
                         $('tbody').find('.unit_item_' + key).addClass('error-row');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while processing the request.');
            }
        });
    });
});



$(document).ready(function() {
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('.delete-form');
        $("#serviceconfirmModal").modal("show");
        $('#ok_button').click(function() {
            form.submit();
        });
    });
});



$(document).ready(function() {
     $(document).on('click', '.read-more-link', function(event) {
        event.preventDefault();
        var serviceId = $(this).data('service-id');
        var notesDiv = $('#notes-' + serviceId);
        var readMoreLink = $(this);
        if (readMoreLink.text() === 'Read more') {
            notesDiv.html(notesDiv.data('full-notes'));
            readMoreLink.text('Read less');
        } else {
            var truncatedNotes = notesDiv.data('truncated-notes');
            notesDiv.html(truncatedNotes);
            readMoreLink.text('Read more');
        }
    });
     $(document).on('click', '.read-more-link-in', function(event) {
        event.preventDefault();
        var serviceId = $(this).data('service-id');
        var notesDiv = $('#notes-in-' + serviceId);
        var readMoreLink = $(this);
        if (readMoreLink.text() === 'Read more') {
            notesDiv.html(notesDiv.data('full-notes'));
            readMoreLink.text('Read less');
        } else {
            var truncatedNotes = notesDiv.data('truncated-notes');
            notesDiv.html(truncatedNotes);
            readMoreLink.text('Read more');
        }
    });
});


$(document).ready(function() {
    if ($(window).width() <= 768) { 
        $(".read-more-link").click(function(e) {
            e.preventDefault();
            var serviceId = $(this).data("service-id");
            $("#notes-" + serviceId).text($("#notes-" + serviceId).data("full-notes"));
                $(this).remove();
            });
    }
});

$(document).ready(function() {
    $('#unit_type').change(function() {
        var selectedUrl = $(this).val();
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    });
});


$(document).ready(function() {
    $('.date_detail_more').click(function() {
        $(this).siblings('.services_date_detail_action').slideToggle();        
        var chevronIcon = $(this).find('i');
        if (chevronIcon.hasClass('fa-chevron-down')) {
            chevronIcon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        } else {
            chevronIcon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
    });
});





$(document).ready(function() {
    $('.InsertUpdateunitinfo,.assign_cleaners').click(function() {   
        var url = $(this).data('url');
        $.ajax({
            url: url,                               
            success: function(response) {
                $('#unitinfo').modal('show');
                $('#unitinfoBody').html(response).show();
                $('.js-bed-size-basic-single').select2({
                    placeholder: 'Select Bed Size',
                    width: '100%'
                });
            }
        });
    });
});


$(document).ready(function() {
    $(document).on('submit', '#unitinfoform, #owneruseredit', function(event) {
    event.preventDefault();        
    var formData = new FormData($(this)[0]); 
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));        
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'), 
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
           location.reload();
            console.log(response);
        },
        error: function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON;
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $.each(errors, function(fieldName, errorMessages) {
                console.log(fieldName + ': ' + errorMessages.join(', '));
                var inputField = $('#' + fieldName);
                inputField.addClass('is-invalid');
                inputField.next('.invalid-feedback').remove();
                inputField.after('<span class="invalid-feedback" role="alert"><strong>' + errorMessages + '</strong></span>');
            }); 

        }

    });
});
});


$(document).ready(function() {
 $('.service-show').click(function() {   
    var id = $(this).attr('service-id');
    $('#mediumModal').modal('show');
    $.ajax({
        url: '/service/calendar/edit/' + id,
        success: function(response) {
          $('#mediumBody').html(response).show();
      }
  });
});
});



$(document).ready(function() {
    // Get the selected value on page load
    var selectedBedroomType = $('.unit_select_bedroom_type_value option:selected').data('id');    
    $('.bedroom_type_value').text(selectedBedroomType);

    // Handle change event of the select element
    $(document).on('change', '.unit_select_bedroom_type_value', function() {
        var selectedBedroomType = $(this).find('option:selected').data('id');
        $('.bedroom_type_value').text(selectedBedroomType);
    });
});

$(document).ready(function() {
        $('#dateInput').change(function() {
            $('.service-assigncleaner').submit();
        });
    });






// $(document).ready(function() {
//     if ($('.collapse-item.active').length > 0) {
//         $('.collapse-item.active').closest('.collapse').addClass('show');
//     }
// });

$(document).ready(function() {
    if ($('.collapse-item.active').length > 0) {
        $('.collapse-item.active').closest('.collapse').addClass('show');
         $('#collapseservicesr').addClass('show');        
    }
});









$(document).ready(function() {
    if ($(window).width() <= 768) {
        $(".sidebar").addClass("toggled");
    }
});


