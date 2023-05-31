function showToast(status) {
    let toast = ''

    if (status)
        toast = new bootstrap.Toast(document.getElementById('successToast'))
    else
        toast = new bootstrap.Toast(document.getElementById('failedToast'))

    toast.show()
}

$(document).ready(function() {
    AOS.init();
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document.body).on("change", ".fleetFilter", function() {
        const id = $(this).val()
        $('input[name="vehicle_type"]').next().removeClass('btn-primary');
        $('input[name="vehicle_type"]').next().removeClass('text-light');

        if ($(this).is(':checked')) {
            $(this).next().addClass('btn-primary');
            $(this).next().addClass('text-light');
        }

        $.ajax({
            url : '/filterFleet/' + id,
            method : 'post',
            cache : true,
            success : function(response) {
                $(".cars").empty();

                let view = '';
                $.each(response, function(i) {  
                    view += `<div class="col-md-4 col-sm-6 col-11 m-0 p-3 car">
                        <figure class="figure bg-secondary p-4 rounded d-flex justify-content-center align-items-center w-100">
                            <img src="` + response[i].vehicle_image + `" class="figure-img img-fluid rounded d-flex justify-content-center align-items-center" alt="` + response[i].brand + ' ' + response[i].model + `">
                        </figure>
                        <p class="fw-semibold mt-1">` + response[i].brand + ' ' + response[i].model + `</p>
                        <span class="badge text-dark d-flex align-items-center justify-content-start">
                            <img src="/storage/website-assets/group.png" alt="" height="25px">
                            <span class="ps-2 fs-6">` + response[i].capacity + `</span>
                            <img src="/storage/website-assets/baggage.png" alt="" height="25px" class="ps-3">
                        <span class="ps-2 fs-6">` + response[i].trunk + `</span>
                        </span>
                    </div>`
                });

                $(".cars").html(view);
                document.querySelector(".cars").scrollTo({left : -100});
            }
        })
    })

    function scroll(direction) {
        let containerWidth = document.querySelector(".car").offsetWidth
        let total = document.querySelector(".cars").scrollWidth - document.querySelector('.cars').offsetWidth
        let current = document.querySelector(".cars").scrollLeft

        if (direction == 'right') {
            if (current + containerWidth < total)
                document.querySelector(".cars").scrollTo({left : current + containerWidth, behavior : "smooth"})
            else
                document.querySelector(".cars").scrollTo({left : -1, behavior : "smooth"})
        }
        else if (direction == 'left') {
            if (current - containerWidth > -1)
                document.querySelector(".cars").scrollTo({left : current - containerWidth, behavior : "smooth"})
            else
                document.querySelector(".cars").scrollTo({left : total, behavior : "smooth"})
        }
    }

    setInterval(function() {scroll('right')}, 5000);

    $(".next").on('click', function() {
        scroll('right')
    })

    $(".prev").on('click', function() {
        scroll('left')
    })

    if ($("#showToast")) {
        $("#showToast").click();
    }
    
})