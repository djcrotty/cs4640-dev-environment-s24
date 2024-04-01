<?php

class CategoryGameController {

    private $questions = [];

    // An error message to display on the welcome page
    private $errorMessage = "";

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start(); // start a session!
        
        // Set input
        $this->input = $input;

        $this->loadQuestions();
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

        // NOTE: UPDATED 3/29/2024!!!!!
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
        $this->questions = json_decode(
            file_get_contents("/opt/src/connections.json"), true);

        if (empty($this->questions)) {
            die("Something went wrong loading questions");
        }
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
     * Our getQuestion function, now as a method!
     */
    public function getQuestion($id=null) {

        // If $id is not set, then get a random question
        // We wrote this in class.
        if ($id === null) {
            // Read ONE random question from the database
            $qn = $this->db->query("select * from questions order by random() limit 1;");

            // The query function calls pg_fetch_all, which returns an **array of arrays**.
            // That means that if we only have one row in our result, it's an array at
            // position 0 of the array of arrays.
            // Note: we should check that $qn here is _not_ false first!
            return $qn[0];
        }
        
        // If an $id **was** passed in, then we should get that specific
        // question from the database.
        //
        // NOTE: We did **not** write this in class, but it is provided/updated
        // below:
        if (is_numeric($id)) {
            $res = $this->db->query("select * from questions where id = $1;", $id);
            if (empty($res)) {
                return false;
            }
            return $res[0];
        }
       
        // Anything else, just return false
        return false;
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
        $question = $this->getQuestion();
        include("/opt/src/trivia/templates/question.php");
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
        if (isset($_POST["questionid"]) && is_numeric($_POST["questionid"])) {

            $question = $this->getQuestion($_POST["questionid"]);

            if (strtolower(trim($_POST["answer"])) == strtolower($question["answer"])) {
                $message = "<div class=\"alert alert-success\" role=\"alert\">
                    Correct!
                    </div>";
                // Update the score in the session
                $_SESSION["score"] += 10;

                // **NEW**: We'll update the user's score in the database, too!
                $this->db->query("update users set score = $1 where email = $2;", 
                                    $_SESSION["score"], $_SESSION["email"]);
            }
            else {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                    Incorrect! The correct answer was: {$question["answer"]}
                    </div>";
            }
        }

        $this->showQuestion($message);
    }

}
