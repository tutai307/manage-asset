<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Students have already worked on it, so deleting it would lose their results. The message is a
 * translation key.
 */
class StillInUseException extends RuntimeException {}
