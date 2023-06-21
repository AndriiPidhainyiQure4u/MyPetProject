
Run in terminal `make up`

Sample API request:

```
curl --location --request POST 'http://localhost/api/v1/auth/signUp' \
--header 'content-type: application/json' \
--data-raw '{
    "fisrstName: "vasya", "lastName": "tester", "email": "test@1test.com", "password": "12345678", "confirmPassword": "12345678"
}'
```

```
curl --location --request GET 'http://localhost/api/v1/book/categories'
```
