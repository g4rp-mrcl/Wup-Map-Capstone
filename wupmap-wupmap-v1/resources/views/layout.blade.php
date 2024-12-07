<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <title>WU-P Campus Map</title>
    <style>

        body {
            padding: 12px;
            background-image: url("images/bg.png");
            background-attachment: fixed; /* Keeps the background fixed during scrolling */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-size: cover; /* Ensures the image covers the entire background */
            background-position: center; /* Centers the image */
            background-color: #cccccc; /* Fallback color */
            height: 100vh; /* Ensures the body takes the full height of the viewport */
            overflow: auto; /* Allows scrolling if content exceeds the viewport height */
        }
        

        .logo {
        width: 100px; /* Set the desired width */
        height: 100px; /* Set the desired height */
        object-fit: cover; /* Ensure the image covers the area without distortion */
        }

        h1 {
            text-align: center; /* Center the heading */
            margin-bottom: 20px; /* Add some space below the heading */
        }
    
        .announcements {
            margin-bottom: 10px; /* Add space below announcements */
        }

        
        .navbar-custom {
            background-color:  #006A3A;
        }
        /* change the brand and text color */
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
        color: #ffffff;
        }

        /* change the link color */
        .navbar-custom .navbar-nav .nav-link {
        color: #fff;
        }
        .navbar-nav .dropdown:hover .dropdown-menu {
        display: block; /* Show dropdown on hover */
        color:#006a3a6a;
        }

       /* The dropdown container */
        /* Change the link color */
        .navbar-custom .navbar-nav .nav-link {
            color: #0b0b0b;
        }

        /* Add a red background color to navbar links on hover */
        .navbar a:hover, .dropdown:hover .dropbtn {
            background-color: #ffffff53;;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            padding: 10px; /* Add padding */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgb(0, 0, 0); /* Change icon color to white */
            border-radius: 50%; /* Make the icons circular */
            width: 40px; /* Increase width */
            height: 40px; /* Increase height */
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.7); /* Darker background on hover */
        }

        .floating-container {
            position: fixed; /* Use fixed positioning to keep it in view */
            bottom: 20px; /* Distance from the bottom of the viewport */
            right: 20px; /* Distance from the right of the viewport */
            z-index: 1000; /* Ensure it is above other elements */
        }

        .floating-button {
            background-color: #006A3A; /* Button color */
            color: #ffffff; /* Text color */
            border-radius: 50%; /* Make it circular */
            width: 60px; /* Width of the button */
            height: 60px; /* Height of the button */
            display: flex; /* Use flexbox to center the icon */
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            font-size: 24px; /* Icon size */
            cursor: pointer; /* Change cursor to pointer */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* More visible shadow */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
}

        .floating-button:hover {
            background-color:#032616; /* Darker color on hover */
        }

        .element-container {
            display: none; /* Initially hide the elements */
            position: absolute; /* Position them absolutely */
            bottom: 70px; /* Position above the button */
            right: 0; /* Align to the right */
            z-index: 1000; /* Ensure it is above other elements */
            opacity: 0; /* Start with opacity 0 for transition */
            transition: opacity 0.3s ease, visibility 0.3s ease; /* Smooth transition */
            visibility: hidden; /* Hide the container */
        }

        .element-container.active {
            display: block; /* Show the elements when active */
            opacity: 1; /* Fade in */
            visibility: visible; /* Make it visible */
        }

        .float-element {
            background-color: white; /* Background color for icons */
            box-shadow: #0b0b0b;
            border-radius: 50%; /* Make them circular */
            width: 40px; /* Width of the icon container */
            height: 40px; /* Height of the icon container */
            display: flex; /* Use flexbox to center the icon */
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            margin: 5px 0; /* Space between icons */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.542); /* Add shadow for depth */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .float-element:hover {
            background-color: #f0f0f0; /* Change background on hover */
        }

        .collapsible-button {
    background-color: #007BFF;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
    width: 100%;
    text-align: left;
}

