@extends('layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wesleyan University-Philippines Interactive Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        html, body {
            width: auto;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Hide both horizontal and vertical scrolling */
        }
        *area {
            cursor: pointer;
        }
        .form-container {
            display: none;
            position: fixed;
            background-color: white;
            border: 1px solid black;
            padding: 10px;
            z-index: 1000;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .form-container h3, .location-form-container h3 {
            margin: 0;
            font-size: 1.2em;
        }
        .form-container p, .location-form-container p {
            margin: 0.5em 0;
        }
        .form-container button, .location-form-container button {
            margin-top: 10px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .form-container img, .location-form-container img {
            width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
        .hidden-description {
            display: none;
        }
        #map-wrapper {
            width: auto;
            height: 100vh; /* Set the height to 100% of viewport height */
            overflow-x: scroll; /* Enable horizontal scroll */
            overflow-y: hidden; /* Disable vertical scroll */
            position: relative;
        }
        #map-container {
            width: auto; /* Set the width to 400% of viewport height */
            height: 100vh; /* Set the height to 100% of viewport height */
            position: relative;
        }
        #campus-map {
            height: 100vh; /* Set the height to 100% of viewport height */
            width: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        /* Media query for mobile devices */
        @media only screen and (max-width: 768px) {
            #map-container, #campus-map {
                height: 100%;
                width: auto;
            }
        }
        .line {
            position: absolute;
            background-color: red;
            height: 2px;
            
        }
        .dashed-line {
            border-top: 2px dashed red;
            height: 0;
            position: absolute;
            
        }
        .pinpoint {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: red;
            border: 2px solid darkgray;
            border-radius: 50%;
            z-index: 1000;
        }
    </style>
