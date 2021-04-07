<?php
include 'AES.php';

$imputText = "My text to encrypt.";
$imputKey = "key";
$blockSize = 256;
$aes = new \Sec\AES\AES($imputText, $imputKey, $blockSize);

$enc = $aes->encrypt();
$aes->setData($enc);
$dec = $aes->decrypt();
echo "After encryption: ".$enc."<br/>";
echo "After decryption: ".$dec."<br/>";

$imputText1 = "My text to encrypt.!";
$imputKey1 = "key1rrtrt";

$aes = new \Sec\AES\AES($imputText1, $imputKey1, $blockSize);

$enc = $aes->encrypt();
$aes->setData($enc);
$dec=$aes->decrypt();

echo "After encryption: ".$enc."<br/>";
echo "After decryption: ".$dec."<br/>";
?>