.accordion-container {
    display: none; /* Hide accordion by default */
    padding: 0 15px;
}

.accordion-item {
    margin: 5px 0;
}

.accordion-button {
    background-color: #f1f1f1;
    border: none;
    text-align: left;
    outline: none;
    cursor: pointer;
    padding: 10px;
    width: 100%;
    transition: background-color 0.3s;
}

.accordion-button:hover {
    background-color: #ddd;
}

.accordion-content {
    display: none; /* Hide content by default */
    padding: 10px;
    border: 1px solid #ccc;
    max-height: 200px; /* Set a maximum height for the content */
    overflow-y: auto; /* Enable vertical scrolling */
}

        .map-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            max-width: 100%;
            margin: 20px auto; /* Center the container */
            border: 2px solid #007bff; /* Add a border */
            border-radius: 8px; /* Optional: rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: shadow for depth */
        }

        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none; /* Remove default iframe border */
        }

            /* Ensure the modal is responsive */
.modal-dialog {
    max-width: 90%; /* Limit the width of the modal on mobile */
    margin: 1.75rem auto; /* Center the modal */
}

/* Style for the select dropdown */
.form-select {
    width: 100%; /* Ensure the select takes full width */
}

/* Ensure the dropdown menu does not overflow */
.dropdown-menu {
    max-height: 200px; /* Set a maximum height for the dropdown menu */
    overflow-y: auto; /* Enable vertical scrolling */
}
.modal-dialog {
    max-width: 90%;
    margin: 1.75rem auto;
    max-height: 90vh; /* Limit modal height */
    overflow-y: auto; /* Allow scrolling if content is too long */
}

.modal-content {
    max-height: 100%; /* Ensure modal content fits within the dialog */
    display: flex;
    flex-direction: column;
}

.modal-body {
    overflow-y: auto; /* Allow scrolling within modal body if needed */
    max-height: 70vh; /* Limit modal body height */
}

#office {
    max-height: 200px; /* Explicitly limit dropdown height */
    overflow-y: auto;
}
    </style>
</head>

