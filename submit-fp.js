document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('button').addEventListener('click', saveFlashcards);
});


function saveFlashcards() {
    // Gather all cards' data
    let cards = [];
    document.querySelectorAll('#fp-container .card').forEach(card => {
        let question = card.querySelector('.fp-question-text').innerHTML;  // Froala Editor content
        let answer = card.querySelector('.fp-answer input').value;  // Answer input value
        cards.push({ question: question, answer: answer });
    });

    // Get the flashcard set name
    let flashcardName = document.querySelector('input[name="fp-name"]').value;
    
    // Check if the checkbox is checked and determine public/private status
    let isPublic = document.getElementById('is_public').checked ? 1 : 0;

    // Prepare the data to be sent to the server
    let data = {
        name: flashcardName,
        cards: cards,
        is_public: isPublic
    };

    // Send the data to the server
    fetch('http://localhost/Flahcards/create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert("Flashcards saved successfully!");
        } else {
            alert("Error saving flashcards.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function saveFlashcards() {
    // Gather all cards' data
    let cards = [];
    document.querySelectorAll('#fp-container .card').forEach(card => {
        let question = card.querySelector('.fp-question-text').innerHTML;  // Froala Editor content
        let answer = card.querySelector('.fp-answer input').value;  // Answer input value
        cards.push({ question: question, answer: answer });
    });

    // Get the flashcard set name
    let flashcardName = document.querySelector('input[name="fp-name"]').value;
    
    // Check if the checkbox is checked and determine public/private status
    let isPublic = document.getElementById('is_public').checked ? 1 : 0;

    // Prepare the data to be sent to the server
    let data = {
        name: flashcardName,
        cards: cards,
        is_public: isPublic
    };

    // Send the data to the server
    fetch('http://localhost/Flahcards/create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert("Flashcards saved successfully!");
        } else {
            alert("Error saving flashcards.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
