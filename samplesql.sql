
SELECT
    id,
    name,
    price,
    ROUND(price / total.total_price * 700, 2) AS discount
FROM
    products,
    (SELECT SUM(price) AS total_price FROM products) AS total;