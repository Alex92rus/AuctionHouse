<?php

// Root directory
$root = $_SERVER['DOCUMENT_ROOT'];

// Database
defined( "DB_HOST" ) ? null : define( "DB_HOST", "localhost" );
defined( "DB_USER" ) ? null : define( "DB_USER", "root" );
defined( "DB_PASSWORD" ) ? null : define( "DB_PASSWORD", "root" );
defined( "DB_NAME" ) ? null : define( "DB_NAME", "auctionsystem" );
defined( "DB_PORT" ) ? null : define( "DB_PORT", 3306 );

// Email server
defined( "EMAIL_DEBUG" ) ? null : define( "EMAIL_DEBUG", "html" );
defined( "EMAIL_ENCRYPTION" ) ? null : define( "EMAIL_ENCRYPTION", "tls" );
defined( "EMAIL_HOST" ) ? null : define( "EMAIL_HOST", "smtp.gmail.com" );
defined( "EMAIL_USER" ) ? null : define( "EMAIL_USER", "auction.house.ucl@gmail.com" );
defined( "EMAIL_PASSWORD" ) ? null : define( "EMAIL_PASSWORD", "Bidder2016!" );
defined( "EMAIL_SMTP" ) ? null : define( "EMAIL_SMTP", 587 );

// Tables


// Table attributes


// Upload
defined( "UPLOAD_PROFILE_IMAGE" ) ? null : define( "UPLOAD_PROFILE_IMAGE", $root . "/uploads/profile_images/" );
defined( "UPLOAD_ITEM_IMAGE" ) ? null : define( "UPLOAD_ITEM_IMAGE", $root . "/uploads/item_images/" );