<?php

// Website url
defined( "URL" ) ? null : define( "URL", "http://localhost:8888/" );

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

// Upload
defined( "ROOT" ) ? null : define( "ROOT", $_SERVER['DOCUMENT_ROOT'] );
defined( "UPLOAD_PROFILE_IMAGE" ) ? null : define( "UPLOAD_PROFILE_IMAGE", "/images/profile_images/" );
defined( "UPLOAD_ITEM_IMAGE" ) ? null : define( "UPLOAD_ITEM_IMAGE", "/images/item_images/" );