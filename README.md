### Get parameters for pagination

- GET /api/products?limit=5&page=2

### Get parameters for sorting

- GET /api/products?sort_by=id&order_by=desc

### Get parameters for filtering

- GET /api/products?price_min=10&price_max=50
- GET /api/products?active=0

### Archiving endpoint

- PUT /api/products/:id/archive (required attributes: active (bool) )
