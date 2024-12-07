<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ config('app.name') }} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
            <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
          </svg>7 </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="{{ route('papunta_sa_dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand mb-0 h1" href="#"><img src="{{ asset('images/wupnav.png') }}" alt="Logo" style="height: 40px;"> WU-P Cushman Campus</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="#"><h6>Campus Map</h6></a>
          <a class="nav-link" href="#"><h6>About</h6></a>
        </div>
      </div>
    </div>
  </nav>
  
  
  -->

  <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand mb-0 h1" href="/">
            <img src="{{ asset('images/wupnav.png') }}" alt="Logo" style="height: 40px;"> WU-P Cushman Campus
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5>Campus Map</h5>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Explore Wesleyan University-Philippines Cushman Campus grounds!</p>
                                <a href="{{ route('google_map_route_name') }}" class="btn btn-secondary">Google Map</a>
                                <!--<a href="#" class="btn btn-secondary">Google Map</a>-->
                                 
                                <a href="#" class="btn btn-secondary">2D Map</a>
                                 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5>About Us</h5>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="accordion" id="nestedAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="nestedHeadingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nestedCollapseOne" aria-expanded="true" aria-controls="nestedCollapseOne">
                                                <b>Mission</b>
                                            </button>
                                        </h2>
                                        <div id="nestedCollapseOne" class="accordion-collapse collapse show" aria-labelledby="nestedHeadingOne" data-bs-parent="#nestedAccordion">
                                            <div class="accordion-body" style="max-height: 200px; overflow-y: auto;">
                                                <p>Proclaiming and upholding Christian ideals and the democratic principles for which it stands, Wesleyan University-Philippines commits:
                                                    to promote transformative leadership evidenced through effective and transparent governance ruled by social holiness;
                                                    to produce proactive 21st-century learners honed by high-caliber and conscientious faculty and staff using state-of-the-art facilities, and guided by the principle of inclusive education;
                                                    to foster successful partnerships with stakeholders and sustainable linkages with the community; and
                                                    to be at the forefront of conducting innovative research as a testament to our shared responsibility in nation-building.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="nestedHeadingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nestedCollapseTwo" aria-expanded="false" aria-controls="nestedCollapseTwo">
                                                <b>Vision</b>
                                            </button>
                                        </h2>
                                        <div id="nestedCollapseTwo" class="accordion-collapse collapse" aria-labelledby="nestedHeadingTwo" data-bs-parent="#nestedAccordion">
                                            <div class="accordion-body" style="max-height: 200px; overflow-y: auto;">
                                                <p>“By 2029, Wesleyan University-Philippines is the leading Filipino University imbued with Wesleyan spirituality; it is internationally recognized for providing high-quality education; and has a shared culture of social responsibility.”</p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="nestedHeadingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nestedCollapseThree" aria-expanded="false" aria-controls="nestedCollapseTwo">
                                                <b>Accreditation</b>
                                            </button>
                                        </h2>
                                        <div id="nestedCollapseThree" class="accordion-collapse collapse" aria-labelledby="nestedHeadingThree" data-bs-parent="#nestedAccordion">
                                            <div class="accordion-body" style="max-height: 200px; overflow-y: auto;">
                                                <p>It is one of only 68 higher education institutions in the Philippines granted autonomous status by the Commission on Higher Education. Only five private schools in Region III enjoy this status.
                                                    <br>
                                                    <br>
                                                    The Association of Christian Schools, Colleges, and Universities Accrediting Council, Inc. recently awarded WUP Institutional Re-Accreditation Status (2024-2028). This status was first attained in 2014. This award recognized the University’s
                                                    commitment to voluntary accreditation as evidenced by a high level of program accreditation; its long tradition of excellence in instruction, research, and community service; the high performance of its graduates in licensure examinations; and for having an effective Quality Assurance System.</p>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>