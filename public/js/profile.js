let full_name = ''
let birth_date = ''
let email = ''
let phone = ''
let city = ''

$(document).ready(function() {
    $(document.body).on("click", '#showPass', function() {
        $(this).parent().find('input').prop('type', 'text');
        $(this).parent().find("#showPass").hide();
        $(this).parent().find("#hidePass").show();
    })
    
    $(document.body).on("click", '#hidePass', function() {
        $(this).parent().find('input').prop('type', 'password');
        $(this).parent().find("#showPass").show();
        $(this).parent().find("#hidePass").hide();
    })
})

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function edit() {
    full_name = $("#name").val()
    birth_date = $("#birth_date").val()
    email = $("#email").val()
    phone = $("#phone").val()
    city = $("#city").val()

    $("#edit_profile_form input").not("#password, #email").addClass('form-control');
    $("#edit_profile_form input").not("#password, #email").attr('readonly', false);
    $("#edit_profile_form input").not("#password, #email").prop('disabled', false);
    $("#edit_profile_form input").not("#password, #email").removeClass('form-control-plaintext');

    $(".action_btn").empty()
    $(".action_btn").removeClass("justify-content-end")
    $(".action_btn").addClass("justify-content-center")
    $(".action_btn").append(`
        <div class="row w-100 p-0">
            <div class="col-6 px-1">
                <button type="button" class="btn btn-outline-danger w-100 h-100" id="cancel_btn" onclick="cancel()">Cancel</button>
            </div>
            <div class="col-6 px-1">
                <button type="button" class="btn btn-primary w-100 h-100" id="save_btn" onclick="save()">Save</button>
            </div>
        </div>
    `)
}

function save() {
    $.ajax({
        url : '/user/profile/edit',
        type : 'post',
        data : {
            name : $("#name").val(),
            email : $("#email").val(),
            birth_date : $("#birth_date").val(),
            phone : $("#phone").val(),
            city : $("#city").val(),
        },
        success : function(response) {
            if (response == 0) {
                $("#name").val(full_name)
                $("#email").val(email)
                $("#birth_date").val(birth_date)
                $("#phone").val(phone)
                $("#city").val(city)

                showToast('failedUpdate')
            }
            else if (response == 1) {
                showToast('successUpdate')
            }
        
            $("#edit_profile_form input").not("#password, #email").addClass('form-control-plaintext');
            $("#edit_profile_form input").not("#password, #email").attr('readonly', true);
            $("#edit_profile_form input").not("#password, #email").prop('disabled', true);
            $("#edit_profile_form input").not("#password, #email").removeClass('form-control');
        
            $(".action_btn").removeClass("justify-content-center")
            $(".action_btn").addClass("justify-content-end")
            $(".action_btn").empty()
            $(".action_btn").append(`<button class="btn" id="edit_profile" type="button" onclick="edit()"><i class="fa-solid fa-pencil fa-lg"></i></button>`)
        },
    })
}

function cancel() {
    $("#name").val(full_name)
    $("#email").val(email)
    $("#birth_date").val(birth_date)
    $("#phone").val(phone)
    $("#city").val(city)

    $("#edit_profile_form input").not("#password, #email").addClass('form-control-plaintext');
    $("#edit_profile_form input").not("#password, #email").attr('readonly', true);
    $("#edit_profile_form input").not("#password, #email").prop('disabled', true);
    $("#edit_profile_form input").not("#password, #email").removeClass('form-control');

    $(".action_btn").empty()
    $(".action_btn").removeClass("justify-content-center")
    $(".action_btn").addClass("justify-content-end")
    $(".action_btn").append(`<button class="btn" id="edit_profile" type="button" onclick="edit()"><i class="fa-solid fa-pencil fa-lg"></i></button>`)
}

function showToast(id) {
    new bootstrap.Toast(document.getElementById(id)).show()
}

$("#toastBtn").click()