$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Filter Ajax
    function getData() {
        let filter = {
            brand : [],
            type : [],
            transmission : [],
            capacity : [
                $("#minCapacity").val() != "" ? $("#minCapacity").val() : 0, 
                $("#maxCapacity").val() != "" ? $("#maxCapacity").val() : 50,
            ],
            price : [
                $("#minPrice").val() != "" ? $("#minPrice").val() : 0, 
                $("#maxPrice").val() != "" ? $("#maxPrice").val() : 50000000
            ],
            sort : $('select[name=sort] option').filter(":selected").val(),
            search : $("#searchbar").val(),
        }

        $('input[name="brand[]"]:checked').each(function() {
            filter.brand.push($(this).val());
        });

        $('input[name="transmission[]"]:checked').each(function() {
            filter.transmission.push($(this).val());
        });

        $('input[name="type[]"]:checked').each(function() {
            filter.type.push($(this).val());
        });

        if (filter.brand.length == 0)
            delete filter.brand
        if (filter.transmission.length == 0)
            delete filter.transmission
        if (filter.type.length == 0)
            delete filter.type
        if (filter.search == '')
            delete filter.search

        $.ajax({
            url : "/rent/filterVehicle",
            method : 'get',
            data : {
                filters : filter
            },
            success : function(response) {
                if (response == '') {
                    $(".cars").empty()
                    $(".cars").html("<h5 class='text-center'>No vehicle found</h5>")
                }
                else {
                    let element = ''
    
                    $.each(response, function(i) {
                        element += `<div class="col-12 tile mt-3">
                            <div class="row p-3 h-100">
                                <div class="col-md-6 px-3 d-flex justify-content-center align-items-center">
                                    <img src="` + response[i].vehicle_image + `" alt="` + response[i].model + `" class="w-100 img-fluid car-img">
                                </div>
            
                                <div class="col-md-6 d-flex flex-column justify-content-center">
                                    <h6>` + response[i].brand + ' ' + response[i].model + `</h6>
                                    <h4 class="fw-semibold text-primary">
                                        Rp` + response[i].daily_rate.toLocaleString("de-DE") + `/day</span>
                                    </h4>
                                    <span class="badge fw-normal d-flex align-items-center justify-content-start">
                                        <img src="/website-assets/people.png" alt="" height="25px">
                                        <span class="ps-2 fs-6"> ` + response[i].capacity + `</span>
                                        <img src="/website-assets/baggage.png" alt="" height="25px" class="ps-3">
                                        <span class="ps-2 fs-6">` + response[i].trunk + `</span>
                                    </span>

                                    <a href="/rent/vehicles/` + response[i].model + `"><button class="btn btn-primary w-50 mt-3">Select</button></a>
                                </div>
                            </div>
                        </div>`
                    })
                    
                    $(".cars").empty()
                    $(".cars").html(element)
                }
            }
        })
    }

    // Boundary for price and capacity input
    function inputBoundary(minElement, maxElement, min, max) {
        let minElementVal = parseInt($(minElement).val());
        let maxElementVal = parseInt($(maxElement).val());

        if (minElementVal < min) {
            $(minElement).val(min)
            minElementVal = min
        }

        if (maxElementVal > max) {
            $(maxElement).val(max)
            maxElementVal = max
        }

        if (minElementVal > max) {
            $(minElement).val(max)
            minElementVal = max
        }
        
        if (maxElementVal < min) {
            $(maxElement).val(min)
            maxElementVal = min
        }

        if (minElementVal > maxElementVal && maxElementVal != '') {
            $(minElement).val(maxElementVal)
            minElementVal = maxElementVal
        }

        if (maxElementVal < minElementVal && minElementVal != '') {
            $(maxElement).val(minElementVal)
            maxElementVal = minElementVal
        }
    }

    $(document.body).on("change", "#minPrice, #maxPrice, #minCapacity, #maxCapacity", function() {

        if ($(this).attr("id").includes("Price"))
            inputBoundary('#minPrice', '#maxPrice', 0, 50000000);
        else if ($(this).attr("id").includes("Capacity"))
            inputBoundary('#minCapacity', '#maxCapacity', 0, 50);
            
    })
    
     // Filters
    $(document.body).on("change", "#sort, .filter input, #searchbar", function() {
        getData()
    })
    
    // Reset filter
    $("#clear").on("click", function() {
        $('input[name="brand[]"]:checked, input[name="transmission[]"]:checked, input[name="type[]"]:checked').prop('checked', false);
        $("#minPrice").val('');
        $("#maxPrice").val('');
        $("#minCapacity").val('');
        $("#maxCapacity").val('');

        getData()
    }) 

    // Search vehicles
    $(document.body).on('click', "#search", function() {
        getData()
    })

    $(document.body).on('submit change', '#searchbar', function() {
        getData()
    })
});