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
                <div class="header-update">
                    ${item.news_type}
                </div>
                    <div class="author-container">
                        <img src="${item.avatar}" alt="Author Avatar" class="author-avatar">
                    </div>
                    <div>
                        <span class="author-name">${item.author}</span>
                    </div>
                    <div class="content">
                        <div class="date-class">${item.date}</div>
                        <div class ="title-class">${item.title}</div>
                        <div class ="subtitle-class">${item.subtitle}</div>
                        <div class ="content-class">${item.content}</div>
                        <div class="image-container">
                            <img src="${item.image}" alt="#">
                        </div>
                    </div>
                        
                    
            
            `;

            newsFeed.appendChild(div);
        }

        // Disable the button if all items are loaded
        if (currentIndex >= newsData.length) {
            const button = document.querySelector('button:not(.btn-search)');
            button.disabled = true;
            button.textContent = 'No More News';
        }
    } catch (error) {
        console.error('Error fetching news:', error);
    }
}

// Load the first set of news items when the page loads
window.onload = fetchNews;
