<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * The exercise cannot be given to students yet. The message is a translation key.
 */
class ExerciseNotReadyException extends RuntimeException {}
