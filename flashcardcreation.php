<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashPoint</title>
    <link rel="stylesheet" href="style.css">
    <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="node_modules/froala-editor/css/themes/dark.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
</head>
<body>
    <div class="wrapper"> 
        <form id="flashcards-form" action="create.php" class="forms">
        <div class="container">
            <div>
                <input type="text" required name="fp-name" tooltip="Flashcards name cannot be empty." placeholder="Enter flashcards name." autocomplete="off" style="text-align: center;">
            </div>
        <div id="fp-container">
            <div class="card">
                <div class="fp-question-text"></div>
                <script> 
                    var editor = new FroalaEditor('.fp-question-text', {
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
                            'moreText': {
                                'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'clearFormatting']
                            },
                            'moreParagraph': {
                                'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'outdent', 'indent']
                            },
                            'moreRich': {
                                'buttons': ['specialCharacters', 'embedly']
                            },
                            'moreMisc': {
                                'buttons': ['undo', 'redo'],
                                'align': 'right',
                                'buttonsVisible': 2
                            }
                        }
                    });
                </script>
                
                <div class="fp-answer">
                    <input type="text" id="fp-answer-answer" name="fp-answer-answer" placeholder="Enter correct answer text." required autocomplete="off">
                </div>
                <div>
                    <button onclick="cloneCard(event)" class="cardbutton" type="button" >+</button>
                    <button onclick="deleteCard(event)" class="cardbutton" type="button" >-</button>
                </div>
            </div>
        </div>       
        <div>
            <input type="checkbox" value="1" class="is_public" id="is_public" name="is_public"> Make flashcard public
        </div>
            </div>
                <input onclick="saveFlashcards()" class="submit" type="button"  value="Save Flashcards">
                <a href="home.php"><input class="submit" type="button" value="Exit"></a>
            </div>
        </form>
        
    </div> 
<script src="cloneanddelete.js"></script>
<script src="submit-fp.js"></script>
</body>
</html>