    <header>
        @include('components.header')
    </header>

<style>
/* Hero Section */
.hero {
    position: relative;
    background-size: cover;
    background-position: center;
    padding: 2vw;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 30vh;
    color: white;
}

.hero-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 90vw;
}

.hero-text {
    flex: 1;
    margin-right: 20px;
    text-align: left;
}

.hero-text h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 80px;
}

.hero-text p {
    font-size: 1.5rem;
    margin-top: 10px;
}

.hero-image img {
    max-width: 20vw;
    height: auto;
    border-radius: 50%;
    border: 5px solid white;
    margin-left: 2vw;
}

.hero-image img {
    max-width: 300px;
    height: auto;
    border-radius: 50%;
    border: 5px solid white;
    margin-left: 50px;
}

/* Highlights */
.highlights {
    display: flex;
    flex-direction: column;
    padding: 50px 20px;
    background-color: #fff;
}

.highlights .highlight {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 40px;
    position: relative;
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
}

.highlight .slideshow-container {
    position: relative;
    width: 800px; /* Fixed width */
    height: 500px; /* Fixed height */
    overflow: hidden;
    border-radius: 8px;
    background-color: #f0f0f0; /* Placeholder color */
    border: 3px solid #333; /* Add a solid border for the frame */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for a 3D effect */
}

.highlight img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the container without distortion */
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    transition: opacity 1s ease-in-out;
}

.highlight img.active {
    opacity: 1;
}

.highlight-text {
    flex: 1;
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 0;
    text-align: justify;
}

.highlights .highlight h2 {
    font-size: 2.5em;
    color: #000000;
    margin-bottom: 10px;
}

.highlights .highlight p {
    font-size: 1.5em;
    color: #555;
    text-align: justify; /* Justify text */
}

.highlights .highlight:nth-child(odd) {
    flex-direction: row;
}

.highlights .highlight:nth-child(even) {
    flex-direction: row-reverse;
    text-align: left;
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
    }

    .highlights .highlight {
        flex-direction: column;
    }

    .highlight-text {
        margin-left: 0;
        text-align: justify;
    }
}

/* Info Section */
.info-section {
    display: flex;
    justify-content: space-around;
    padding: 50px 20px;
    background-color: #e7f0fa;
    border-radius: 8px;
    margin: 50px 0;
}

.news-updates, .upcoming-events {
    width: 45%;
    padding: 20px;
}

.news-updates h3, .upcoming-events h3 {
    font-size: 1.75rem;
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
}

.news-updates img {
    width: 100%;
    height: auto;
    margin-top: 10px;
}

.upcoming-events ul {
    list-style-type: none;
    padding-left: 0;
}

.upcoming-events ul li {
    margin-bottom: 10px;
    font-size: 1.2rem;
    color: #333;
}

@media (max-width: 1024px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .hero-image {
        margin: 2vh 0 0 0;
    }

    .highlights .highlight {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
    }

    .highlights .highlight img {
        width: 100%;
    }

    .info-section {
        flex-direction: column;
    }
}
</style>

<div class="hero" style="background-image: url('{{ asset('images/homePageImages/homeBanner1.png') }}');">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Welcome To Kota Kinabalu Archery Association</h1>
            <p>Energizing Archery to the highest level</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/pmdkkLogo.png') }}" alt="PMDKK Logo">
        </div>
    </div>
</div>

<div class="highlights">
    <div class="highlight">
        <div class="slideshow-container">
            <img src="{{ asset('/images/homePageImages/highlight1.png') }}" class="active" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.2.jpg') }}" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.3.jpg') }}" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.4.jpg') }}" alt="Highlight 1">
        </div>
        <div class="highlight-text">
            <h2>HIGHLIGHT 1:</h2>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
        </div>
    </div>
    <div class="highlight">
        <div class="slideshow-container">
            <img src="{{ asset('images/homePageImages/highlight2.png') }}" class="active" alt="Highlight 2">
            <img src="{{ asset('images/homePageImages/highlight2.2.jpg') }}" alt="Highlight 2">
            <img src="{{ asset('images/homePageImages/highlight2.3.jpg') }}" alt="Highlight 2">
        </div>
        <div class="highlight-text">
            <h2>HIGHLIGHT 2:</h2>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
        </div>
    </div>
</div>

<div class="info-section">
    <div class="news-updates">
        <h3>News & Updates</h3>
        <p>News description</p>
        <img src="{{ asset('images/news_update.jpg') }}" alt="News and Updates">
    </div>

    <div class="upcoming-events">
        <h3>Upcoming Events</h3>
        <ul>
            <li>June 1: PMDKK CUP</li>
            <li>June 2: PMDKK CUP</li>
            <li>June 3: PMDKK CUP</li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const highlights = document.querySelectorAll('.highlight');
    highlights.forEach((highlight) => {
        const images = highlight.querySelectorAll('img');
        let currentIndex = 0;

        setInterval(() => {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }, 3000);
    });
});
</script>

<footer>
        @include('components.footer')
</footer>

