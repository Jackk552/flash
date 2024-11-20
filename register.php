<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Comma-delimited bad words list
$badWords = ["4r5e", "5h1t", "5hit", "a55", "anal", "anus", "ar5e", "arrse", "arse", "ass", "ass-fucker", "asses", "assfucker", "assfukka", "asshole", "assholes", "asswhole", "a_s_s", "b!tch", "b00bs", "b17ch", "b1tch", "ballbag", "balls", "ballsack", "bastard", "beastial", "beastiality", "bellend", "bestial", "bestiality", "bi+ch", "biatch", "bitch", "bitcher", "bitchers", "bitches", "bitchin", "bitching", "bloody", "blow job", "blowjob", "blowjobs", "boiolas", "bollock", "bollok", "boner", "boob", "boobs", "booobs", "boooobs", "booooobs", "booooooobs", "breasts", "buceta", "bugger", "bum", "bunny fucker", "butt", "butthole", "buttmuch", "buttplug", "c0ck", "c0cksucker", "carpet muncher", "cawk", "chink", "cipa", "cl1t", "clit", "clitoris", "clits", "cnut", "cock", "cock-sucker", "cockface", "cockhead", "cockmunch", "cockmuncher", "cocks", "cocksuck ", "cocksucked ", "cocksucker", "cocksucking", "cocksucks ", "cocksuka", "cocksukka", "cok", "cokmuncher", "coksucka", "coon", "cox", "crap", "cum", "cummer", "cumming", "cums", "cumshot", "cunilingus", "cunillingus", "cunnilingus", "cunt", "cuntlick ", "cuntlicker ", "cuntlicking ", "cunts", "cyalis", "cyberfuc", "cyberfuck ", "cyberfucked ", "cyberfucker", "cyberfuckers", "cyberfucking ", "d1ck", "damn", "dick", "dickhead", "dildo", "dildos", "dink", "dinks", "dirsa", "dlck", "dog-fucker", "doggin", "dogging", "donkeyribber", "doosh", "duche", "dyke", "ejaculate", "ejaculated", "ejaculates ", "ejaculating ", "ejaculatings", "ejaculation", "ejakulate", "f u c k", "f u c k e r", "f4nny", "fag", "fagging", "faggitt", "faggot", "faggs", "fagot", "fagots", "fags", "fanny", "fannyflaps", "fannyfucker", "fanyy", "fatass", "fcuk", "fcuker", "fcuking", "feck", "fecker", "felching", "fellate", "fellatio", "fingerfuck ", "fingerfucked ", "fingerfucker ", "fingerfuckers", "fingerfucking ", "fingerfucks ", "fistfuck", "fistfucked ", "fistfucker ", "fistfuckers ", "fistfucking ", "fistfuckings ", "fistfucks ", "flange", "fook", "fooker", "fuck", "fucka", "fucked", "fucker", "fuckers", "fuckhead", "fuckheads", "fuckin", "fucking", "fuckings", "fuckingshitmotherfucker", "fuckme ", "fucks", "fuckwhit", "fuckwit", "fudge packer", "fudgepacker", "fuk", "fuker", "fukker", "fukkin", "fuks", "fukwhit", "fukwit", "fux", "fux0r", "f_u_c_k", "gangbang", "gangbanged ", "gangbangs ", "gaylord", "gaysex", "goatse", "god-dam", "god-damned", "goddamn", "goddamned", "hardcoresex ", "hell", "heshe", "hoar", "hoare", "hoer", "homo", "hore", "horniest", "horny", "hotsex", "jack-off ", "jackoff", "jap", "jerk-off ", "jism", "jiz ", "jizm ", "jizz", "kawk", "knob", "knobead", "knobed", "knobend", "knobhead", "knobjocky", "knobjokey", "kock", "kondum", "kondums", "kum", "kummer", "kumming", "kums", "kunilingus", "l3i+ch", "l3itch", "labia", "lmfao", "lust", "lusting", "m0f0", "m0fo", "m45terbate", "ma5terb8", "ma5terbate", "masochist", "master-bate", "masterb8", "masterbat*", "masterbat3", "masterbate", "masterbation", "masterbations", "masturbate", "mo-fo", "mof0", "mofo", "mothafuck", "mothafucka", "mothafuckas", "mothafuckaz", "mothafucked ", "mothafucker", "mothafuckers", "mothafuckin", "mothafucking ", "mothafuckings", "mothafucks", "mother fucker", "motherfuck", "motherfucked", "motherfucker", "motherfuckers", "motherfuckin", "motherfucking", "motherfuckings", "motherfuckka", "motherfucks", "muff", "mutha", "muthafecker", "muthafuckker", "muther", "mutherfucker", "n1gga", "n1gger", "nazi", "nigg3r", "nigg4h", "nigga", "niggah", "niggas", "niggaz", "nigger", "niggers ", "nob", "nob jokey", "nobhead", "nobjocky", "nobjokey", "numbnuts", "nutsack", "orgasim ", "orgasims ", "orgasm", "orgasms ", "p0rn", "pawn", "pecker", "penis", "penisfucker", "phonesex", "phuck", "phuk", "phuked", "phuking", "phukked", "phukking", "phuks", "phuq", "pigfucker", "pimpis", "piss", "pissed", "pisser", "pissers", "pisses ", "pissflaps", "pissin ", "pissing", "pissoff ", "poop", "porn", "porno", "pornography", "pornos", "prick", "pricks ", "pron", "pube", "pusse", "pussi", "pussies", "pussy", "pussys ", "rectum", "retard", "rimjaw", "rimming", "s hit", "s.o.b.", "sadist", "schlong", "screwing", "scroat", "scrote", "scrotum", "semen", "sex", "sh!+", "sh!t", "sh1t", "shag", "shagger", "shaggin", "shagging", "shemale", "shi+", "shit", "shitdick", "shite", "shited", "shitey", "shitfuck", "shitfull", "shithead", "shiting", "shitings", "shits", "shitted", "shitter", "shitters ", "shitting", "shittings", "shitty ", "skank", "slut", "sluts", "smegma", "smut", "snatch", "son-of-a-bitch", "spac", "spunk", "s_h_i_t", "t1tt1e5", "t1tties", "teets", "teez", "testical", "testicle", "tit", "titfuck", "tits", "titt", "tittie5", "tittiefucker", "titties", "tittyfuck", "tittywank", "titwank", "tosser", "turd", "tw4t", "twat", "twathead", "twatty", "twunt", "twunter", "v14gra", "v1gra", "vagina", "viagra", "vulva", "w00se", "wang", "wank", "wanker", "wanky", "whoar", "whore", "willies", "xrated", "xxx", 
    "putangina", "pucha", "gago", "tanga", "bobo", "ulol", "tarantado", "bwisit", "leche", "hayop", "puta", "punyeta", "lintik", "demonyo", "siraulo", "buwisit", "shet", "sumpa", "hindot", "kapal", "engkanto", "kumag", "lintik", "balasubas", "sumpungin", "hinayupak", "putangina", "puta", "putang ina", "pucha", "puchangina", "gago", "gagu", "gaga", "gag0", "g4go", "g4g0", "tanga", "tnga", "tn_ga", "bobo", "b0b0", "bob0", "b0bo", "boba", "ulol", "ullol", "ulo1", "tarantado", "tarantada", "trntdo", "tarantd", "bwisit", "buwisit", "bw1s1t", "buw1s1t", "leche", "lecheng", "l3che", "leches", "hayop", "hayup", "hay0p", "puta", "p_ta", "putcha", "put_cha", "punyeta", "pnyeta", "pnye_ta", "lintik", "lint1k", "lint1c", "lint1ck", "demonyo", "demonya", "dem0nyo", "d3monyo", "siraulo", "sirang-ulo", "sir4ngulo", "sira_ulo", "sira-ulo", "shet", "sh3t", "shit", "sh1t", "sumpa", "hinayupak", "hinay0pak", "hindot", "h1ndot", "hind0t", "hudas", "hud@s", "kapal", "kapal-mukha", "kap4l", "kap4lmukha", "engkanto", "engk@nt0", "kumag", "kum@g", "balasubas", "b@lasubas", "burat", "bur@t", "b0rat", "bura_t", "pakyu", "pakyuin", "pak-yu", "p4kyu", "tangina", "tang_ina", "tang-ina", "kantot", "kantutan", "kant_t", "kant0t", "bwakaw", "bw@kaw", "loko", "lukaret", "luk_r3t", "ogag", "og@g", "gunggong", "gung_gong", "buwakanang", "buw@kanang", "kamote", "k_mot3", "tanga-tanga", "tn_g-tn_ga", "ogags", "og@gs", "putangina", "pucha", "gago", "gaga", "tanga", "bobo", "boba", "ulol", "tarantado", "tarantada", "bwisit", "buwisit", "leche", "lecheng", "hayop", "hayup", "puta", "putcha", "punyeta", "lintik", "lintikang", "demonyo", "demonya", "siraulo", "sirang-ulo", "sira-ulo", "shet", "shit", "sumpa", "hinayupak", "hindot", "hudas", "kapal", "kapal-mukha", "engkanto", "engkang", "kumag", "balasubas", "burat", "pakyu", "pakyuin", "tangina", "tang-ina", "kantot", "kantutan", "kantut", "bwakaw", "loko", "lukaret", "ogag", "gunggong", "buwakanang", "kamote", "tanga-tanga", "ogags", "yawa", "tangena", "Tangena", "TANGENA", "YAWA", "Yawa"]; // Add all your bad words here

