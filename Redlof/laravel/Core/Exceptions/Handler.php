<?php
namespace Exceptions;

use Exception;
use Exceptions\ActionFailedException;
use Exceptions\EntityAlreadyExistsException;
use Exceptions\EntityNotFoundException;
use Exceptions\EntryCreationFailed;
use Exceptions\InvalidCredentialsException;
use Exceptions\UnAuthorizedException;
use Exceptions\ValidationFailedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        UnAuthorizedException::class,
        ValidationFailedException::class,
        InvalidCredentialsException::class,
        NotFoundHttpException::class,
        EntityNotFoundException::class,
        ActionFailedException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {

        if ($this->shouldReport($e) && env('ECHOZA_ENABLE', FALSE)) {
            $this->sendEmail($e); // sends an email
        }

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        //return $e->getContent();

        $this->cleanOutput();

        $err['status'] = 500;
        $err['message'] = 'Something has gone wrong';
        $hasHandled = false;

        if ($e instanceof ValidationFailedException) {

            // status
            // message
            // response array
            $hasHandled = true;
            $err['status'] = $this->getStatus($e);
            $err['message'] = $e->getMessage();

            $msgArray = $e->getResponse();

            return response()
                ->json(['msg' => $err['message'], 'error' => true, 'msgArray' => $msgArray], $err['status']);

        }

        // if ($e instanceof StateNotFoundException) {

        //     $hasHandled = true;
        //     return redirect()->route('home.get');
        // }

        switch ($e) {

            case ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException):
                $hasHandled = true;
                $err['status'] = $e->getStatusCode();
                $err['message'] = 'Token has Expired';
                break;

            case ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException):
                $hasHandled = true;
                $err['status'] = $e->getStatusCode();
                $err['message'] = 'Token in invalid';
                break;

            case ($e instanceof ActionFailedException):
            case ($e instanceof UnAuthorizedException):
            case ($e instanceof EntityAlreadyExistsException):
            case ($e instanceof EntityNotFoundException):
            case ($e instanceof InvalidCredentialsException):
            case ($e instanceof EntryCreationFailed):
            case ($e instanceof TPLFailedException):
            case ($e instanceof InvalidArgumentException):

                $hasHandled = true;
                $err['status'] = $this->getStatus($e);
                $err['message'] = $e->getMessage();
                break;
        }

        $Data['title'] = 'Error';
        $Data['error'] = $err;

        if ($hasHandled) {
            if (!$request->wantsJson()) {
                return response()
                    ->view('page::static.error', $Data, $err['status'])
                    ->header('Content-Type', 'text/html');
            } else {

                return response()
                    ->json(['msg' => $err['message'], 'error' => true], $err['status']);
            }
        }

        //As to preserve the catch all
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view('page::static.error404');
        } elseif ($this->isHttpException($e)) {
            return response()
                ->view('page::static.error', $Data, $err['status'])
                ->header('Content-Type', 'text/html');
        }

        // For Whoops
        elseif (config('app.debug')) {

            return $this->renderExceptionWithWhoops($e);
        }

        if ($request->is('api/*')) {

            $err['status'] = $this->getStatus($e);

            if (config('app.debug')) {
                $err['message'] = $e->getMessage();
            } else {
                $err['message'] = "We are facing a glitch in performing this action. Please try after sometime.";
            }

            return response()
                ->json(['msg' => $err['message'], 'error' => true], $err['status']);
        }

        // Catch all
        //return parent::render($request, $e);
        return response()
            ->view('page::static.error', $Data, $err['status'])
            ->header('Content-Type', 'text/html');
    }

    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }

    private function cleanOutput()
    {

        // Never, ever, use environment variables in responses, not even when debugging
        $_SERVER = array_except($_SERVER, array_keys($_ENV));

        $_SERVER = array_except($_SERVER, [
            'SERVER_SIGNATURE',
            'DOCUMENT_ROOT',
            'SCRIPT_FILENAME',
            'SCRIPT_NAME',
            'SERVER_ADMIN',
            'CONTEXT_DOCUMENT_ROOT',
            'HTTP_COOKIE',
            '',
        ]);

        $_ENV = [];
    }

    private function getStatus($e)
    {
        $Status = 500;
        $Code = $e->getCode();

        if ($Code && $e->getCode() != 0) {
            $Status = $e->getCode();
        }

        return $Status;
	}
	
	private function sendEmail(Exception $exception) {

		try {
			
			$e = FlattenException::create($exception);

			$handler = new SymfonyExceptionHandler();

			$html['error'] = $handler->getHtml($e);

			$html['source'] = config('app.env');
			$html['host'] = $_SERVER['HTTP_HOST'];

			\MailHelper::sendSyncMail('page::emails.echoza', $e->getMessage(), 'echoza@think201.com', $html);

		} catch (Exception $ex) {

		}
	}

}
