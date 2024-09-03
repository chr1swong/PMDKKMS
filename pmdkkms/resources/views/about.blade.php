
    <div class="content-wrapper">
        <header>
            @include('components.header')
        </header>

        <style>
            /* General Styles */
            body, html {
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .content-wrapper {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            /* Hero Section */
            .hero {
                position: relative;
                background-size: cover;
                background-position: center;
                padding: 0;
                display: flex;
                align-items: stretch;
                justify-content: flex-start;
                height: 40vh;
                color: #000;
                background-color: #e7f0fa;
            }

            .hero-content {
                display: flex;
                width: 35%;
                flex-direction: column;
                justify-content: center;
                padding: 2vw;
                background-color: #A7C7E7;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                font-weight: bold;
                margin-bottom: 10px;
                color: #000;
                
            }

            .hero-content p {
                font-size: 1.25rem;
                color: #000;
                
                text-align: justify; /* Justify text alignment */
                line-height: 1.6; /* Improve readability with increased line height */
            }

            .hero-image {
                flex: 1;
                background-size: cover;
                background-position: center;
            }

            .hero-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Section Titles */
            .section-title {
                font-size: 2rem;
                font-weight: bold;
                margin: 40px 0 20px;
                text-align: left;
                color: #000000;
                padding-left: 2vw;
            }

            /* President and Coaches Section */
            .presidents-section, .coaches-section {
                display: flex;
                justify-content: space-around;
                padding: 2vw;
                flex-wrap: wrap;
            }

            .president, .coach {
                text-align: center;
                margin: 20px;
            }

            .president img, .coach img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                background-color: #007bff;
                margin-bottom: 10px;
            }

            .president p, .coach p {
                font-size: 1.5rem;
                font-weight: bold;
                color: #000000;
            }

            /* Organizational Chart Section */
            .org-chart {
                text-align: center;
                padding: 2vw;
                display: flex;           /* Added */
                justify-content: center; /* Added */
                align-items: center;     /* Added */
            }

            .org-chart img {
                width: 80%;
                max-width: 600px;
                height: auto;
                border: 2px solid #000000;
                border-radius: 8px;
            }

            /* Media Queries for Adaptability */
            @media (max-width: 1024px) {
                .hero {
                    height: 35vh;
                }
                .hero-content {
                    width: 40%;
                }
                .section-title {
                    padding-left: 4vw;
                }
            }

            @media (max-width: 768px) {
                .hero {
                    flex-direction: column;
                    height: auto;
                }
                .hero-content {
                    width: 100%;
                    text-align: center;
                    padding: 5vw;
                }
                .hero-image {
                    height: 30vh;
                }
                .section-title {
                    padding-left: 5vw;
                }
                .presidents-section, .coaches-section {
                    padding-left: 0;
                    justify-content: center;
                }
            }

            @media (max-width: 480px) {
                .hero-content h1 {
                    font-size: 1.5rem;
                }
                .hero-content p {
                    font-size: 0.9rem;
                }
                .section-title {
                    padding-left: 5vw;
                    text-align: center;
                }
                .presidents-section, .coaches-section {
                    flex-direction: column;
                    align-items: center;
                }
            }
        </style>

        <div class="hero">
            <div class="hero-content">
                <h1>About PMDKK</h1>
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/aboutPageImages/aboutBanner1.png') }}" alt="About PMDKK">
            </div>
        </div>

        <div class="section-title">Explore Our Esteemed Presidents</div>
        <div class="presidents-section">
            <div class="president">
                <img src="{{ asset('images/fillerimage.png') }}" alt="President 1">
                <p>President 1</p>
            </div>
            <div class="president">
                <img src="{{ asset('images/fillerimage.png') }}" alt="President 2">
                <p>President 2</p>
            </div>
            <div class="president">
                <img src="{{ asset('images/fillerimage.png') }}" alt="President 3">
                <p>President 3</p>
            </div>
        </div>

        <div class="section-title">Organizational Chart</div>
        <div class="org-chart">
            <img src="{{ asset('images/aboutPageImages/orgChart.png') }}" alt="Organizational Chart">
        </div>

        <div class="section-title">Our Coaches</div>
        <div class="coaches-section">
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 1">
                <p>Coach 1</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 2">
                <p>Coach 2</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 3">
                <p>Coach 3</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 4">
                <p>Coach 4</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 5">
                <p>Coach 5</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 6">
                <p>Coach 6</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 7">
                <p>Coach 7</p>
            </div>
            <div class="coach">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 8">
                <p>Coach 8</p>
            </div>
        </div>

        <footer>
            @include('components.footer')
        </footer>
    </div>

