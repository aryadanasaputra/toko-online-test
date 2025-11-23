# TODO: Create User Data in Master Schema and Transaction Data in Transactions Schema

## Steps to Complete

- [ ] Modify config/database.php to add 'master' and 'transactions' connections using PostgreSQL with appropriate search_path.
- [ ] Create a new migration to create the master and transactions schemas.
- [ ] Modify database/migrations/0001_01_01_000000_create_users_table.php to use 'master' connection.
- [ ] Modify database/migrations/2025_11_13_070706_create_categories_table.php to use 'master' connection.
- [ ] Modify database/migrations/2025_11_13_070751_create_products_table.php to use 'master' connection.
- [ ] Modify database/migrations/2025_11_13_070928_create_orders_table.php to use 'transactions' connection.
- [ ] Modify database/migrations/2025_11_13_071056_create_order_items_table.php to use 'transactions' connection.
- [ ] Modify database/migrations/2025_11_13_071135_create_payments_table.php to use 'transactions' connection.
- [ ] Update app/Models/User.php to use 'master' connection.
- [ ] Update app/Models/Category.php to use 'master' connection.
- [ ] Update app/Models/Product.php to use 'master' connection.
- [ ] Update app/Models/Order.php to use 'transactions' connection.
- [ ] Update app/Models/OrderItem.php to use 'transactions' connection.
- [ ] Update app/Models/Payment.php to use 'transactions' connection.
- [ ] Update database/seeders/DatabaseSeeder.php to include sample transaction data (orders, order_items, payments).

## Followup Steps
- [ ] Run the create_schemas migration.
- [ ] Run migrations for each connection.
- [ ] Run seeders to populate data.
- [ ] Ensure .env is configured for PostgreSQL.
