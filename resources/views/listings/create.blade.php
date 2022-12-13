<x-layout>
    <link rel="stylesheet" types = "text/css" href="/css/createListing.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="listings-parent-container crud" style="padding-bottom: 50px; padding-top: 50px; margin-top:50px;">
        <div class ="container">
           <div class="createListingSection">
                <div class="back-button">
                    <a href="javascript:history.back()" class="button1 b-button">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div> 

                <div class="info">
                    <h1>Lorem ipsum dolor sit amet consectetur.</h1>

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus eum tempore nam consectetur, possimus dolorum quidem tempora et laboriosam est deleniti sunt modi, provident quasi!</p>
                    <br>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptate temporibus ab excepturi doloremque cumque.</p>
                </div>
                <div class = "listingFormContainer">

                    {{-- SOURCE CODE FROM CODE PEN --}}
                    {{-- LINK: https://codepen.io/webbarks/pen/QWjwWNV --}}
                    <div id="svg_wrap"></div>
                    <h1>Post An Item!</h1>
                    <form class="listingForm" method = "POST" action="/listings" id="listingForm"
                    enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="user_id"  value="{{ old('iser_id', '3') }}"
                        >
                        
                        {{-- card #1 --}}
                        <section class = "listingCard default-card">
                            <p class="create-listing-header">Item Description</p>
                            <input type="text" name = "item_name" placeholder="Item Title" pattern="^[a-zA-Z0-9 ]+$" oninvalid="this.setCustomValidity('Please use upper or lower case letters A-Z and numbers 0-9 only. Item title must be 80 characters or less')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" maxlength = "80" value="{{ old('item_name', null) }}" />
                            @error('item_name')
                                <p>{{$message}}</p>
                            @enderror
                            <input type="number" onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 189) ? false : true" min="0" name = "price" max="10000" step="0.01" placeholder="Price or 0 for free" value="{{ old('price', null) }}" id="price-input"/>
                            @error('price')
                                <p>{{$message}}</p>
                            @enderror
                            
                            <p class="create-listing-header">
                                Price Negotiable, Fixed, or Free
                            </p>
                            <div class="condition-box">
                                <select name="negotiable" id="price-type">
                                    <option value="Fixed" {{ (old("negotiable") == 'Fixed' ? "selected":"") }}>Fixed</option>
                                    
                                    <option value="Negotiable" {{ (old("negotiable") == 'Negotiable' ? "selected":"") }}>Negotiable/ OBO (best offer)</option>

                                    <option value="Free" {{ (old("negotiable") == 'Free' ? "selected":"") }}>Free</option>
                                </select>
                                @error('negotiable')
                                    <p>{{$message}}</p>
                                @enderror
                            </div>

                            <p class="create-listing-header">Condition</p>
                            <div class ="conditionBox">
                                <select name="condition" id="">
                                    <option value="New" {{ (old("condition") == 'New' ? "selected":"") }}>New</option>
                                    <option value="Good" {{ (old("condition") == 'Good' ? "selected":"") }}>Good</option>
                                    <option value="Slightly Used" {{ (old("condition") == 'Slightly Used' ? "selected":"") }}>Slightly Used </option>
                                    <option value="Used Normal Wear" {{ (old("condition") == 'Used Normal Wear' ? "selected":"") }}>Used Normal Wear </option>
                                </select>
                                @error('condition')
                                    <p>{{$message}}</p>
                                @enderror
                            </div>

                            <p class="create-listing-header">Categories</p>
                            <div class ="conditionBox">
                                <ul class="ks-cboxtags">
                                    <li>
                                        <input type="checkbox" name="category[]" id="checkboxSix" value="Furniture" 
                                        {{ old('category.0') == 'Furniture' ? 'checked' : '' }}
                                        {{ old('category.1') == 'Furniture' ? 'checked' : '' }}
                                        {{ old('category.2') == 'Furniture' ? 'checked' : '' }}
                                        {{ old('category.3') == 'Furniture' ? 'checked' : '' }}
                                        {{ old('category.4') == 'Furniture' ? 'checked' : '' }}
                                        {{ old('category.5') == 'Furniture' ? 'checked' : '' }}
                                        >
                                        <label for="checkboxSix"
                                        >Furniture</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="category[]" id="checkboxSeven" value="Clothes"
                                        {{ old('category.0') == 'Clothes' ? 'checked' : '' }}
                                        {{ old('category.1') == 'Clothes' ? 'checked' : '' }}
                                        {{ old('category.2') == 'Clothes' ? 'checked' : '' }}
                                        {{ old('category.3') == 'Clothes' ? 'checked' : '' }}
                                        {{ old('category.4') == 'Clothes' ? 'checked' : '' }}
                                        {{ old('category.5') == 'Clothes' ? 'checked' : '' }}
                                        >
                                        <label for="checkboxSeven">Clothes</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="category[]" id="checkboxEight" value="Electronics" 
                                        {{ old('category.0') == 'Electronics' ? 'checked' : '' }}
                                        {{ old('category.1') == 'Electronics' ? 'checked' : '' }}
                                        {{ old('category.2') == 'Electronics' ? 'checked' : '' }}
                                        {{ old('category.3') == 'Electronics' ? 'checked' : '' }}
                                        {{ old('category.4') == 'Electronics' ? 'checked' : '' }}
                                        {{ old('category.5') == 'Electronics' ? 'checked' : '' }}
                                        >
                                        <label for="checkboxEight">Electronics</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="category[]" id="checkboxNine" value="Kitchen"
                                        {{ old('category.0') == 'Kitchen' ? 'checked' : '' }}
                                        {{ old('category.1') == 'Kitchen' ? 'checked' : '' }}
                                        {{ old('category.2') == 'Kitchen' ? 'checked' : '' }}
                                        {{ old('category.3') == 'Kitchen' ? 'checked' : '' }}
                                        {{ old('category.4') == 'Kitchen' ? 'checked' : '' }}
                                        {{ old('category.5') == 'Kitchen' ? 'checked' : '' }}
                                        >
                                        <label for="checkboxNine">Kitchen</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="category[]" id="checkboxTen" value="School Accessories"
                                        {{ old('category.0') == 'School Accessories' ? 'checked' : '' }}
                                        {{ old('category.1') == 'School Accessories' ? 'checked' : '' }}
                                        {{ old('category.2') == 'School Accessories' ? 'checked' : '' }}
                                        {{ old('category.3') == 'School Accessories' ? 'checked' : '' }}
                                        {{ old('category.4') == 'School Accessories' ? 'checked' : '' }}
                                        {{ old('category.5') == 'School Accessories' ? 'checked' : '' }}
                                        >
                                        <label for="checkboxTen">School Accessories</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="category[]" id="checkboxEleven" value="Books"
                                        {{ old('category.0') == 'Books' ? 'checked' : '' }}
                                        {{ old('category.1') == 'Books' ? 'checked' : '' }}
                                        {{ old('category.2') == 'Books' ? 'checked' : '' }}
                                        {{ old('category.3') == 'Books' ? 'checked' : '' }}
                                        {{ old('category.4') == 'Books' ? 'checked' : '' }}
                                        {{ old('category.5') == 'Books' ? 'checked' : '' }}
                                        >
                                        <label for="checkboxEleven">Books</label>
                                    </li>
                                </ul>
                                @error('category')
                                    <p>{{$message}}</p>
                                @enderror
                            </div>        
                        </section>

                        {{-- card #2 --}}
                        <section class = "listingCard">
                            <p class="create-listing-header">Sub-Categories/ Tags (comma seperated)</p>
                            <input name = "tags" type="text" placeholder="Tags" pattern="^[a-zA-Z0-9, ]+$" oninvalid="this.setCustomValidity('Please use upper or lower case letters A-Z and numbers 0-9 only. Total tags must be 80 characters or less')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" maxlength = "80" value="{{ old('tags', null) }}"/>
                            @error('tags')
                                <p>{{$message}}</p>
                            @enderror
                            <textarea name="description" placeholder="Description" maxlength = "400" rows="3" style="resize: none;">{{ old('description', null) }}</textarea>
                            @error('description')
                                <p>{{$message}}</p>
                            @enderror
                            <p class="create-listing-header">Attach Images</p>
                            <input class="imgUpload" type="file" id="image_uploads" name="image_uploads[]" accept=".jpg, .jpeg, .png" multiple >
                            <p class="create-listing-header">Accepted Images</p>
                            <div class="preview">
                                <h6>Please select up to 5</h6>
                            </div>
                            @error('image_uploads')
                                <p>{{$message}}</p>
                            @enderror
                        </section>

                        {{-- card #3 --}}
                        <section class = "listingCard">
                            <p class="create-listing-header">Location</p>
                            <input type="text" id = "street" name="street" placeholder="Enter a Location*" pattern="^[a-zA-Z0-9 ]+$" oninvalid="this.setCustomValidity('Please use upper or lower case letters A-Z and numbers 0-9 only')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" value="{{ old('street', null) }}"/>
                            @error('street')
                                <p>{{$message}}</p>
                            @enderror
                            <input type="text" id = "apartment_floor" name="apartment_floor" placeholder="Apartment, unit, suite, or floor #" pattern="^[a-zA-Z0-9 ]+$" oninvalid="this.setCustomValidity('Please use upper or lower case letters A-Z and numbers 0-9 only')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" value="{{ old('apartment_floor', null) }}"/>
                            <input type="text" id = "city" name = "city" placeholder="City*" pattern="^[a-zA-Z ]+$" oninvalid="this.setCustomValidity('Please use upper or lower case letters A-Z')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" value="{{ old('city', null) }}"/>
                            @error('city')
                                <p>{{$message}}</p>
                            @enderror
                            <input type="text" id = "state" name = "state" placeholder="State*" pattern="^((A[LKSZR])|(C[AOT])|(D[EC])|(F[ML])|(G[AU])|(HI)|(I[DLNA])|(K[SY])|(LA)|(M[EHDAINSOT])|(N[EVHJMYCD])|(MP)|(O[HKR])|(P[WAR])|(RI)|(S[CD])|(T[NX])|(UT)|(V[TIA])|(W[AVIY]))$" oninvalid="this.setCustomValidity('Please enter your 2 upper case letter state code ie: Virginia - VA')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" maxlength="2" value="{{ old('state', null) }}"/>
                            @error('state')
                                <p>{{$message}}</p>
                            @enderror
                            <input type="text" id = "country" name = "country" placeholder="Country*" pattern="^[a-zA-Z ]+$" oninvalid="this.setCustomValidity('Please use upper or lower case letters A-Z')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" value="{{ old('country', null) }}" />
                            @error('country')
                                <p>{{$message}}</p>
                            @enderror
                            <input type="text" id = "postcode" name = "postcode" placeholder="Postcode*" pattern="^\d{5}(?:[-\s]\d{4})?$" oninvalid="this.setCustomValidity('Please enter in your zipcode ie: 12345 or 12345-6789')"
                            onchange="try{setCustomValidity('')}catch(e){}"  oninput="setCustomValidity(' ')" maxlength="10" value="{{ old('postcode', null) }}" />
                            @error('postcode')
                                <p>{{$message}}</p>
                            @enderror
                        </section>


                        <div class = "listingButtonsContainer">
                            <div class="button" id="prev">&larr; Previous</div>
                            <div class="button" id="next">Next &rarr;</div>
                            <button class="submit-create-listing button" id="submit" type="submit">
                                Submit
                            </button>
                            {{-- <div class="button" id="submit" type="submit">Post</div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function(){
            $('#price-type').change(function(){
                if($(this).val() == 'Free'){
                    $('#price-input').val(0);
                    $('#price-input').attr('readonly', true);
                }else{
                    $('#price-input').attr('readonly', false);
                }
            });
        });
        function initAutocomplete() {
            address1Field = document.getElementById("street");
            address2Field = document.getElementById("apartment_floor");
            postalField = document.getElementById("postcode");

            // Create the autocomplete object, restricting the search predictions to
            // addresses in the US and Canada.
            autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["us"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
            });
            address1Field.focus();

            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            const place = autocomplete.getPlace();
            let address1 = "";
            let postcode = "";

            // Get each component of the address from the place details,
            // and then fill-in the corresponding field on the form.
            // place.address_components are google.maps.GeocoderAddressComponent objects
            // which are documented at http://goo.gle/3l5i5Mr
            for (const component of place.address_components) {
                // @ts-ignore remove once typings fixed
                const componentType = component.types[0];

                switch (componentType) {
                    case "street_number": {
                        address1 = `${component.long_name} ${address1}`;
                        break;
                    }
                    
                    case "route": {
                        address1 = `${address1}${component.long_name} `;
                        break;
                    }

                    case "postal_code": {
                        postcode = `${component.long_name}${postcode}`;
                        break;
                    }

                    case "postal_code_suffix": {
                        postcode = `${postcode}-${component.long_name}`;
                        break;
                    }

                    case "locality":{
                        (document.getElementById("city")).value =
                        component.long_name;
                        break;
                    }

                    case "administrative_area_level_1": {
                        (document.getElementById("state")).value =
                        component.short_name;
                        break;
                    }

                    case "country":{
                        (document.getElementById("country")).value =
                        component.long_name;
                        break;
                    }
                }
            }
            address1Field.value = address1;
            postalField.value = postcode;

            // After filling the form with address components from the Autocomplete
            // prediction, set cursor focus on the second address line to encourage
            // entry of subpremise information such as apartment, unit, or floor number.
            address2Field.focus();
        }

        // source code from code pen
        // link: https://codepen.io/webbarks/pen/QWjwWNV
        // script to change between view cards for create listing
        $( document ).ready(function() {
            var base_color = "black";
            // var active_color = "rgb(237, 40, 70)";
            var active_color = "#db6657";

            var child = 1;
            var length = $("section").length - 1;
            $("#prev").addClass("disabled");
            $("#submit").addClass("disabled");

            $("section").not("section:nth-of-type(1)").hide();
            $("section").not("section:nth-of-type(1)").css('transform','translateX(100px)');

            var svgWidth = length * 200 + 24;
            $("#svg_wrap").html(
            '<svg version="1.1" id="svg_form_time" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 ' +
                svgWidth +
                ' 24" xml:space="preserve"></svg>'
            );

            function makeSVG(tag, attrs) {
                var el = document.createElementNS("http://www.w3.org/2000/svg", tag);
                for (var k in attrs) 
                    el.setAttribute(k, attrs[k]);
                return el;
            }

            for (i = 0; i < length; i++) {
                var positionX = 12 + i * 200;
                var rect = makeSVG("rect", { x: positionX, y: 9, width: 200, height: 6 });
                document.getElementById("svg_form_time").appendChild(rect);
                // <g><rect x="12" y="9" width="200" height="6"></rect></g>'
                var circle = makeSVG("circle", {
                    cx: positionX,
                    cy: 12,
                    r: 12,
                    width: positionX,
                    height: 6
                });
                document.getElementById("svg_form_time").appendChild(circle);
            }

            var circle = makeSVG("circle", {
                cx: positionX + 200,
                cy: 12,
                r: 12,
                width: positionX,
                height: 6
            });
            document.getElementById("svg_form_time").appendChild(circle);

            $('#svg_form_time rect').css('fill',base_color);
            $('#svg_form_time circle').css('fill',base_color);
            $("circle:nth-of-type(1)").css("fill", active_color);

            
            $(".button").click(function () {
                $("#svg_form_time rect").css("fill", active_color);
                $("#svg_form_time circle").css("fill", active_color);
                var id = $(this).attr("id");
                if (id == "next") {
                    $("#prev").removeClass("disabled");
                    if (child >= length) {
                    $(this).addClass("disabled");
                    $('#submit').removeClass("disabled");
                    }
                    if (child <= length) {
                    child++;
                    }
                } else if (id == "prev") {
                    $("#next").removeClass("disabled");
                    $('#submit').addClass("disabled");
                    if (child <= 2) {
                    $(this).addClass("disabled");
                    }
                    if (child > 1) {
                    child--;
                    }
                }
                var circle_child = child + 1;
                $("#svg_form_time rect:nth-of-type(n + " + child + ")").css(
                    "fill",
                    base_color
                );
                $("#svg_form_time circle:nth-of-type(n + " + circle_child + ")").css(
                    "fill",
                    base_color
                );
                var currentSection = $("section:nth-of-type(" + child + ")");
                currentSection.fadeIn();
                currentSection.css('transform','translateX(0)');
                currentSection.css('display', 'flex');
                currentSection.css('flex-direction', 'column');

                currentSection.prevAll('section').css('transform','translateX(-100px)');
                currentSection.nextAll('section').css('transform','translateX(100px)');
                $('section').not(currentSection).hide();
            });

        });


        // source code link: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
        //script to process img upload and show previews
        const input = document.querySelector('.imgUpload');
        const preview = document.querySelector('.preview');

        var canSubmit = true;
        $(document).ready(function(){
            $('form').submit(function(e){
                for(const tempFile of input.files){
                    if(validFileType(tempFile)) {
                        if (tempFile.size > 5*1024*1024) {
                            alert("Too large Image. Only images smaller than 5MB can be uploaded. Only images smaller then 5MB will be kept");
                            e.preventDefault();
                            canSubmit = false;
                            break;
                        }
                    }
                }      
                if(canSubmit){$('form').unbind('submit').submit();}
            });
        });

        // input.style.opacity = 0;
        input.addEventListener('change', updateImageDisplay);
        function updateImageDisplay() {
            while(preview.firstChild) {
                preview.removeChild(preview.firstChild);
            }

            const curFiles = input.files;
            if(curFiles.length === 0) {
                const para = document.createElement('p');
                para.textContent = 'No files selected';
                preview.appendChild(para);
            }else if(curFiles.length >5){
                const para = document.createElement('p');
                para.textContent = 'Please select less than 5 images';
                preview.appendChild(para);
                input.value = null;
            } else {
                const list = document.createElement('ul');
                list.className="user-img-list";
                preview.appendChild(list);

                var userAlerted = false;
                for(const file of curFiles) {
                    const listItem = document.createElement('li');
                    const para = document.createElement('p');
                    if(validFileType(file)) {
                        const image = document.createElement('img');
                        image.src = URL.createObjectURL(file);

                        listItem.appendChild(image);

                        if (file.size > 5*1024*1024 ) {
                            if(!userAlerted){
                                alert("Too large Image. Only images smaller than 5MB can be uploaded. Only images smaller then 5MB will be kept");
                                userAlerted=true;
                            }
                            para.innerHTML = returnFileSize(file.size) + '<i class="fa fa-times" aria-hidden="true"></i>';
                            para.classList.add("file-details", "not-approved");
                        }else{ //the approved images with a check mark
                            para.innerHTML = returnFileSize(file.size) + '<i class="fa fa-check" aria-hidden="true"></i>';
                            para.classList.add("file-details", "approved");
                        }
                        listItem.appendChild(para);
                    } else {
                        para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
                        listItem.appendChild(para);
                    }

                    list.appendChild(listItem);
                }
            }
        }

        const fileTypes = [
            "image/apng",
            "image/bmp",
            "image/gif",
            "image/jpeg",
            "image/pjpeg",
            "image/png",
            "image/svg+xml",
            "image/tiff",
            "image/webp",
            "image/x-icon"
        ];

        function validFileType(file) {
            return fileTypes.includes(file.type);
        }

        function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } else if(number >= 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + 'KB';
            } else if(number >= 1048576) {
                return (number/1048576).toFixed(1) + 'MB';
            }
        }
        
    </script>
    <script async
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2Umn-3TUxP23ok373mWr0U4CHQDItcEk&callback=initAutocomplete&libraries=places&v=weekly"
      defer
    ></script>
</x-layout>