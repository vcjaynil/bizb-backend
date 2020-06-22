# API Docs

---

- [Login](#login)
- [Register](#register)
- [Email verification](#email-verification)
- [Change password](#change-password)
- [OTP Verification for reset password](#forgot-password-check-otp)
- [Reset password](#reset-password)
- [Login via linkedin](#social-login)
- [Set four digits pin](#set-mpin)
- [Login with pin](#mpin-login)
- [Change pin](#change-mpin)

<a name="login"></a>
## Login

Details for login api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI       | Headers   |
| :         |   :-      |  :        |
| POST      | `/login`  | Default   |

### URL Params

```php
None
```

### Data Params

```php
{
	"email" : "test@bizb.com",
	"password":"Test@123"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "token": "1|YzKlgiGDdCLyQsYBHCsXFBR6AqbyTnBi71b6hYyNvM7zoRTjstRKjs4PWvJbXisL63JIEP9gyRygAjL1",
    "user": {
        "id": 1,
        "name": "Test",
        "email": "test@bizb.com"
    }
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "These credentials do not match our records."
}
```

<a name="register"></a>
## Register

Details for Registration api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI           | Headers   |
| :         |   :-          |  :        |
| POST      | `/register`   | Default   |

### URL Params

```php
None
```

### Data Params

```php
{
    "name":"Bizb Test",
    "email":"test@bizb.com",
    "password":"Test@123",
    "password_confirmation":"Test@123"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "user": {
        "id": 1,
        "name": "Bizb Test",
        "email": "test@bizb.com"
    },
    "message": "Registered successfully!"
}
```

> {danger} Unauthenticated Response

####Code `400`
####Content
```php
{
    "message": "Validation message will come in this"
}
```

<a name="email-verification"></a>
## Email verification

Details for Email verification through OTP api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                       | Headers   |
| :         |   :-                      |  :        |
| POST      | `/email-verification`     | Default   |

### URL Params

```php
None
```

### Data Params

```php
{
    "otp":232938,
    "email":"test@bizb.com"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "token": "1|ghlYcOdtcTpVPW75YuDmY7ra4lmIHe0vlRS5NApIGh62BvHA0OOhe1adBUmFTLUEcBb4bnrV6Al8AMuR",
    "user": {
        "id": 1,
        "name": "Bizb Test",
        "email": "test@bizb.com"
    },
    "message": "OTP verification successful!",
    "success": true
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "Invalid OTP!",
    "success": false
}
```

<a name="change-password"></a>
## Change password 

Details for change password api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                       | Headers                           |
| :         |   :-                      |  :                                |
| POST      | `/user/change-password`   | Authorization : Bearer {token}    |

### URL Params

```php
None
```

### Data Params

```php
{
    "current_password":"Test@123",
    "password":"Test@321",
    "password_confirmation":"Test@321"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "Password changed successfully!"
}
```

> {danger} Unauthenticated Response

####Code `422`
####Content
```php
{
    "message": "Current password does not matched!"
}
```

<a name="forgot-password"></a>
## Forgot password 

Details for Forgot password api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                       | Headers    |
| :         |   :-                      |  :         |
| POST      | `/forgot-password`        | Default    |

### URL Params

```php
None
```

### Data Params

```php
{
    "email":"test@bizb.com"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "OTP Sent successfully to your mail!",
    "success": true
}
```

> {danger} Unauthenticated Response

####Code `400`
####Content
```php
{
    "message": "Something went wrong",
    "success": false
}
```

<a name="forgot-password-check-otp"></a>
## Reset password OTP verification 

Details for reset password OTP verification api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                           | Headers    |
| :         |   :-                          |  :         |
| POST      | `/forgot-password/check-otp`  | Default    |

### URL Params

```php
None
```

### Data Params

```php
{
    "email":"test@bizb.com",
    "otp":004326
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "OTP verification successful!",
    "success": true
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "Invalid OTP!",
    "success": false
}
```

<a name="reset-password"></a>
## Reset password 

Details for Reset password api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                | Headers    |
| :         |   :-               |  :         |
| POST      | `/reset-password`  | Default    |

### URL Params

```php
None
```

### Data Params

```php
{
    "email":"test@bizb.com",
    "password":"Test@321",
    "password_confirmation":"Test@321"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "Password reset successfully!",
    "success": true
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "Password reset failed!",
    "success": false
}
```

<a name="social-login"></a>
## Login via LinkedIn 

Details for Login via LinkedIn api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                | Headers    |
| :         |   :-               |  :         |
| POST      | `/social-login`    | Default    |

### URL Params

```php
None
```

### Data Params

```php
{
    "email":"test@bizb.com",
    "id":"12345",
    "provider":"linkedin",
    "name":"Bizb test"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "Password reset successfully!",
    "success": true
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "Password reset failed!",
    "success": false
}
```

<a name="set-mpin"></a>
## Set four digits pin

Details for set four digits pin api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                       | Headers                           |
| :         |   :-                      |  :                                |
| POST      | `/user/set-mpin`          | Authorization : Bearer {token}    |

### URL Params

```php
None
```

### Data Params

```php
{
    "mpin":1234,
    "confirm_mpin":1234
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "Pin generate successfully!"
}
```

> {danger} Unauthenticated Response

####Code `422`
####Content
```php
{
    "message": "The confirm mpin and mpin must match.",
    "status_code": 422
}
```

<a name="mpin-login"></a>
## Login with four digits pin

Details for the login with four digits pin api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                       | Headers   |
| :         |   :-                      |  :        |
| POST      | `/mpin-login`             |  default  |

### URL Params

```php
None
```

### Data Params

```php
{
    "mpin":1234,
    "email":"test@bizb.com"
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "token": "1|ghlYcOdtcTpVPW75YuDmY7ra4lmIHe0vlRS5NApIGh62BvHA0OOhe1adBUmFTLUEcBb4bnrV6Al8AMuR",
    "user": {
        "id": 1,
        "name": "Bizb Test",
        "email": "test@bizb.com"
    }
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "Pin is not valid"
}
```

<a name="change-mpin"></a>
## Change four digits pin

Details for the change four digits pin api
##
##

####Endpoint

> {warning} Please note that the URI for this endpoint only should not include api/{$version} before 

| Method    | URI                   | Headers   |
| :         |   :-                  |  :        |
| POST      | `/user/change-mpin`   | Default   |

### URL Params

```php
None
```

### Data Params

```php
{
    "old_mpin" : 1234
    "mpin":4321,
    "confirm_mpin":4321
}
```

> {success} Success Response

####Code `200`
####Content
```php
{
    "message": "Pin updated successfully!"
}
```

> {danger} Unauthenticated Response

####Code `401`
####Content
```php
{
    "message": "Old Pin is wrong!"
}
```