// Function to check for bad words
function containsBadWords($string, $badWords) {
    foreach ($badWords as $word) {
        if (stripos($string, $word) !== false) { // Case insensitive check
            return true;
        }
    }
    return false;
}

// Registration Process
if (isset($_POST['signUp'])) {   
    $first_name = $_POST['first_name'];
    $last_name = $_POST["last_name"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = md5($password); // Use password_hash() for better security

    // Check for bad words in the username
    if (containsBadWords($username, $badWords)) {
        header("Location: signup.php?error=username_contains_inappropriate_words");
        exit();
    }

    // Check if the password is at least 8 characters long
    if (strlen($password) < 8) {
        header("Location: signup.php?error=password_must_be_at_least_8_characters_long");
        exit();
    }
    // Check if username already exists
    $stmt = $mysqli->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists.";
    } else {   
        // Insert new account
        $stmt = $mysqli->prepare("INSERT INTO accounts (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $username, $hashedPassword);
        
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Login Process
if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Use password_verify() instead of md5()

    // Correct SQL syntax
    $stmt = $mysqli->prepare("SELECT id, username, password, role FROM accounts WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_start(); // Start the session
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username']; // Store username
            $_SESSION['user_id'] = $row['id']; // Set user_id in the session
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'user') {
                // If the role is admin, redirect to the admin page
                
                header("Location: home.php");
                exit();
            } else if ($row['role'] === 'admin'){
                // If the role is user, redirect to the home page
                header("Location: admin_reports.php");
                exit();
            }
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
}