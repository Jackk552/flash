// Function to clone a card
function cloneCard(button) {
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
function deleteCard(button) {
    let cardsContainer = document.getElementById('fp-container');
    if (cardsContainer.children.length > 1) {
        let card = button.closest('.card');
        card.remove();
    } else {
        alert("You need to have at least one card.");
    }
}
