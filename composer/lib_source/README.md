# PHP security patch
Validate filename before use in header. 
### Example
```php
$filename = 'filename example.txt';
$filename = Evgenysmrnv\Security\SecurityPatch::checkHttpHeader($filename); 
$httpHeaderExample = 'Content-Disposition: attachment; filename=" . $filename . "';
```