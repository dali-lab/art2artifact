<?php
// Bucket Name
$bucket="coindb_profilepictures";
if (!class_exists('S3'))require_once('S3.php');
			
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJZXERSDXSDBNK56Q');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
			
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

?>