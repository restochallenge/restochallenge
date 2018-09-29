#Resto
Basic api challenge

####Includes
- Model tests
- Api tests
- Model Factories
- Test Data Seeder
- Api resources
- Form Requests
- Custom Validation Rules

###Routes

####GET /api/orders/{order}
Get a specific order
Example url: `/api/orders/1`
####POST /api/orders
Create a new order
Example url: `/api/orders/`
Example data: 
```json
{
    "restaurant_id": 1,
    "menu_items": [1,4,2,5],
    "user_id": 1
}```

####PATCH /api/orders/{order}
Update a given order
Example url: `/api/orders/1`
Example data: 
```json
{
    "restaurant_id": 1,
    "menu_items": [1,4,5,7]
}```
####DELETE /api/orders/{order}
Delete a given order
Example url: `/api/orders/1`
Example data: 
```json
{
    "restaurant_id": 1
}```