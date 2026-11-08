<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * The AI read the uploaded test but found no question it could turn into an exercise.
 */
class NothingToReadException extends RuntimeException {}
