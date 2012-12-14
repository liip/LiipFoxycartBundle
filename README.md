# Liip Foxycart Bundle

Provides integration with Foxycart

Work in progress, currently it just provides a twig extension:

To render the foxycart css/js:
```jinja
{{ foxycart_head() }}
```

To render a cart link with hmac encoded parameters:
```jinja
{{ foxycart_link_cart({'code': 'sku123', 'name': 'My article', 'price': 22.25}) }}
```

