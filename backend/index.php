<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/error/Error.Class.php';
    require_once __DIR__ . '/controller/Auth.controller.php';
    require_once __DIR__ . '/middleware/Auth.middleware.php';
    require_once __DIR__ . '/middleware/Generation.middleware.php';
    require_once __DIR__ . '/middleware/Cors.middleware.php';
    require_once __DIR__ . '/controller/Workout.controller.php';
    require_once __DIR__ . '/controller/Progress.controller.php';
    require_once __DIR__ . '/controller/Log.controller.php';
    require_once __DIR__ . '/include/Genai.php';

    use Dotenv\Dotenv;
    use Bramus\Router\Router;


    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // Initialize the router;

    $conn = connectDB();
    
    // ConnectionMiddleware::allowConnection();

    $cors = new Cors();
    $cors->handleCors();


    $router = new Router();


    
    // Middlewares
    $authMiddleware = new AuthMiddleware($conn);

    // Define routes

    $router->get('/', function(){
        echo "Hello World! AfterBurn (server) is running.";
    });

    // Auth controller ka object create kr raha hon;

    $authController = new AuthController($conn);

    //  Main routes;
    
    // Auth Routes for authentication;
    // Register user
    $router->post('/api/v1/auth/register', function() use ($authController) {
        $request = json_decode(file_get_contents("php://input"), true);
        $response = $authController->register($request);
        header("Content-Type: application/json");
        echo $response;
        exit;
    });

    // Login user
    $router->post('/api/v1/auth/login', function() use ($authController){
        $request = json_decode(file_get_contents("php://input"), true);
        $response = $authController->login($request);
        header("Content-Type: application/json");
        echo $response;
        exit;
    });

    $router->get('/api/v1/user', function() use ($authController){
        $headers = getallheaders();
        if(isset($headers['Token'])){
            $token = $headers['Token'];
            $res = $authController->getUser($token);
            echo $res;
            exit;
        }else{
            http_response_code(404);
            $err = new ErrorHandler("No token provided.", 404);
            echo json_encode($err->throwError());
            exit;
        }
    });

    // Workout routes

    // Workout controller ka object create kr raha hon

    $workout = new WorkoutController($conn);

    // Generate workout

    $router->post('/api/v1/workout', function () use($workout, $authMiddleware){
        $headers = getallheaders();
        if(isset($headers['Token'])){
            $token = $headers['Token'];
            $user = $authMiddleware->getUser($token);
            $res = $workout->saveWorkout( $token, $user);
            header("Content-Type: application/json");
            echo $res;
            exit;
        }else{
            http_response_code(404);
            $err = new ErrorHandler("No token provided.", 404);
            echo json_encode($err->throwError());
            exit;
        }
    });

    // Get Workout

    $router->get('/api/v1/workout', function() use ($workout){
        $headers = getallheaders();
        if(isset($headers['Token'])){
            $token = $headers['Token'];
            $res = $workout->getWorkout($token);
            echo $res;
            exit;
        }else{
            http_response_code(404);
            $err = new ErrorHandler("Token not provided", 404);
            echo json_encode($err->throwError());
            exit;
        }
    });

    // Get Diet

    $router->get('/api/v1/diet', function() use ($workout){
        $headers = getallheaders();
        if(isset($headers['Token'])){
            $token = $headers['Token'];
            $res = $workout->getDiet($token);
            echo $res;
            exit;
        }else{
            http_response_code(404);
            $err = new ErrorHandler("Token not provided", 404);
            echo json_encode($err->throwError());
            exit;
        }
    });

    $progressController = new ProgressController($conn);

    // Progress Route

    // Get weekly progress
    $router->get('/api/v1/progress/{week}', function($week) use ($progressController) {
        $response  = $progressController->getProgressByWeek($week);
        echo $response;
        exit;
    });

    // Get all progress
    $router->get('api/v1/progress', function() use ($progressController){
        $response = $progressController->getAllProgress();
        echo $response;
        exit;
    });

    // save progress
    $router->post('/api/v1/progress', function() use ($progressController){
        $request = file_get_contents('php://input');
        $response = $progressController->saveProgress($request);
        echo $response;
        exit;
    });

    $logController = new LogController($conn);

    // Log routes

    // Save Logs
    $router->post('/api/v1/logs', function() use ($logController){
        $request = json_decode(file_get_contents('php://input'), true);
        $response = $logController->saveLogs($request);
        echo $response;
        exit;
    });

    // Get logs
    $router->get('/api/v1/logs', function() use($logController){
        $response = $logController->getLogs();
        echo $response;
        exit;
    });

    $router->run();

?>