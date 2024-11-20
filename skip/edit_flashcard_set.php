<?php
session_start();
session_regenerate_id(true);
require 'connect.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (!isset($_GET['set_id'])) {
    echo "No flashcard set specified.";
    exit();
}

$setId = (int) $_GET['set_id'];

// Fetch the flashcard set information
$stmt = $mysqli->prepare("SELECT id, name FROM flashcardsets WHERE user_id = ? AND id = ?");
$stmt->bind_param("ii", $userId, $setId);
$stmt->execute();
$flashcardSet = $stmt->get_result()->fetch_assoc();

if (!$flashcardSet) {
    echo "Flashcard set not found.";
    exit();
}

// Fetch flashcards within the set
$stmt = $mysqli->prepare("SELECT id, question, answer FROM flashcards WHERE set_id = ?");
$stmt->bind_param("i", $setId);
$stmt->execute();
$flashcardsResult = $stmt->get_result();

// Handle form submission for editing the set name and flashcards
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update set name
    if (!empty($_POST['set_name'])) {
        $newSetName = trim($_POST['set_name']);
        $stmt = $mysqli->prepare("UPDATE flashcardsets SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $newSetName, $setId);
        $stmt->execute();
    }

    // Update flashcards
    if (isset($_POST['flashcards'])) {
        foreach ($_POST['flashcards'] as $flashcardId => $flashcardData) {
            $question = $flashcardData['question'];
            $answer = $flashcardData['answer'];
            if (!empty($question) && !empty($answer)) {
                $stmt = $mysqli->prepare("UPDATE flashcards SET question = ?, answer = ? WHERE id = ?");
                $stmt->bind_param("ssi", $question, $answer, $flashcardId);
                $stmt->execute();
            }
        }
    }

    // Check if the "is_public" checkbox was checked (value will be 1 if checked)
    $isPublic = isset($_POST['is_public']) ? 1 : 0;

    // Update the public visibility of the flashcard set
    $stmt = $mysqli->prepare("UPDATE flashcardsets SET is_public = ? WHERE id = ?");
    $stmt->bind_param("ii", $isPublic, $setId);
    $stmt->execute();

    // Redirect to the Flashcards Manager page after updating
    header("Location: flashcards_manager.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flashcard Set</title>
    <link rel="stylesheet" href="style.css">
    <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="node_modules/froala-editor/css/themes/dark.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
</head>
<body>
    <div class="wrapper"> 
        <form id="flashcards-form" action="edit_flashcard_set.php?set_id=<?= $setId ?>" method="POST" class="forms">
            <div class="container">
                <!-- Flashcard Set Name -->
                <div>
                    <input type="text" required name="fp-name" value="<?= htmlspecialchars($flashcardSet['name']) ?>" placeholder="Enter flashcards name" autocomplete="off" style="text-align: center;">
                </div>

                <!-- Flashcard Question and Answer Inputs -->
                <div id="fp-container">
                    <?php while ($flashcard = $flashcardsResult->fetch_assoc()): ?>
                        <div class="card">
                            <!-- Froala Editor for Flashcard Question -->
                            <input type="hidden" name="flashcard-set-id" value="<?= $setId ?>">

                            <div class="fp-question-text">
                                <div class="fp-question-text-<?= $flashcard['id'] ?>"><?= htmlspecialchars(strip_tags(str_replace("Front cannot be empty.", "", $flashcard['question']))) ?></div>
                            </div>

                            <script>
                                // Initialize Froala Editor for each flashcard question
                                var editor_<?= $flashcard['id'] ?> = new FroalaEditor('.fp-question-text-<?= $flashcard['id'] ?>', {
                                    toolbarInline: true,
                                    theme: "dark",
                                    charCounterCount: false,
                                    wordCounterCount: false,
                                    quickInsertEnabled: false,
                                    placeholderText: '', // Completely remove the placeholder text
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
                                    },
                                    events: {
                                        'initialized': function() {
                                            // When Froala editor is initialized, remove any potential placeholder
                                            var editorElement = this.$el;
                                            editorElement.find('.fr-placeholder').remove();
                                        }
                                    }
                                });
                            </script>
                            
                            <!-- Answer Field -->
                            <div class="fp-answer">
                                <input type="text" name="flashcards[<?= $flashcard['id'] ?>][answer]" value="<?= htmlspecialchars($flashcard['answer']) ?>" placeholder="Enter correct answer text" required autocomplete="off">
                            </div>
                            
                            <div>
                                <button onclick="cloneCard(this)" class="cardbutton" type="button">+</button>
                                <button onclick="deleteCard(this)" class="cardbutton" type="button">-</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Public Checkbox -->
                <div>
                    <input type="checkbox" value="1" class="is_public" id="is_public" name="is_public" <?= isset($flashcardSet['is_public']) && $flashcardSet['is_public'] ? 'checked' : '' ?>> Make flashcard public
                </div>
            </div>

            <div>
                <input onclick="saveEditFlashcards()" class="submit" type="button" value="Save Flashcards">
                <a href="home.php"><input class="submit" type="button" value="Exit"></a>
            </div>
        </form>
    </div>

    <script src="cloneanddelete.js"></script>
    <script src="submit-edit.js"></script>
</body>
</html>
