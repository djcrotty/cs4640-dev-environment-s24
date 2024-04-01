<?php

class CategoryGameController {

    // An error message to display on the welcome page
    private $errorMessage = "";

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start(); // start a session!
        
        // Set input
        $this->input = $input;
    }

    /**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
    public function run() {
        // Get the command
        $command = "welcome";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        // If the session doesn't have the key "name", AND they
        // are not trying to login (UPDATE!), then they
        // got here without going through the welcome page, so we
        // should send them back to the welcome page only.
        if (!isset($_SESSION["name"]) && $command != "login")
            $command = "welcome";

        switch($command) {
            case "question":
                $this->showQuestion();
                break;
            case "answer":
                $this->answerQuestion();
                break;
            case "login":
                $this->login();
                break;
            case "gameOver":
                $this->gameOver();
                break;
            case "resetGame":
                $this->resetGame();
                break;
            case "logout":
                $this->logout();
                // no break; logout will also show the welcome page.
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Load questions from a file, store them as an array
     * in the current object.
     */
    public function loadQuestions() {
        $categories = json_decode(
            file_get_contents("/var/www/html/homework/connections.json"), true);
        if (empty($categories)) {
            die("Something went wrong loading questions");
        }
        //choose 4 random categories and place in SESSION object categories variable
        $rand_index = [];
        while(count($rand_index) < 4) {
            $rand_index[] = random_int(0, count($categories) - 1);
            $rand_index = array_unique($rand_index);
        }
        $chosen_categories = [];
        $keys = array_keys($categories);
        foreach ($rand_index as $index) {
            $chosen_categories[$keys[$index]] = $categories[$keys[$index]];
            //remove 2 words so its only 4 words per category
            $remove_keys = array_rand($chosen_categories[$keys[$index]], 2);
            unset($chosen_categories[$keys[$index]][$remove_keys[0]], $chosen_categories[$keys[$index]][$remove_keys[1]]);
        }
        $_SESSION["categories"] = $chosen_categories;

        //get each word and a number associated with it from the SESSION categories variable
        $words = [];
        foreach ($_SESSION["categories"] as $category) {
            foreach ($category as $word) {
                $words[] = $word;
            }
        }
        shuffle($words);
        array_unshift($words, "0 placeholder");
        $_SESSION["words"] = $words;
    }

    /**
     * Login Function
     *
     * This function checks that the user submitted the form and did not
     * leave the name and email inputs empty.  If all is well, we set
     * their information into the session and then send them to the 
     * question page.  If all didn't go well, we set the class field
     * errorMessage and show the welcome page again with that message.
     *
     * NOTE: This is the function we wrote in class!  It **should** also
     * check more detailed information about the name/email to make sure
     * they are valid.
     */
    public function login() {
        if (isset($_POST["fullname"]) && isset($_POST["email"]) &&
            !empty($_POST["fullname"]) && !empty($_POST["email"])) {
            $_SESSION["name"] = $_POST["fullname"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["score"] = 0;
            $_SESSION["guesses_log"] = [];
            $_SESSION["num_guesses"] = 0;
            $_SESSION["words"] = [];
            $_SESSION["correct_categories"] = [];
            $_SESSION['correct_words'] = [];
            $this->loadQuestions();
            header("Location: ?command=question");
            return;
        }
        $this->errorMessage = "Error logging in - Name and email is required";
        $this->showWelcome();
    }

    /**
     * Logout
     *
     * Destroys the session, essentially logging the user out.  It will then start
     * a new session so that we have $_SESSION if we need it.
     */
    public function logout() {
        session_destroy();
        session_start();
    }

    /**
     * Show a question to the user.  This function loads a
     * template PHP file and displays it to the user based on
     * properties of this object and the SESSION information.
     */
    public function showQuestion($message = "") {
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $score = $_SESSION["score"];
        $guesses_log = $_SESSION["guesses_log"];
        $words = $_SESSION["words"];
        $num_guesses = $_SESSION["num_guesses"];
        $correct_words = $_SESSION["correct_words"];
        // var_dump($_SESSION["categories"]);
        // var_dump($words);
        include("/opt/src/connections/templates/game.php");
    }

    /**
     * Show the welcome page to the user.
     */
    public function showWelcome() {
        // Show an optional error message if the errorMessage field
        // is not empty.
        $message = "";
        if (!empty($this->errorMessage)) {
            $message = "<div class='alert alert-danger'>{$this->errorMessage}</div>";
        }
        include("/opt/src/connections/templates/welcome.php");
    }

    /**
     * Check the user's answer to a question.
     */
    public function answerQuestion() {
        $message = "";
        if(count($_SESSION["correct_categories"]) >= 4) {
            header("Location: ?command=gameOver");
        }

        if (isset($_POST["answer"])) {
            $answer_words = explode(" ", $_POST["answer"]);
            var_dump($answer_words);
            
            $words = $_SESSION["words"];
            var_dump($words[intval($answer_words[0])]);
            $max_num_correct_words = 0;
            $max_num_correct_category = "";
            foreach ($_SESSION["categories"] as $key => $category) {
                var_dump($category);
                $num_correct_words = 0;
                foreach ($answer_words as $answer_word) {
                    if (intval($answer_word) < count($words) && in_array($words[intval($answer_word)], $category)) {
                        $num_correct_words += 1;
                        if ($num_correct_words > $max_num_correct_words) {
                            $max_num_correct_words = $num_correct_words;
                            $max_num_correct_category = $key;
                        }
                    }
                }
            }
            $_SESSION["num_guesses"] += 1;
            if ($max_num_correct_words == 0) {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                0 words correct!
                </div>";
                $_SESSION["guesses_log"][] = "0 words correct!";
            }
            elseif ($max_num_correct_words == 4) {
                $message = "<div class=\"alert alert-success\" role=\"alert\">
                ".$max_num_correct_words." words correct! The category was ".$max_num_correct_category."
                </div>";
                $_SESSION["guesses_log"][] = $max_num_correct_words." words correct! The category was ".$max_num_correct_category;
                $_SESSION["correct_categories"][] = $max_num_correct_category;
                $_SESSION["correct_categories"] = array_unique($_SESSION["correct_categories"]);
                foreach ($answer_words as $word) {
                    $_SESSION["correct_words"][] = intval($word);
                }
                if(count($_SESSION["correct_categories"]) >= 4) {
                    $_SESSION["score"] += 1;
                    header("Location: ?command=gameOver");
                }
            }
            else {

                $message = "<div class=\"alert alert-warning\" role=\"alert\">
                ".$max_num_correct_words." words correct!
                </div>";
                $_SESSION["guesses_log"][] = $max_num_correct_words." words correct!";
            }
        }
        else {
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Please Enter an Answer!
                </div>";
        }

        $this->showQuestion($message);
    }


    public function gameOver() { 
        $message = "";
        if (count($_SESSION["correct_categories"]) >= 4) {
            $message = "<div class=\"alert alert-success\" role=\"alert\">
            You won! You got it correct in ".$_SESSION["num_guesses"]." guesses
            </div>";
        }
        else {
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
            You lose! You made ".$_SESSION["num_guesses"]." guesses
            </div>";
        }
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $score = $_SESSION["score"];
        $categories = $_SESSION["categories"];
        include("/opt/src/connections/templates/gameOver.php");
    }

    public function resetGame() {
        $_SESSION["guesses_log"] = [];
        $_SESSION["num_guesses"] = 0;
        $_SESSION["words"] = [];
        $_SESSION["correct_categories"] = [];
        $_SESSION["correct_words"] = [];
        $this->loadQuestions();
        header("Location: ?command=question");
    }

}
