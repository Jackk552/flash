function saveEditFlashcards() {
    // Flag for validation
    let isValid = true;

    // Bad words list
   let badWords = ["4r5e", "5h1t", "5hit", "a55", "anal", "anus", "ar5e", "arrse", "arse", "ass", "ass-fucker", "asses", "assfucker", "assfukka", "asshole", "assholes", "asswhole", "a_s_s", "b!tch", "b00bs", "b17ch", "b1tch", "ballbag", "balls", "ballsack", "bastard", "beastial", "beastiality", "bellend", "bestial", "bestiality", "bi+ch", "biatch", "bitch", "bitcher", "bitchers", "bitches", "bitchin", "bitching", "bloody", "blow job", "blowjob", "blowjobs", "boiolas", "bollock", "bollok", "boner", "boob", "boobs", "booobs", "boooobs", "booooobs", "booooooobs", "breasts", "buceta", "bugger", "bum", "bunny fucker", "butt", "butthole", "buttmuch", "buttplug", "c0ck", "c0cksucker", "carpet muncher", "cawk", "chink", "cipa", "cl1t", "clit", "clitoris", "clits", "cnut", "cock", "cock-sucker", "cockface", "cockhead", "cockmunch", "cockmuncher", "cocks", "cocksuck ", "cocksucked ", "cocksucker", "cocksucking", "cocksucks ", "cocksuka", "cocksukka", "cok", "cokmuncher", "coksucka", "coon", "cox", "crap", "cum", "cummer", "cumming", "cums", "cumshot", "cunilingus", "cunillingus", "cunnilingus", "cunt", "cuntlick ", "cuntlicker ", "cuntlicking ", "cunts", "cyalis", "cyberfuc", "cyberfuck ", "cyberfucked ", "cyberfucker", "cyberfuckers", "cyberfucking ", "d1ck", "damn", "dick", "dickhead", "dildo", "dildos", "dink", "dinks", "dirsa", "dlck", "dog-fucker", "doggin", "dogging", "donkeyribber", "doosh", "duche", "dyke", "ejaculate", "ejaculated", "ejaculates ", "ejaculating ", "ejaculatings", "ejaculation", "ejakulate", "f u c k", "f u c k e r", "f4nny", "fag", "fagging", "faggitt", "faggot", "faggs", "fagot", "fagots", "fags", "fanny", "fannyflaps", "fannyfucker", "fanyy", "fatass", "fcuk", "fcuker", "fcuking", "feck", "fecker", "felching", "fellate", "fellatio", "fingerfuck ", "fingerfucked ", "fingerfucker ", "fingerfuckers", "fingerfucking ", "fingerfucks ", "fistfuck", "fistfucked ", "fistfucker ", "fistfuckers ", "fistfucking ", "fistfuckings ", "fistfucks ", "flange", "fook", "fooker", "fuck", "fucka", "fucked", "fucker", "fuckers", "fuckhead", "fuckheads", "fuckin", "fucking", "fuckings", "fuckingshitmotherfucker", "fuckme ", "fucks", "fuckwhit", "fuckwit", "fudge packer", "fudgepacker", "fuk", "fuker", "fukker", "fukkin", "fuks", "fukwhit", "fukwit", "fux", "fux0r", "f_u_c_k", "gangbang", "gangbanged ", "gangbangs ", "gaylord", "gaysex", "goatse", "god-dam", "god-damned", "goddamn", "goddamned", "hardcoresex ", "hell", "heshe", "hoar", "hoare", "hoer", "homo", "hore", "horniest", "horny", "hotsex", "jack-off ", "jackoff", "jap", "jerk-off ", "jism", "jiz ", "jizm ", "jizz", "kawk", "knob", "knobead", "knobed", "knobend", "knobhead", "knobjocky", "knobjokey", "kock", "kondum", "kondums", "kum", "kummer", "kumming", "kums", "kunilingus", "l3i+ch", "l3itch", "labia", "lmfao", "lust", "lusting", "m0f0", "m0fo", "m45terbate", "ma5terb8", "ma5terbate", "masochist", "master-bate", "masterb8", "masterbat*", "masterbat3", "masterbate", "masterbation", "masterbations", "masturbate", "mo-fo", "mof0", "mofo", "mothafuck", "mothafucka", "mothafuckas", "mothafuckaz", "mothafucked ", "mothafucker", "mothafuckers", "mothafuckin", "mothafucking ", "mothafuckings", "mothafucks", "mother fucker", "motherfuck", "motherfucked", "motherfucker", "motherfuckers", "motherfuckin", "motherfucking", "motherfuckings", "motherfuckka", "motherfucks", "muff", "mutha", "muthafecker", "muthafuckker", "muther", "mutherfucker", "n1gga", "n1gger", "nazi", "nigg3r", "nigg4h", "nigga", "niggah", "niggas", "niggaz", "nigger", "niggers ", "nob", "nob jokey", "nobhead", "nobjocky", "nobjokey", "numbnuts", "nutsack", "orgasim ", "orgasims ", "orgasm", "orgasms ", "p0rn", "pawn", "pecker", "penis", "penisfucker", "phonesex", "phuck", "phuk", "phuked", "phuking", "phukked", "phukking", "phuks", "phuq", "pigfucker", "pimpis", "piss", "pissed", "pisser", "pissers", "pisses ", "pissflaps", "pissin ", "pissing", "pissoff ", "poop", "porn", "porno", "pornography", "pornos", "prick", "pricks ", "pron", "pube", "pusse", "pussi", "pussies", "pussy", "pussys ", "rectum", "retard", "rimjaw", "rimming", "s hit", "s.o.b.", "sadist", "schlong", "screwing", "scroat", "scrote", "scrotum", "semen", "sex", "sh!+", "sh!t", "sh1t", "shag", "shagger", "shaggin", "shagging", "shemale", "shi+", "shit", "shitdick", "shite", "shited", "shitey", "shitfuck", "shitfull", "shithead", "shiting", "shitings", "shits", "shitted", "shitter", "shitters ", "shitting", "shittings", "shitty ", "skank", "slut", "sluts", "smegma", "smut", "snatch", "son-of-a-bitch", "spac", "spunk", "s_h_i_t", "t1tt1e5", "t1tties", "teets", "teez", "testical", "testicle", "tit", "titfuck", "tits", "titt", "tittie5", "tittiefucker", "titties", "tittyfuck", "tittywank", "titwank", "tosser", "turd", "tw4t", "twat", "twathead", "twatty", "twunt", "twunter", "v14gra", "v1gra", "vagina", "viagra", "vulva", "w00se", "wang", "wank", "wanker", "wanky", "whoar", "whore", "willies", "xrated", "xxx", 
    "putangina", "pucha", "gago", "tanga", "bobo", "ulol", "tarantado", "bwisit", "leche", "hayop", "puta", "punyeta", "lintik", "demonyo", "siraulo", "buwisit", "shet", "sumpa", "hindot", "kapal", "engkanto", "kumag", "lintik", "balasubas", "sumpungin", "hinayupak", "putangina", "puta", "putang ina", "pucha", "puchangina", "gago", "gagu", "gaga", "gag0", "g4go", "g4g0", "tanga", "tnga", "tn_ga", "bobo", "b0b0", "bob0", "b0bo", "boba", "ulol", "ullol", "ulo1", "tarantado", "tarantada", "trntdo", "tarantd", "bwisit", "buwisit", "bw1s1t", "buw1s1t", "leche", "lecheng", "l3che", "leches", "hayop", "hayup", "hay0p", "puta", "p_ta", "putcha", "put_cha", "punyeta", "pnyeta", "pnye_ta", "lintik", "lint1k", "lint1c", "lint1ck", "demonyo", "demonya", "dem0nyo", "d3monyo", "siraulo", "sirang-ulo", "sir4ngulo", "sira_ulo", "sira-ulo", "shet", "sh3t", "shit", "sh1t", "sumpa", "hinayupak", "hinay0pak", "hindot", "h1ndot", "hind0t", "hudas", "hud@s", "kapal", "kapal-mukha", "kap4l", "kap4lmukha", "engkanto", "engk@nt0", "kumag", "kum@g", "balasubas", "b@lasubas", "burat", "bur@t", "b0rat", "bura_t", "pakyu", "pakyuin", "pak-yu", "p4kyu", "tangina", "tang_ina", "tang-ina", "kantot", "kantutan", "kant_t", "kant0t", "bwakaw", "bw@kaw", "loko", "lukaret", "luk_r3t", "ogag", "og@g", "gunggong", "gung_gong", "buwakanang", "buw@kanang", "kamote", "k_mot3", "tanga-tanga", "tn_g-tn_ga", "ogags", "og@gs", "putangina", "pucha", "gago", "gaga", "tanga", "bobo", "boba", "ulol", "tarantado", "tarantada", "bwisit", "buwisit", "leche", "lecheng", "hayop", "hayup", "puta", "putcha", "punyeta", "lintik", "lintikang", "demonyo", "demonya", "siraulo", "sirang-ulo", "sira-ulo", "shet", "shit", "sumpa", "hinayupak", "hindot", "hudas", "kapal", "kapal-mukha", "engkanto", "engkang", "kumag", "balasubas", "burat", "pakyu", "pakyuin", "tangina", "tang-ina", "kantot", "kantutan", "kantut", "bwakaw", "loko", "lukaret", "ogag", "gunggong", "buwakanang", "kamote", "tanga-tanga", "ogags", "yawa", "tangena", "Tangena", "TANGENA", "YAWA", "Yawa"];

    // Function to check if a string contains any bad words
    function containsBadWords(text) {
        return badWords.some(badWord => text.toLowerCase().includes(badWord.toLowerCase()));
    }

    // Get the flashcard set name and validate it
    let flashcardName = document.querySelector('input[name="fp-name"]').value.trim();
    if (flashcardName === "") {
        alert("Please enter a flashcard name.");
        isValid = false;
    }

    // Ensure the checkbox exists and is accessible
    let isPublicCheckbox = document.getElementById('is_public');
    let isPublic = isPublicCheckbox && isPublicCheckbox.checked ? 1 : 0;

    // Only check for bad words if the flashcards are public
    if (isPublic) {
        if (containsBadWords(flashcardName)) {
            alert("The flashcard set name contains inappropriate words. Please revise it.");
            isValid = false;
        }
    }

    // Gather and validate all cards' data
    let cards = [];
    document.querySelectorAll('#fp-container .card').forEach(card => {
        let froalaContent = card.querySelector('.fp-question-text').innerHTML.trim(); // Froala Editor content
        let cleanedQuestion = froalaContent.replace(/<[^>]+>/g, '').trim(); // Strip HTML tags for more accurate content check
        let answer = card.querySelector('.fp-answer input').value.trim(); // Answer input value

        // Check if the question is empty or contains only placeholder text
        if (cleanedQuestion === "" || cleanedQuestion === "Front cannot be empty.") {
            alert("Please fill in the front (question) for all flashcards.");
            isValid = false;
        }
        if (answer === "") {
            alert("Please provide a correct answer for all flashcards.");
            isValid = false;
        }

        // Only check for bad words if the flashcards are public
        if (isPublic) {
            if (containsBadWords(cleanedQuestion)) {
                alert("The question contains inappropriate words. Please revise it.");
                isValid = false;
            }
            if (containsBadWords(answer)) {
                alert("The answer contains inappropriate words. Please revise it.");
                isValid = false;
            }
        }

        // Only add the card if valid (optional, depending on your use case)
        cards.push({ question: froalaContent, answer: answer });
    });

    // If validation fails, stop the process
    if (!isValid) {
        return;
    }

    // Prepare the data to be sent to the server
    let data = {
        name: flashcardName,
        cards: cards,
        is_public: isPublic
    };

    // Send the data to the server
    fetch('http://localhost/Flahcards/update.php', {
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
