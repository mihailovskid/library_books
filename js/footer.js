$('DOMContentLoaded', getRandomQuote);

function getRandomQuote() {
    fetch('https://api.quotable.io/random')
        .then(response => response.json())
        .then(data => {
            const authorElement = document.getElementById('author-name');
            const contentElement = document.getElementById('content');

            authorElement.textContent = data.author;
            contentElement.textContent = data.content;
        })
        .catch(error => {
            console.error('Error fetching random quote:', error);
        });
}