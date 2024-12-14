let currentIndex = 0; // Tracks how many items are loaded
let newsData = []; // Placeholder for the news data

// Function to fetch news data from the PHP script
async function fetchNews() {
    try {
        // Load the news data only once
        if (newsData.length === 0) {
            const response = await fetch('fetch_news.php');
            newsData = await response.json();
        }

        const newsFeed = document.getElementById('newsFeed');
        const itemsToLoad = 2; // Number of items to load per click

        // Add new items to the feed
        for (let i = 0; i < itemsToLoad && currentIndex < newsData.length; i++) {
            const item = newsData[currentIndex++];
            const div = document.createElement('div');
            div.className = 'content-box';

            div.innerHTML = `
                <div class="header-update"><h1>${item.title}</h1></div>
                    <div class="content-top">
                        <div class="news-date">Date: ${item.date}</div>
                        <div class="news-author">Author: ${item.author}</div>
                    </div>
                <div class="content">${item.content}
                    <img src="${item.image}" alt="News Image" class="news-image">
                </div>
                <a href="${item.link}" target="_blank">Learn More</a>
            `;

            newsFeed.appendChild(div);
        }

        // Disable the button if all items are loaded
        if (currentIndex >= newsData.length) {
            const button = document.querySelector('button');
            button.disabled = true;
            button.textContent = 'No More News';
        }
    } catch (error) {
        console.error('Error fetching news:', error);
    }
}

// Load the first set of news items when the page loads
window.onload = fetchNews;
