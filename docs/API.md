# DPO ERP API

Base path: `/api/v1`

Authentication uses Laravel Sanctum bearer tokens.

## Login

`POST /api/auth/login`

```json
{
  "email": "admin@dpoerp.test",
  "password": "password"
}
```

Response envelope:

```json
{
  "success": true,
  "message": "Authenticated.",
  "data": {
    "token": "...",
    "user": {}
  },
  "meta": {}
}
```

## Resources

- `GET /api/v1/employees`
- `GET /api/v1/customers`
- `GET /api/v1/tasks`
- `GET /api/v1/reports`

Legacy unversioned endpoints remain available for backward compatibility.
