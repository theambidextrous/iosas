<?php
include('server/track_no_generator.php');

use Utils\RandomStringGenerator;

// Create new instance of generator class.
$generator = new RandomStringGenerator;

// Set token length.
$tokenLength = 64;

// Call method to generate random string.
$token = $generator->generate($tokenLength);