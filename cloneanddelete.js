document.addEventListener("DOMContentLoaded", function() {
    // Ensure the container exists before attaching any event listeners
    let fpContainer = document.getElementById('fp-container');
    if (fpContainer) {
        // Attach event listeners to existing and future "+" and "-" buttons within the container
        fpContainer.addEventListener('click', function(event) {
            // Use event delegation to check if a "+" or "-" button was clicked
            if (event.target && event.target.matches('.cardbutton')) {
                if (event.target.textContent === '+') {
                    cloneCard(event.target, event);  // Call the cloneCard function
                } else if (event.target.textContent === '-') {
                    deleteCard(event.target, event);  // Call the deleteCard function
                }
            }
        });
    } else {
        console.error("Container with id 'fp-container' not found.");
    }
});

// Function to clone a card
function cloneCard(button, event) {
    // Prevent event propagation
    event.stopPropagation();

    let card = button.closest('.card');
    let clonedCard = card.cloneNode(true);

    // Append the cloned card to the container
    document.getElementById('fp-container').appendChild(clonedCard);

    // Reinitialize Froala Editor for the new .fp-question-text in the cloned card
    new FroalaEditor(clonedCard.querySelector('.fp-question-text'), {
        toolbarInline: true,
        theme: "dark",
        charCounterCount: false,
        wordCounterCount: false,
        quickInsertEnabled: false,
        placeholderText: 'Front cannot be empty.',
        fileUpload: false,
        heightMax: 100,
        width: '150',
        toolbarButtons: {
            'moreText': { 'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'clearFormatting'] },
            'moreParagraph': { 'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'outdent', 'indent'] },
            'moreRich': { 'buttons': ['specialCharacters', 'embedly'] },
            'moreMisc': { 'buttons': ['undo', 'redo'], 'align': 'right', 'buttonsVisible': 2 }
        }
    });
}

// Function to delete a card, with a minimum card check
function deleteCard(button, event) {
    // Prevent event propagation
    event.stopPropagation();

    let cardsContainer = document.getElementById('fp-container');
    if (cardsContainer.children.length > 1) {
        let card = button.closest('.card');
        card.remove();
    } else {
        alert("You need to have at least one card.");
    }
}
