<?php

// Root directory
$root = $_SERVER['DOCUMENT_ROOT'];

// Database
defined( "DB_HOST" ) ? null : define( "DB_HOST", "localhost" );
defined( "DB_USER" ) ? null : define( "DB_USER", "root" );
defined( "DB_PASSWORD" ) ? null : define( "DB_PASSWORD", "root" );
defined( "DB_NAME" ) ? null : define( "DB_NAME", "auction_house" );
defined( "DB_PORT" ) ? null : define( "DB_PORT", 8889 );


// Tables
defined( "USERS_TABLE" ) ? null : define( "USERS_TABLE", "users" );


// Upload
defined( "UPLOAD_PROFILE_PATH" ) ? null : define( "UPLOAD_PROFILE_PATH", $root . "/uploads/profile_images/" );
