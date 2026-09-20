<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * The AI provider could not produce a usable reply (network error, HTTP error, empty answer,
 * or no API key configured).
 */
class AiUnavailableException extends RuntimeException {}
