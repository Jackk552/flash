const flashcardsForm = document.querySelector('.forms');
const flashcardsContainer =  document.querySelector('.flashcards');
const flashcardFront = flashcardForm['front'];
const flashcardBack = flashcardForm['back'];

const flashcards = [{
    front: "What the fu?",
    back: "yes"
}];

const addFlashcards = (front, back) => {

};

const createFlashcardElement = ({front, back}) =>{
    const flashcardDiv = document.createElement('div');
    const flashcardFront = document.createElement('p');
    const flashcardBack = document.createElement('p');

    flashcardFront.innerText = front;
    flashcardBack.innerText = back;

    flashcardDiv.append(flashcardFront, flashcardBack);
    flashcardContainer.appendChild(flashcardDiv); 
};

flashcards.forEach(createFlashcardElement)

flashcardsForm.onsubmit = e => {
    e.preventDefault();
}
