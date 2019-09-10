<?php
namespace Core;

/**
 * Error and exception handler
 *
 * PHP version 7.0
 */
class Error
{
  /**
   * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
   *
   * @param int $level  Error level
   * @param string $message  Error message
   * @param string $file  Filename the error was raised in
   * @param int $line  Line number in the file
   *
   * @return void
   */
  public static function errorHandler($level, $message, $file, $line)
  {
    if (error_reporting() !== 0) {  // to keep the @ operator working
      throw new \ErrorException($message, 0, $level, $file, $line);
    }
  }

  /**
   * Exception handler.
   *
   * @param Exception $exception  The exception
   *
   * @return void
   */
  public static function exceptionHandler($exception)
  {
      // Code is 404 (not found) or 500 (general error)
      $code = $exception->getCode();

      if ($code != 404) {
        $code = 500;
      }

      httpResponseCode($code);

      echo "<div style='border: solid 8px red; padding: 16px;'>";
      echo "<h1 style='color:red;'>Fatal error</h1>";
      echo "<p>Uncaught exception: <strong>'" . get_class($exception) . "'</strong></p>";
      echo "<p>Message: <strong>'" . $exception->getMessage() . "'</strong></p>";
      echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
      echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
      echo "</div>";
  }
}