<body>
    @include('includes.nav')
    <div class="container">
        @yield('content')
        <div class="floating-container">
            <div class="floating-button" data-bs-toggle="modal" data-bs-target="#myModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-paper-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6.5 9.5 3 7.5v-6A1.5 1.5 0 0 1 4.5 0h7A1.5 1.5 0 0 1 13 1.5v6l-3.5 2L8 8.75zM1.059 3.635 2 3.133v3.753L0 5.713V5.4a2 2 0 0 1 1.059-1.765M16 5.713l-2 1.173V3.133l.941.502A2 2 0 0 1 16 5.4zm0 1.16-5.693 3.337L16 13.372v-6.5Zm-8 3.199 7.941 4.412A2 2 0 0 1 14 16H2a2 2 0 0 1-1.941-1.516zm-8 3.3 5.693-3.162L0 6.873v6.5Z"/>
                </svg>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Contact Us</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column align-items-center justify-content-center"> <!-- Center the content -->
                        <img src="{{ asset('images/wupnav.png') }}" alt="Logo" class="logo mb-3"/>
                        <p><i>Have any concerns? Don't hesitate to send your inquiries.</i></p>
                        <form id="emailForm">             
                            <div class="mb-3">
                                <label for="office" class="form-label"><b>Recipient</b></label>
                                <select class="form-select" id="office">
                                    <option selected disabled>Choose an office</option>
                                    <option value="elem.ccd.share@wesleyan.edu.ph">BASIC EDUCATION (K-12)</option>
                                    <option value="shs@wesleyan.edu.ph">Senior High School (K-12)</option>
                                    <option value="secretary.CAS@wesleyan.edu.ph">COLLEGE OF ARTS AND SCIENCES (Colleges)</option>
                                    <option value="secretary.CBA@wesleyan.edu.ph">COLLEGE OF BUSINESS AND ACCOUNTANCY (Colleges)</option>
                                    <option value="secretary.CCJE@wesleyan.edu.ph">Criminal Justice Education (Colleges)</option>
                                    <option value="secretary.CAMS@wesleyan.edu.ph">COLLEGE OF ALLIED MEDICAL SCIENCES (Colleges)</option>
                                    <option value="secretary.COM@wesleyan.edu.ph">COLLEGE OF MEDICINE (Colleges)</option>
                                    <option value="law.secretary@wesleyan.edu.ph">COLLEGE OF LAW (Colleges)</option>
                                    <option value="secretary.CECT@wesleyan.edu.ph">COLLEGE OF ENGINEERING AND COMPUTER STUDIES (Colleges)</option>
                                    <option value="secretary.CHTM@wesleyan.edu.ph">COLLEGE OF HOSPITALITY AND TOURISM MANAGEMENT (Colleges)</option>
                                    <option value="secretary.CON@wesleyan.edu.ph">COLLEGE OF NURSING (Colleges)</option>
                                    <option value="mansecretary.conams@wesleyan.edu.ph">MA in Nursing (Colleges)</option>
                                    <option value="secretary.SOLAS@wesleyan.edu.ph">SCHOOL OF LEADERSHIP AND ADVANCED STUDIES (Colleges)</option>
                                    <option value="secretary.music@wesleyan.edu.ph">CHARLES WESLEY SCHOOL OF MUSIC (Colleges)</option>
                                    <option value="secretary.WDS@wesleyan.edu.ph">Wesley Divinity School (Colleges)</option>
                                    <option value="wuppresident@wesleyan.edu.ph">Office of the President (University Offices)</option>
                                    <option value="ovpaa@wesleyan.edu.ph">Office of the Vice President for Academic Affairs (University Offices)</option>
                                    <option value="ovpaf@wesleyan.edu.ph">Office of the Vice President for Administration and Finance (University Offices)</option>
                                    <option value="accounting@wesleyan.edu.ph">Accounting (University Offices)</option>
                                    <option value="chaplaincy@wesleyan.edu.ph">Chaplain (University Offices)</option>
                                    <option value="extension@wesleyan.edu.ph">Extension (University Offices)</option>
                                    <option value="guidance@wesleyan.edu.ph">Guidance and Placement Center (University Offices)</option>
                                    <option value="hrd@wesleyan.edu.ph">Human Resource Department (University Offices)</option>
                                    <option value="impact@wesleyan.edu.ph">Institute of Music, Performing Arts and Cultural Traditions (IMPACT) (University Offices)</option>
                                    <option value="library@wesleyan.edu.ph">Library (University Offices)</option>
                                    <option value="alumni@wesleyan.edu.ph">Office for Alumni Affairs (University Offices)</option>
                                    <option value="osa@wesleyan.edu.ph">Office for Student Affairs (University Offices)</option>
                                    <option value="pio@wesleyan.edu.ph">Wesleyan University Philippines PIO (University Offices)</option>
                                    <option value="qa@wesleyan.edu.ph">Quality Assurance Office (University Offices)</option>
                                    <option value="fm@wesleyan.edu.ph">Radio Wesleyan (University Offices)</option>
                                    <option value="registrar@wesleyan.edu.ph">Registrar (University Offices)</option>  
                                    <option value="rdpo@wesleyan.edu.ph">Research (University Offices)</option>
                                    <option value="security@wesleyan.edu.ph">Security Unit (University Offices)</option>
                                    <option value="treasury@wesleyan.edu.ph">Treasury (University Offices)</option>
                                    <option value="clinic@wesleyan.edu.ph">University Clinic (University Offices)</option>
                                    <option value="hospital@wesleyan.edu.ph">WU-P Hospital (University Offices)</option>
                                    <option value="WUPLinkages@wesleyan.edu.ph">Office of International Linkages and Local Partnerships (University Offices)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label"><b>Message</b></label>
                                <textarea class="form-control" id="message" placeholder="Enter your message"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary" id="sendEmailButton">Send Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!--  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const floatingButton = document.querySelector('.floating-button');
            const elementContainer = document.querySelector('.element-container');

            // Toggle visibility on button click
            floatingButton.addEventListener('click', function() {
                elementContainer.classList.toggle('active');
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
        const collapsibleButton = document.querySelector('.collapsible-button');
        const accordionContainer = document.querySelector('.accordion-container');

        collapsibleButton.addEventListener('click', function() {
            accordionContainer.style.display = accordionContainer.style.display === 'block' ? 'none' : 'block';
        });

        const accordionButtons = document.querySelectorAll('.accordion-button');

        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const isActive = content.style.display === 'block';

                // Close all accordion items
                document.querySelectorAll('.accordion-content').forEach(item => {
                item.style.display = 'none';
                });

                // Toggle the clicked item
                content.style.display = isActive ? 'none' : 'block';
            });
        });
    });

        document.getElementById('sendEmailButton').addEventListener('click', function() {
            const officeSelect = document.getElementById('office');
            const selectedEmail = officeSelect.value;
            const message = document.getElementById('message').value;

            if (selectedEmail) {
                const subject = encodeURIComponent('Message from Contact Form');
                const body = encodeURIComponent(message);
                const mailtoLink = `mailto:${selectedEmail}?subject=${subject}&body=${body}`;
            window.location.href = mailtoLink; // Open the default email client
            } else {
                alert('Please select an office before sending the email.');
            }
        });

        window.addEventListener('resize', function() {
            const dropdown = document.querySelector('.dropdown-menu');
            if (dropdown) {
            const viewportHeight = window.innerHeight;
            const dropdownHeight = dropdown.getBoundingClientRect().height;
            if (dropdownHeight > viewportHeight) {
                dropdown.style.maxHeight = `${viewportHeight - 100}px`; // Adjust as needed
                dropdown.style.overflowY = 'auto';
        }
    }
});
    </script>
