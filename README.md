# Phalcon-Encryption
Add encryption to your PhalconPHP application.

# Prerequisites
- **Key** model {id, iv, key}
- Model saving the **keysId**
- Second security database for storing the keys and initialization vectors.

## Encryption
You can encrypt data with a single line of code when a model has a keysId available.
```php
Cryptography::Encrypt($data, $keysId);
```

Example:
```php
public function setData($data)
{
    $encrypt = Cryptography::Encrypt(json_encode($data), $this->keysId);
    $this->keysId = $encrypt->keysId;
    return = $this->data = $encrypt->data;
}
```

## Decryption
Decryption is just as easy data with a single line of code when a model has a keysId available.
```php
Cryptography::Decrypt($data, $keysId);
```

Example:
```php
public function getData()
{
    return json_decode(Cryptography::Decrypt($this->data, $this->keysId));
}
```