</head>
@section('content')
<body>
    <div id="map-wrapper">
        <div id="map-container">
            <img src="map/camp.png" usemap="#image-map" alt="Example Image" id="campus-map">
            <map name="image-map">
                <area shape="rect" coords="1518,294,1302,364" alt="GLORIA LACSON BUILDING" href="#" id="area1">
                <area shape="rect" coords="1671,119,1451,262" alt="UNIVERSITY GYMNASIUM" href="#" id="area2">
                <area shape="rect" coords="1380,254,1526,86" title="Rectangle" href="#" id="area3">
                <area shape="rect" coords="1761,96,1687,137" alt="Rectangle" href="#" id="area4">
                <area shape="rect" coords="2023,127,1734,149" alt="Rectangle" href="#" id="area5">
                <area shape="rect" coords="2276,159,1980,195" alt="Rectangle" href="#" id="area6">
                <area shape="rect" coords="2298,234,2104,400" alt="Rectangle" href="#" id="area7">
                <area shape="rect" coords="2307,310,2242,368" alt="Rectangle" href="#" id="area8">
                <area shape="rect" coords="2602,240,2292,304" alt="Rectangle" href="#" id="area9">
                <area shape="rect" coords="2796,283,2739,321" title="Rectangle" href="#" id="area10">
                <area shape="rect" coords="2833,263,2784,279" alt="Rectangle" href="#" id="area11">
                <area shape="rect" coords="3017,539,2684,588" alt="Rectangle" href="#" id="area12">
                <area shape="rect" coords="2692,532,2636,565" alt="Rectangle" href="#" id="area13">
                <area shape="rect" coords="2438,452,2193,555" alt="Rectangle" href="#" id="area14">
                <area shape="rect" coords="2205,512,2067,556" alt="Rectangle" href="#" id="area15">
                <area shape="rect" coords="1800,481,2059,553" alt="Rectangle" href="#" id="area16">
                <area shape="rect" coords="1799,484,1550,576" alt="Rectangle" href="#" id="area17">
                <area shape="rect" coords="1560,496,1300,578" alt="Rectangle" href="#" id="area18">
                <area shape="rect" coords="1319,536,1236,648" alt="Rectangle" href="#" id="area19">
                <area shape="rect" coords="787,545,1131,596" alt="Rectangle" href="#" id="area20">
                <area shape="rect" coords="480,577,729,614" alt="Rectangle" href="#" id="area21">
                <area shape="rect" coords="394,554,177,646" alt="Rectangle" href="#" id="area22">
                <area shape="rect" coords="569,352,477,500" alt="Rectangle" href="#" id="area23">
                <area shape="rect" coords="642,402,530,505" alt="Rectangle" href="#" id="area24">
                <area shape="rect" coords="881,368,649,427" alt="Rectangle" href="#" id="area25">
                <area shape="rect" coords="773,444,716,501" alt="Rectangle" href="#" id="area26">
                <area shape="rect" coords="894,439,765,497" alt="Rectangle" href="#" id="area27">
                <area shape="rect" coords="1269,383,894,426" alt="Rectangle" href="#" id="area28">
                <area shape="rect" coords="1443,405,1273,464" alt="Rectangle" href="#" id="area29">
                <area shape="rect" coords="1623,345,1483,424" alt="Rectangle" href="#" id="area30">
                <area shape="rect" coords="1696,251,1552,331" alt="Rectangle" href="#" id="area31">
                <area shape="rect" coords="2039,246,1622,420" alt="Rectangle" href="#" id="area32">
                <area shape="rect" coords="2118,268,2024,372" title="Rectangle" href="#" id="area33">
                <area shape="rect" coords="832,239,730,299" alt="Rectangle" href="#" id="area34">
                <area shape="rect" coords="725,211,682,265" alt="Rectangle" href="#" id="area35">
                <area shape="rect" coords="1197,537,1126,591" title="Rectangle" href="#" id="area36">
                <area shape="rect" coords="592,514,449,542" title="Rectangle" href="#" id="ElemG">
                <area shape="rect" coords="124,574,18,610" title="Rectangle" href="#" id="NGate">
                <area shape="rect" coords="2745,457,2618,466" title="Rectangle" href="#" id="SGate">
                <area shape="rect" coords="1299,325,1232,351" title="Rectangle" href="#" id="EGate">
                <area shape="rect" coords="1273,540,1164,690" title="Rectangle" href="#" id="MGate">
            </map>
        </div>
    </div>

    <div id="form-container" class="form-container">
        <h3 id="location-name"></h3>
        <button id="show-more-button">Show More</button>
        <p id="form-description" class="hidden-description"></p>
        <img id="form-image" src="" alt="">
        <button id="navigate-button">Navigate</button>
    </div>

    <div id="navigate-form-container" class="form-container">
        <h3>Select Location to Navigate</h3>
        <select id="location-dropdown" style="width: 100%;"></select>
        <select id="additional-dropdown" style="width: 100%; margin-top: 10px;"></select>
        <button id="navigate-confirm-button">Navigate</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const areas = document.querySelectorAll('area');
    const formContainer = document.getElementById('form-container');
    const locationName = document.getElementById('location-name');
    const locationDescription = document.getElementById('form-description');
    const formImage = document.getElementById('form-image');
    const navigateButton = document.getElementById('navigate-button');
    const navigateFormContainer = document.getElementById('navigate-form-container');
    const locationDropdown = document.getElementById('location-dropdown');
    const additionalDropdown = document.getElementById('additional-dropdown');
    const navigateConfirmButton = document.getElementById('navigate-confirm-button');
    const showMoreButton = document.getElementById('show-more-button');

    const areaData = {
        area1: {
            name: 'GLORIA LACSON BUILDING',
            description: 'This building is where the following are located',
            areas: 'Registrar<br>Treasury<br>President Office<br>ICT Office<br>Criminal Justice Education(CCJE)',
            image: 'map/1.jpg',
            Center: [1410, 329],
            keywords: 'gloria lacson building, registrar, treasury, president office, ict office, ccje'
        },
        area2: {
            name: 'UNIVERSITY GYMNASIUM',
            description: 'This is where sports related events are performed.',
            areas: 'PE/Sports Coach Office',
            image: 'map/2.jpg',
            Center: [1561, 190.5],
            keywords: 'university gymnasium, sports, pe, coach office'
        },
        area3: {
            name: 'CULTURAL AFFAIRS & SPORTS DEVELOPMENT OFFICE',
            description: 'This is the Fitness Center',
            areas: '',
            image: 'maps/3.jpg',
            Center: [1453, 170]
        },
        area4: {
            name: 'FITNESS CENTER',
            description: '',
            areas: '<strong>L1</strong><br>College of Arts and Sciences (CAS)<br><br><strong>L2</strong><br>Business and Accountancy (CBA)',
            image: 'maps/4.jpg',
            Center: [1724, 116.5]
        },
        area5: {
            name: 'REV.CARLOS K. MANACOP',
            description: '',
            areas: '<strong>L2</strong><br>College of Education (CoED)',
            image: 'maps/5.jpg',
            Center: [1878.5, 138]
        },
        area6: {
            name: 'EZE BUILDING',
            description: 'The Newly Made Wesleyan University Chapel',
            areas: '',
            image: 'maps/6.jpg',
            Center: [2128, 177]
        },
        area7: {
            name: 'ROXY LEFFORGE COMPLEX',
            description: '',
            areas: '<strong>L1</strong><br>College of Medicine | College of Medicine Library | Chaplain Office',
            image: 'maps/7.jpg',
            Center: [2201, 317]
        },
        area8: {
            name: 'UNIVERSITY POWER HOUSE',
            description: '',
            areas: '<strong>L1</strong><br>High School Department | Wesley Divinity School | Wesley Divinity School Library<br><br><strong>L2</strong><br>Graduate School | Graduate School Library',
            image: 'maps/8.jpg',
            Center: [2274.5, 339]
        },
        area9: {
            name: 'WU-P FOOD COURT & ALUMNI AFFAIRS OFFICE',
            description: '',
            areas: 'Allumni Office | Commissary',
            image: 'maps/9.jpg',
            Center: [2447, 272]
        },
        area10: {
            name: 'SEWAGE TREATMENT FACILITY',
            description: '',
            areas: '',
            image: 'maps/10.jpg',
            Center: [2767.5, 302]
        },
        area11: {
            name: 'MATERIAL RECOVERY FACILITY',
            description: '',
            areas: '',
            image: 'maps/11.jpg',
            Center: [2808.5, 271]
        },
        area12: {
            name: 'WU-P HOSPITAL',
            description: '',
            areas: '',
            image: 'maps/12.jpg',
            Center: [2850.5, 563.5]
        },
        area13: {
            name: 'HOSPITAL POWER HOUSE',
            description: '',
            areas: '<strong>L2</strong><br>College of Hospitality & Tourism Management<br><br><strong>L3</strong><br>John Wesley School of Law & Governance | John Wesley School of Law & Governance Library',
            image: 'maps/13.jpg',
            Center: [2664, 548.5]
        },
        area14: {
            name: 'JOSE VALENCIA (CHTM) BUILDING',
            description: '',
            areas: '',
            image: 'maps/14.jpg',
            Center: [2315.5, 503.5]
        },
        area15: {
            name: 'GUEST HOUSE',
            description: '',
            areas: 'College of Nursing',
            image: 'maps/15.jpg',
            Center: [2136, 534]
        },
        area16: {
            name: 'ASUNCSION PEREZ BUILDING',
            description: '',
            areas: '<strong>L1</strong><br>JJDG Auditorium | WUPFSA<br><br><strong>L2</strong><br>Research Development & Productivity Office | Public Information Office | Archives & Museum | Audiovisual & Multimedia Center<br><br><strong>L3</strong><br>Main Library',
            image: 'maps/16.jpg',
            Center: [1929.5, 517]
        },
        area17: {
            name: 'JJDG AUDITORIUM & MAIN LIBRARY BUILDING',
            description: '',
            areas: 'College of Engineering & Computer Technology',
            image: 'maps/17.jpg',
            Center: [1674.5, 530]
        },
        area18: {
            name: 'BISHOP PAUL LOCKE GRANADOSIN (TECHNOLOGY) BUILDING',
            description: '',
            areas: '',
            image: 'maps/18.jpg',
            Center: [1430, 537]
        },
        area19: {
            name: 'SECURITY OFFICE',
            description: '',
            areas: '<strong>L1</strong><br>University Clinic | Office of Student Affairs | Wesleyan Community Outreach Program | University Guidance & Placement<br><br><strong>L2</strong><br>ID Printing<br><br><strong>L3</strong><br>College of Allied Medical Science',
            image: 'maps/19.jpg',
            Center: [1277.5, 592]
        },
        area20: {
            name: 'BISHOP DIONISIO ALEJANDRO (COMSCI) BUILDING',
            description: '',
            areas: '',
            image: 'maps/20.jpg',
            Center: [959, 570.5]
        },
        area21: {
            name: 'WESLEY DIVINITY SCHOOL DORMITORY',
            description: '',
            areas: '',
            image: 'maps/21.jpg',
            Center: [604.5, 595.5]
        },
        area22: {
            name: 'MAINTENANCE AND MOTORPOOL OFFICE',
            description: '',
            areas: '',
            image: 'maps/22.jpg',
            Center: [285.5, 600]
        },
        area23: {
            name: 'ELEMENTARY BUILDING ANNEX',
            description: '',
            areas: 'CCD Library',
            image: 'maps/23.jpg',
            Center: [523, 426]
        },
        area24: {
            name: 'ELEMENTARY OPEN COURT',
            description: '',
            areas: '',
            image: 'maps/24.jpg',
            Center: [586, 453.5]
        },
        area25: {
            name: 'PATROCINIO OCAMPO (ELEM. & PREP.) BUILDING',
            description: '',
            areas: 'Elementary Library',
            image: 'maps/25.jpg',
            Center: [765, 397.5]
        },
        area26: {
            name: 'JOB SKILLS BUILDING',
            description: '',
            areas: '<strong>L2</strong><br>High School Library',
            image: 'maps/26.jpg',
            Center: [744.5, 472.5]
        },
        area27: {
            name: 'SHARE BUILDING',
            description: '' ,
            areas: '',
            image: 'maps/27.jpg',
            Center: [829.5, 468]
        },
        area28: {
            name: 'HIGHSCHOOL BUILDING',
            description: '',
            areas: '',
            image: 'maps/28.jpg',
            Center: [1081.5, 404.5]
        },
        area29: {
            name: 'JOHN WESLEY PARK',
            description: '',
            areas: '',
            image: 'maps/29.jpg',
            Center: [1358, 434.5]
        },
        area30: {
            name: 'VOLLEYBALL COURT',
            description: '',
            areas: '',
            image: 'maps/30.jpg',
            Center: [1553, 384.5]
        },
        area31: {
            name: 'BASKETBALL COURT',
            description: '',
            areas: '',
            image: 'maps/31.jpg',
            Center: [1624, 291]
        },
        area32: {
            name: 'WU-P PARADE GROUND/PLAZA ACACIA',
            description: '',
            areas: '',
            image: 'maps/32.jpg',
            Center: [1830.5, 333]
        },
        area33: {
            name: 'UNIVERSITY CHAPEL',
            description: '',
            areas: '',
            image: 'maps/33.jpg',
            Center: [2071, 320]
        },
        area34: {
            name: 'OLD PRESIDENTS HOUSE',
            description: '',
            areas: '',
            image: 'maps/34.jpg',
            Center: [781, 269]
        },
        area35: {
            name: 'NEW PRESIDENTS HOUSE',
            description: '',
            areas: '',
            image: 'maps/35.jpg',
            Center: [703.5, 238]
        },
        area36: {
            name: 'CLINIC',
            description: '',
            areas: '',
            image: 'maps/36.jpg',
            Center: [1161.5, 564]
        },
        ElemG: {
            name: 'Elementary Gate',
            description: '',
            areas: '',
            image: 'maps/ElemG.jpg',
            Center: [520.5, 528]
        },
        MGate: {
            name: 'Western Gate',
            description: 'Also Known as the Main Gate of Wesleyan University-Philippines',
            areas: 'Security Office',
            image: 'maps/MG.jpg',
            Center: [1218.5, 615]
        },
        NGate: {
            name: 'Northern Gate',
            description: '',
            areas: 'Watch Tower',
            image: 'maps/NG.jpg',
            Center: [71, 592]
        },
        EGate: {
            name: 'Eastern Gate',
            description: 'This Gate is located behind the Gloria D. Lacson Building',
            areas: '',
            image: 'maps/EG.jpg',
            Center: [1265.5, 338]
        },
        SGate: {
            name: 'Southern Gate',
            description: '',
            areas: '',
            image: 'maps/SG.jpg',
            Center: [2681.5, 461.5]
        }
    };

    function drawConnectionLine(startX, startY, endX, endY) {
                const existingLines = document.querySelectorAll('.dashed-line, .pinpoint');
                existingLines.forEach(line => line.remove());

                const length = Math.sqrt((endX - startX) ** 2 + (endY - startY) ** 2);
                const angle = Math.atan2(endY - startY, endX - startX) * (180 / Math.PI);

                const line = document.createElement('div');
                line.className = 'dashed-line';
                line.style.width = `${length / 8.5}vh`; // Use viewport height (vh) units for the line
                line.style.transform = `rotate(${angle}deg)`;

                // Calculate the center point of the line
                const centerX = (startX + endX) / 2;
                const centerY = (startY + endY) / 2;

                // Position the line centered horizontally and at the correct vertical position
                const leftPixel =  0;
                const topPixel =  0; 

                // Get the selected areas from the dropdown lists
                const selectedAreaId1 = locationDropdown.value;
                const selectedAreaId2 = additionalDropdown.value; // Use if, else if, and else statements to set the positions based on the selected areas
                if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area2') || (selectedAreaId1 === 'area2' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1390}px`; // Use percentage units for the left position
                    line.style.top = `${topPixel + 260}px`; // Center the line vertically (800px is the height)
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area3') || (selectedAreaId1 === 'area3' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1355}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 250}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area4') || (selectedAreaId1 === 'area4' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1390}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 222}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area5') || (selectedAreaId1 === 'area5' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1415}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 232}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area6') || (selectedAreaId1 === 'area6' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1430}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 252}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area7') || (selectedAreaId1 === 'area7' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1440}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 325}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1440}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 335}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1440}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 305}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1445}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 320}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1445}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 305}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1460}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 450}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1460}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 445}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1440}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 420}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1430}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 435}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1415}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 425}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1395}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 430}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1325}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 435}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1213}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 460}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 950}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 452}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 620}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 458}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 320}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 468}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 560}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 380}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 600}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 395}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 785}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 368}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 770}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 400}px`; // Adjust slightly for this combination
                    }
                    
                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 850}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 400}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1095}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 365}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1335}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 378}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1415}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 358}px`; // Adjust slightly for this combination
                    }
                    
                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1420}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 310}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1435}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 330}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1435}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 330}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 800}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 300}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 725}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 285}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1130}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 448}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 548}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 428}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1160}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 470}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 100}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 460}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1270}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 335}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area1' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area1')) {
                    line.style.left = `${leftPixel + 1440}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 400}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area3') || (selectedAreaId1 === 'area3' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1450}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 183}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area4') || (selectedAreaId1 === 'area4' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1558}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 153}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area5') || (selectedAreaId1 === 'area5' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1570}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 165}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area6') || (selectedAreaId1 === 'area6' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1580}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 185}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area7') || (selectedAreaId1 === 'area7' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1580}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 255}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1580}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 265}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1580}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 230}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1590}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 245}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1590}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 238}px`; // Adjust slightly for this combination
                    }

                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel + 1585}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel + 370}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area2' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area2')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area4') || (selectedAreaId1 === 'area4' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - 4.5}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - -.01}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area5') || (selectedAreaId1 === 'area5' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area6') || (selectedAreaId1 === 'area6' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area7') || (selectedAreaId1 === 'area7' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area3' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area3')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area5') || (selectedAreaId1 === 'area5' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area6') || (selectedAreaId1 === 'area6' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area7') || (selectedAreaId1 === 'area7' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area4' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area4')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area6') || (selectedAreaId1 === 'area6' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area7') || (selectedAreaId1 === 'area7' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area5' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area5')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area7') || (selectedAreaId1 === 'area7' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area6' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area6')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area8') || (selectedAreaId1 === 'area8' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area7' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area7')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area9') || (selectedAreaId1 === 'area9' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area8' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area8')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area10') || (selectedAreaId1 === 'area10' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area9' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area9')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area11') || (selectedAreaId1 === 'area11' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area10' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area10')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area12') || (selectedAreaId1 === 'area12' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area11' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area11')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area13') || (selectedAreaId1 === 'area13' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area12' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area12')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area14') || (selectedAreaId1 === 'area14' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area13' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area13')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area15') || (selectedAreaId1 === 'area15' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area14' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area14')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area16') || (selectedAreaId1 === 'area16' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area15' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area15')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area17') || (selectedAreaId1 === 'area17' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area16' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area16')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area18') || (selectedAreaId1 === 'area18' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area17' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area17')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area19') || (selectedAreaId1 === 'area19' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area18' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area18')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area20') || (selectedAreaId1 === 'area20' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area19' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area19')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area21') || (selectedAreaId1 === 'area21' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area20' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area20')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area22') || (selectedAreaId1 === 'area22' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area21' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area21')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area23') || (selectedAreaId1 === 'area23' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area22' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area22')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area24') || (selectedAreaId1 === 'area24' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area23' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area23')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area25') || (selectedAreaId1 === 'area25' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area24' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area24')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area26') || (selectedAreaId1 === 'area26' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area25' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area25')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area27') || (selectedAreaId1 === 'area27' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area26' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area26')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area28') || (selectedAreaId1 === 'area28' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area27' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area27')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area29') || (selectedAreaId1 === 'area29' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area28' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area28')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area30') || (selectedAreaId1 === 'area30' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area29' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area29')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'area31') || (selectedAreaId1 === 'area31' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area30' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area30')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'area32') || (selectedAreaId1 === 'area32' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area31' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area31')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'area33') || (selectedAreaId1 === 'area33' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area32' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area32')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'area34') || (selectedAreaId1 === 'area34' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area33' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area33')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'area35') || (selectedAreaId1 === 'area35' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area34' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area34')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area35' && selectedAreaId2 === 'area36') || (selectedAreaId1 === 'area36' && selectedAreaId2 === 'area35')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area35' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area35')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area35' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area35')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area35' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area35')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area35' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area35')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area35' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area35')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area36' && selectedAreaId2 === 'ElemG') || (selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'area36')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area36' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'area36')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area36' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'area36')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area36' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'area36')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'area36' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'area36')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'MGate') || (selectedAreaId1 === 'MGate' && selectedAreaId2 === 'ElemG')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'ElemG')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'ElemG')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'ElemG' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'ElemG')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'MGate' && selectedAreaId2 === 'NGate') || (selectedAreaId1 === 'NGate' && selectedAreaId2 === 'MGate')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'MGate' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'MGate')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'MGate' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'MGate')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'NGate' && selectedAreaId2 === 'EGate') || (selectedAreaId1 === 'EGate' && selectedAreaId2 === 'NGate')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'NGate' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'NGate')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else if ((selectedAreaId1 === 'NGate' && selectedAreaId2 === 'SGate') || (selectedAreaId1 === 'SGate' && selectedAreaId2 === 'NGate')) {
                    line.style.left = `${leftPixel - -1}px`; // Adjust slightly for this combination
                    line.style.top = `${topPixel - 0}px`; // Adjust slightly for this combination
                    }
                else { line.style.left = `${leftPixel - 20}px`; // Adjust more for other combinations
                    line.style.top = `${topPixel - 20}px`; // Adjust more for other combinations
                    }
                
                document.getElementById('map-container').appendChild(line);

                const createPinpoint = (x, y) => {
                    const pinpoint = document.createElement('div');
                    pinpoint.className = 'pinpoint';
                    pinpoint.style.left = `${x - 5}px`; // Use pixel (px) units for the pinpoints
                    pinpoint.style.top = `${y - 5}px`; // Use pixel (px) units for the pinpoints
                    document.getElementById('map-container').appendChild(pinpoint);
                    return pinpoint;
                };

                createPinpoint(startX, startY);
                createPinpoint(endX, endY);
            }

    
            areas.forEach(area => {
                area.addEventListener('click', function (event) {
                    event.preventDefault();
    
                    const coords = this.coords.split(',').map(Number);
                    const centerX = (coords[0] + coords[2]) / 2;
                    const centerY = (coords[1] + coords[3]) / 2;
    
                    const rect = event.target.getBoundingClientRect();
                    const data = areaData[event.target.id];
                    locationName.innerHTML = data.name;
                    locationDescription.innerHTML = `${data.description}<br>${data.areas}`;
                    formImage.src = data.image;
                    formImage.alt = data.name;
                    formContainer.style.display = 'block';
                    showMoreButton.onclick = function() {
                        locationDescription.classList.toggle('hidden-description');
                        showMoreButton.textContent = locationDescription.classList.contains('hidden-description') ? 'Show More' : 'Show Less';
                    };
                    navigateButton.onclick = function() {
                        navigateFormContainer.style.display = 'block';
                        navigateConfirmButton.onclick = function() {
                            const selectedArea = areaData[locationDropdown.value];
                            const additionalSelectedArea = areaData[additionalDropdown.value];
    
                            drawConnectionLine(
                                selectedArea.Center[0], 
                                selectedArea.Center[1], 
                                additionalSelectedArea.Center[0], 
                                additionalSelectedArea.Center[1]
                            );
                            navigateFormContainer.style.display = 'none';
                        };
                    };
                });
            });
    
            document.addEventListener('click', (event) => {
                if (!formContainer.contains(event.target) && !event.target.matches('area')) {
                    formContainer.style.display = 'none';
                }
                if (!navigateFormContainer.contains(event.target) && !event.target.matches('button')) {
                    navigateFormContainer.style.display = 'none';
                }
            });
    
            function populateDropdowns() {
                for (const key in areaData) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.text = areaData[key].name;
                    locationDropdown.appendChild(option);
    
                    const additionalOption = document.createElement('option');
                    additionalOption.value = key;
                    additionalOption.text = areaData[key].name;
                    additionalDropdown.appendChild(additionalOption);
                }
    
                $(locationDropdown).select2({
                    dropdownParent: $('#navigate-form-container'),
                    matcher: function(params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }
                        if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                            return data;
                        }
                        const keywords = areaData[data.id].keywords;
                        if (keywords && keywords.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                            return data;
                        }
                        return null;
                    },
                    maximumSelectionLength: 2
                });
    
                $(additionalDropdown).select2({
                    dropdownParent: $('#navigate-form-container'),
                    matcher: function(params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }
                        if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                            return data;
                        }
                        const keywords = areaData[data.id].keywords;
                        if (keywords && keywords.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                            return data;
                        }
                        return null;
                    },
                    maximumSelectionLength: 2
                });
            }
    
            populateDropdowns();
        
        });
    </script>
</body>
</html>
@endsection