-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const floatingButton = document.querySelector('.floating-button');
    const elementContainer = document.querySelector('.element-container');
    const collapsibleButton = document.querySelector('.collapsible-button');
    const accordionContainer = document.querySelector('.accordion-container');
    const sendEmailButton = document.getElementById('sendEmailButton');
    const officeSelect = document.getElementById('office');
    const messageInput = document.getElementById('message');
    const accordionButtons = document.querySelectorAll('.accordion-button');

    // Toggle visibility on floating button click
    if (floatingButton && elementContainer) {
        floatingButton.addEventListener('click', function() {
            elementContainer.classList.toggle('active');
        });
    }

    // Handle collapsible button click
    if (collapsibleButton && accordionContainer) {
        collapsibleButton.addEventListener('click', function() {
            accordionContainer.style.display = accordionContainer.style.display === 'block' ? 'none' : 'block';
        });
    }

    // Handle accordion button clicks
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const isActive = content.style.display === 'block';

            // Close all accordion items
            document.querySelectorAll('.accordion-content').forEach(item => {
                item.style.display = 'none';
            });

            // Toggle the clicked item
            content.style.display = isActive ? 'none' : 'block';
        });
    });

    // Handle send email button click
    if (sendEmailButton) {
        sendEmailButton.addEventListener('click', function() {
            const selectedEmail = officeSelect ? officeSelect.value : '';
            const message = messageInput ? messageInput.value : '';

            if (selectedEmail) {
                const subject = encodeURIComponent('Message from Contact Form');
                const body = encodeURIComponent(message);
                const mailtoLink = `mailto:${selectedEmail}?subject=${subject}&body=${body}`;
                window.location.href = mailtoLink; // Open the default email client
            } else {
                alert('Please select an office before sending the email.');
            }
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        const dropdown = document.querySelector('.dropdown-menu');
        if (dropdown) {
            const viewportHeight = window.innerHeight;
            const dropdownHeight = dropdown.getBoundingClientRect().height;
            if (dropdownHeight > viewportHeight) {
                dropdown.style.maxHeight = `${viewportHeight - 100}px`; // Adjust as needed
                dropdown.style.overflowY = 'auto';
            }
        }
    });
});
</script>
</body>

</html>
