<?php

// Set environment variables for Vercel serverless environment
putenv('VIEW_COMPILED_PATH=/tmp');

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';